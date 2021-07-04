import os

from flask import Flask


def create_app(config=None):
    app = Flask(__name__)

    if config is None:
        app.config.from_pyfile(os.path.join(app.root_path, '..', 'config.py'))
    else:
        app.config.from_mapping(config)

    from .models import db, migrate
    db.init_app(app)
    migrate.init_app(app, db)

    from .views import admin, home

    app.register_blueprint(admin.bp)
    app.register_blueprint(home.bp)

    return app
