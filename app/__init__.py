import os

from flask import Flask


def create_app(test_config=None):
    app = Flask(__name__)

    app.config.from_pyfile(os.path.join(app.root_path, '..', 'config.py'))

    if test_config is not None:
        app.config.update(test_config)

    from .models import db, migrate
    db.init_app(app)
    migrate.init_app(app, db)

    from .views import admin, home

    app.register_blueprint(admin.bp)
    app.register_blueprint(home.bp)

    from .utils import filters
    app.add_template_filter(filters.md_to_html, 'md_to_html')

    return app
