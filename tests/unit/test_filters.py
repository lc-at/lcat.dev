from app.utils import filters


def test_md_to_html():
    assert '<h1>' in filters.md_to_html('# Hello World')

def test_log_id_autoref(app_context, log_post):
    partial_id = log_post.id[:5]
    test_list = [
        f'{partial_id}',
        f'lorem {partial_id} ipsum',
        f'{partial_id} ipsum',
        f'\n{partial_id} lorem'
    ]
    for test_str in test_list:
        with app_context.test_request_context():
            assert log_post.id in filters.log_id_autoref(test_str)
