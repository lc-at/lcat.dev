import datetime
import uuid

from . import db


class LogPost(db.Model):
    id = db.Column(db.String(36), primary_key=True)
    creation_ts = db.Column(db.DateTime,
                            nullable=False,
                            default=datetime.datetime.now())
    title = db.Column(db.Text, nullable=False)
    content = db.Column(db.Text, nullable=True)
    use_mdparser = db.Column(db.Boolean, nullable=True)

    def __init__(self, title, content, use_mdparser=True):
        self.id = str(uuid.uuid4())
        self.title = title
        self.content = content
        self.use_mdparser = use_mdparser


db.create_all()
