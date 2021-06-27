import os

from flask import Flask
from flask_sqlalchemy import SQLAlchemy

app = Flask(__name__)

app.config.from_pyfile(os.path.join(app.root_path, '..', 'config.py'))

db = SQLAlchemy(app)

from .views import *  # noqa
from .admin import bp as admin_bp  # noqa

app.register_blueprint(admin_bp)
