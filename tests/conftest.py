import os
import tempfile

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
def request_context(app_context):
    with app_context.test_request_context():
        yield


@pytest.fixture
def client(app_context):
    return app_context.test_client()


@pytest.fixture
def log_post():
    new_log_post = LogPost('title', 'content', False)

    db.session.add(new_log_post)
    db.session.commit()

    yield new_log_post

    db.session.delete(new_log_post)
    db.session.commit()


@pytest.fixture
def md_log_post():
    new_log_post = LogPost('title', '# heading', True)

    db.session.add(new_log_post)
    db.session.commit()

    yield new_log_post

    db.session.delete(new_log_post)
    db.session.commit()
