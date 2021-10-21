import uuid
from datetime import datetime

from flask import current_app
from flask_migrate import Migrate
from flask_sqlalchemy import SQLAlchemy
from passlib.hash import pbkdf2_sha512

db = SQLAlchemy()
migrate = Migrate()


class LogPost(db.Model):
    id = db.Column(db.String(36), primary_key=True)
    created = db.Column(db.DateTime, nullable=False, default=datetime.utcnow)
    last_updated = db.Column(db.DateTime,
                             nullable=False,
                             default=datetime.utcnow)
    title = db.Column(db.Text, nullable=False)
    content = db.Column(db.Text, nullable=True)
    is_markdown = db.Column(db.Boolean, nullable=True)
    is_pinned = db.Column(db.Boolean, nullable=True)

    def __init__(self, title, content, is_markdown=True, is_pinned=False):
        self.id = str(uuid.uuid4())
        self.title = title
        self.content = content
        self.is_markdown = is_markdown
        self.is_pinned = is_pinned

    def set_last_updated(self):
        self.last_updated = datetime.utcnow()


class User:
    @classmethod
    def authenticate(cls, password):
        cred_file = current_app.config['CRED_FILE']
        try:
            with open(cred_file) as f:
                password_hash = f.read()
                if len(password_hash) != 130:  # pbkdf2_sha512
                    raise ValueError
                elif pbkdf2_sha512.verify(password, password_hash):
                    return True
        except (FileNotFoundError, ValueError):
            default_password = 'password'
            cls.change_password(default_password)
            if password == default_password:
                return True
        return False

    @staticmethod
    def change_password(new_password):
        if not new_password:
            return False
        cred_file = current_app.config['CRED_FILE']
        with open(cred_file, 'w') as f:
            f.write(pbkdf2_sha512.hash(new_password))
        return True
