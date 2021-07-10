from hashlib import sha512

from app.models import User


def test_authenticate(app):
    assert User.authenticate('password') is True
    assert User.authenticate('') is False
    with open(app.config['CRED_FILE']) as f:
        hashed_password = sha512(b'password').hexdigest()
        hashed_password_in_db = f.read()
        assert hashed_password == hashed_password_in_db
    assert User.authenticate('password') is True


def test_change_password(app):
    assert User.change_password('') is False
    assert User.change_password('new password')
    with open(app.config['CRED_FILE']) as f:
        hashed_password = sha512(b'new password').hexdigest()
        hashed_password_in_db = f.read()
        assert hashed_password == hashed_password_in_db
    assert User.authenticate('password') is False
    assert User.authenticate('new password') is True
    User.change_password('password') is True
