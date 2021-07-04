import datetime

from app.models import LogPost, db


def test_log_post(new_log_post):
    assert new_log_post.title == 'title'
    assert new_log_post.content == 'content'
    assert type(new_log_post.id) is str
    assert len(new_log_post.id) == 36


def test_create_log_post(new_log_post):
    db.session.add(new_log_post)
    db.session.commit()

    new_log_post = LogPost.query.filter_by(id=new_log_post.id).first()

    assert new_log_post is not None
    assert type(new_log_post.created) == datetime.datetime
    assert type(new_log_post.last_updated) == datetime.datetime
    assert new_log_post.created == new_log_post.last_updated
