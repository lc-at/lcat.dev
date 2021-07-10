import pytest
from app.models import User


@pytest.mark.parametrize(('test_input', 'expected_message'), (
    ('an invalid one', b'Invalid password'),
    ('password', b'Authentication successful'),
))
def test_post_admin_login(client, test_input, expected_message):
    rv = client.post('/administrator/login',
                     data={'password': test_input},
                     follow_redirects=True)
    assert expected_message in rv.data


def test_admin_login_joke(client):
    User.change_password('a new strong password')
    rv = client.post('/administrator/login',
                     data={'password': 'password'},
                     follow_redirects=True)
    assert b'No, not this time' in rv.data
    User.change_password('password')


def test_get_admin_login(client):
    rv = client.get('/administrator/login')
    assert b'<h3>Authentication' in rv.data


def test_get_authenticated_admin_login(authenticated_client):
    rv = authenticated_client.get('/administrator/login')
    assert rv.status_code == 302


@pytest.mark.parametrize('uri', (
    'logout',
    'change-password',
    'delete-log/id',
    'edit-log/id',
))
def test_login_required(client, uri):
    for method in ('get', 'post'):
        rv = getattr(client, method)(f'/administrator/{uri}')
        assert rv.status_code in (302, 405)
        if rv.status_code == 302:
            assert rv.location.endswith('/administrator/login')


def test_authenticated_home(authenticated_client, log_post):
    rv = authenticated_client.get('/')
    assert rv.status_code == 200
    assert log_post.title.encode() in rv.data
    assert b'>Write' in rv.data
    assert b'Change Password' in rv.data
    assert b'edit' in rv.data
    assert b'delete' in rv.data


def test_write_log_post(authenticated_client, log_post_title,
                        log_post_content):
    rv = authenticated_client.get('/administrator/write-log')
    assert rv.status_code == 200
    assert b'<form' in rv.data
    assert b'<input' in rv.data
    assert b'<textarea' in rv.data
    assert b'<button' in rv.data

    rv = authenticated_client.post('/administrator/write-log',
                                   data={
                                       'title': log_post_title,
                                       'content': log_post_content,
                                   },
                                   follow_redirects=True)
    assert rv.status_code == 200
    assert log_post_title.encode() in rv.data

    for title, content in (('x', ''), ('', 'x'), ('', '')):
        rv = authenticated_client.post('/administrator/write-log',
                                       data={
                                           'title': title,
                                           'content': content,
                                       },
                                       follow_redirects=True)
        assert rv.status_code == 403


def test_edit_log_post(authenticated_client, log_post):
    rv = authenticated_client.get(f'/administrator/edit-log/{log_post.id}')
    assert rv.status_code == 200
    assert b'<form' in rv.data
    assert b'<input' in rv.data
    assert b'<textarea' in rv.data
    assert b'<button' in rv.data

    old_last_updated = log_post.last_updated

    rv = authenticated_client.post(f'/administrator/edit-log/{log_post.id}',
                                   data={
                                       'title': 'new title',
                                       'content': '# content',
                                       'is_md': 'yes'
                                   },
                                   follow_redirects=True)
    assert rv.status_code == 200
    assert b'Updated log post' in rv.data
    assert b'new title' in rv.data
    assert log_post.last_updated > old_last_updated
    assert log_post.title == 'new title'
    assert log_post.content == '# content'
    assert log_post.is_markdown is True

    for title, content in (('x', ''), ('', 'x'), ('', '')):
        rv = authenticated_client.post(
            f'/administrator/edit-log/{log_post.id}',
            data={
                'title': title,
                'content': content,
            },
            follow_redirects=True)
        assert rv.status_code == 403


def test_delete_log_post(authenticated_client, log_post):
    rv = authenticated_client.get(f'/administrator/delete-log/{log_post.id}',
                                  follow_redirects=True)
    assert rv.status_code == 200
    assert b'Deleted log post' in rv.data
    assert log_post.title.encode() not in rv.data


@pytest.mark.parametrize(
    ('status_code', 'new_password', 'confirmed_new_password',
     'expected_message'),
    ((200, 'new password', 'new password', 'Password changed.'),
     (200, 'new password', 'new unconfirmed password', 'Password unchanged.'),
     (403, '', 'x', ''), (403, 'x', '', ''), (403, '', '', '')))
def test_change_password(authenticated_client, status_code, new_password,
                         confirmed_new_password, expected_message):
    rv = authenticated_client.get('/administrator/change-password')
    assert rv.status_code == 200
    assert b'<form' in rv.data
    assert b'<input' in rv.data
    assert b'<button' in rv.data

    rv = authenticated_client.post('/administrator/change-password',
                                   data={
                                       'new_password':
                                       new_password,
                                       'confirm_new_password':
                                       confirmed_new_password
                                   },
                                   follow_redirects=True)
    assert rv.status_code == status_code
    assert expected_message.encode() in rv.data


def test_logout(authenticated_client):
    rv = authenticated_client.get('/administrator/logout',
                                  follow_redirects=True)
    assert rv.status_code == 200
    assert b'Change Password' not in rv.data
