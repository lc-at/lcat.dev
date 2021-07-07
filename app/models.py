import uuid
from datetime import datetime
from hashlib import sha512

from flask import current_app
from flask_migrate import Migrate
from flask_sqlalchemy import SQLAlchemy

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

    def __init__(self, title, content, is_markdown=True):
        self.id = str(uuid.uuid4())
        self.title = title
        self.content = content
        self.is_markdown = is_markdown

    def set_last_updated(self):
        self.last_updated = datetime.utcnow()


class User:
    @classmethod
    def authenticate(cls, password):
        cred_file = current_app.config['CRED_FILE']
        try:
            with open(cred_file) as f:
                password_r = f.read()
                if len(password_r) != 128:  # sha512 hash length is 128
                    raise ValueError
                password_i = sha512(password.encode()).hexdigest()
                if password_r == password_i:
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
            f.write(sha512(new_password.encode()).hexdigest())
        return True
