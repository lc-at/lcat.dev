import pytest
from app import create_app
from app.models import LogPost


@pytest.fixture(scope='module')
def client():
    flask_app = create_app()
    with flask_app.test_client() as testing_client:
        with flask_app.app_context():
            yield testing_client



@pytest.fixture(scope='module')
def new_log_post():
    log_post = LogPost('title', 'content', False)
    return log_post
