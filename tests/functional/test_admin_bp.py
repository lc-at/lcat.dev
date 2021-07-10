import pytest


@pytest.mark.parametrize(('test_input', 'expected_message'), (
    ('an invalid one', b'Invalid password'),
    ('password', b'Authentication successful'),
))
def test_post_admin_login(client, test_input, expected_message):
    rv = client.post('/administrator/login',
                     data={'password': test_input},
                     follow_redirects=True)
    assert expected_message in rv.data


def test_get_admin_login(client):
    rv = client.get('/administrator/login')
    assert b'<h3>Authorization' in rv.data


@pytest.mark.parametrize('uri', (
    'logout',
    'change-password',
))
def test_login_required(client, uri):
    rv = client.get(f'/administrator/{uri}')
    assert rv.status_code == 302
    assert rv.location.endswith('/administrator/login')


@pytest.mark.parametrize('uri', ('delete-log', 'edit-log'))
def test_login_required_for_log_altering(client, log_post, uri):
    rv = client.get(f'/administrator/{uri}/{log_post.id}')
    assert rv.status_code == 302
    assert rv.location.endswith('/administrator/login')
