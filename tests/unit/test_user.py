from passlib.hash import pbkdf2_sha512

from app.models import User


def test_authenticate(app):
    assert User.authenticate('password') is True
    assert User.authenticate('') is False
    with open(app.config['CRED_FILE']) as f:
        hashed_password_in_db = f.read()
        assert pbkdf2_sha512.verify('password', hashed_password_in_db) is True
    assert User.authenticate('password') is True


def test_change_password(app):
    assert User.change_password('') is False
    assert User.change_password('new password')
    with open(app.config['CRED_FILE']) as f:
        hashed_password_in_db = f.read()
        assert pbkdf2_sha512.verify('new password',
                                    hashed_password_in_db) is True
    assert User.authenticate('password') is False
    assert User.authenticate('new password') is True
    User.change_password('password') is True
