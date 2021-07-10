import os
import tempfile
import time

import pytest
from app import create_app
from app.models import LogPost, db


@pytest.fixture(scope='module')
def app():
    db_fd, db_path = tempfile.mkstemp()
    cred_fd, cred_path = tempfile.mkstemp()

    flask_app = create_app({
        'TESTING': True,
        'CRED_FILE': cred_path,
        'SQLALCHEMY_DATABASE_URI': f'sqlite:///{db_path}'
    })

    with flask_app.app_context():
        db.create_all()

    yield flask_app

    os.close(db_fd)
    os.close(cred_fd)
    os.unlink(db_path)
    os.unlink(cred_path)


@pytest.fixture(autouse=True)
def app_context(app):
    with app.app_context():
        yield app


@pytest.fixture
def client(app_context):
    return app_context.test_client()


@pytest.fixture
def authenticated_client(client):
    with client.session_transaction() as session:
        session['authed'] = True
    return client


@pytest.fixture
def log_post_title():
    return f'titleTITLEaTIELE___{time.time()}'


@pytest.fixture
def log_post_content():
    return 'contentCONTENT___CONTENT'


@pytest.fixture
def log_post_md_content():
    return f'# HeadingHEADING___{time.time()}'


@pytest.fixture
def log_post(log_post_title, log_post_content):
    new_log_post = LogPost(log_post_title, log_post_content, False)

    db.session.add(new_log_post)
    db.session.commit()

    yield new_log_post

    if LogPost.query.filter_by(id=new_log_post.id).first():
        db.session.delete(new_log_post)
        db.session.commit()


@pytest.fixture
def md_log_post(log_post_title, log_post_md_content):
    new_log_post = LogPost(log_post_title, log_post_md_content, True)

    db.session.add(new_log_post)
    db.session.commit()

    yield new_log_post

    if LogPost.query.filter_by(id=new_log_post.id).first():
        db.session.delete(new_log_post)
        db.session.commit()
