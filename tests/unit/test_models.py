import datetime

from app.models import LogPost, db


def test_create_log_post(log_post):
    assert log_post.title == 'title'
    assert log_post.content == 'content'

    assert type(log_post.id) is str
    assert len(log_post.id) == 36

    assert type(log_post.created) == datetime.datetime
    assert type(log_post.last_updated) == datetime.datetime
    assert log_post.created.isocalendar() \
        == log_post.last_updated.isocalendar()

    assert log_post.is_markdown is False


def test_edit_log_post_last_updated(log_post):
    old_last_updated = log_post.last_updated
    log_post.set_last_updated()

    db.session.commit()

    log_post = LogPost.query.filter_by(id=log_post.id).first()
    assert log_post.last_updated != old_last_updated
