from app.utils import filters


def test_md_to_html():
    assert '<h1>' in filters.md_to_html('# Hello World')
