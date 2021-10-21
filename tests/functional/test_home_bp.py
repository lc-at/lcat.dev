import marko


def test_empty_home(client):
    rv = client.get('/')
    assert b'download' not in rv.data
    assert rv.status_code == 200


def test_home_content(client, log_post, md_log_post, pinned_log_post):
    rv = client.get('/')
    assert rv.status_code == 200

    for p in [log_post, md_log_post, pinned_log_post]:
        assert p.title.encode() in rv.data
        assert p.created.isoformat().encode() in rv.data

    for link_text in [b'download', b'view', b'raw']:
        assert link_text in rv.data

    assert rv.data.find(pinned_log_post.id.encode()) < rv.data.find(
        log_post.id.encode())
    assert rv.data.find(pinned_log_post.id.encode()) < rv.data.find(
        md_log_post.id.encode())
    assert rv.data.find(md_log_post.id.encode()) < rv.data.find(
        log_post.id.encode())

    assert b'edit' not in rv.data
    assert b'delete' not in rv.data


def test_view_md_formatted_log(client, log_post, md_log_post):
    for p in [log_post, md_log_post]:
        rv = client.get(f'/log/{p.id}')
        assert rv.status_code == 200

        if p.is_markdown:
            assert marko.convert(p.content).encode() in rv.data
        else:
            assert p.content.encode() in rv.data

        for field in ['id', 'title']:
            assert getattr(p, field).encode() in rv.data

        for field in ['created', 'last_updated']:
            assert getattr(p, field).isoformat().encode() in rv.data


def test_view_raw_log(client, md_log_post):
    rv = client.get(f'/log/{md_log_post.id}/raw')
    assert rv.status_code == 200
    assert rv.content_type == 'text/plain'
    assert rv.data == md_log_post.content.encode()


def test_download_log(client, log_post):
    rv = client.get(f'/log/{log_post.id}/download')
    assert rv.status_code == 200
    assert rv.content_type == 'application/octet-stream'
    assert log_post.id in rv.headers['Content-Disposition']
    assert rv.data == log_post.content.encode()


def test_search_log(client, log_post):
    rv = client.get('/search')
    assert rv.status_code == 200
    assert b'<h3>Search</h3>' in rv.data

    keywords = [
        log_post.title,
        log_post.id,
        log_post.title[:3],
        log_post.title[4:],
        log_post.content,
        log_post.content[:3],
        log_post.content[4:],
    ]

    for keyword in keywords:
        rv = client.get(f'/search?keyword={keyword}')
        assert rv.status_code == 200
        assert keyword.encode() in rv.data

    rv = client.get('/search?keyword=nothing')
    assert rv.status_code == 200
    assert b'<a href="/log/' not in rv.data


def test_contact(app_context, client):
    rv = client.get('/contact')
    assert rv.status_code == 200

    assert b'<h3>Contact</h3>' in rv.data

    for contact in app_context.config['CONTACT_ENTRIES']:
        for field in contact:
            assert field.encode() in rv.data
