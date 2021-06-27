from functools import wraps

import marko
from flask import redirect, render_template, request, session, url_for

from . import app
from .models import LogPost


def requires_auth(f):
    @wraps(f)
    def decorated(*args, **kwargs):
        if 'authed' not in session:
            return redirect(url_for('admin.login'))
        return f(*args, **kwargs)

    return decorated


@app.route('/')
def root():
    log_posts = LogPost.query.order_by(LogPost.creation_ts.desc()).all()
    return render_template('home.html', log_posts=log_posts)


@app.route('/log/<log_post_id>')
@app.route('/log/<log_post_id>/<view_type>')
def view_log(log_post_id, view_type=None):
    log_post = LogPost.query.filter_by(id=log_post_id).first_or_404()

    if view_type == 'download':
        return log_post.content, {
            'Content-Type': 'application/octet-stream',
            'Content-Disposition': f'attachment;filename={log_post.id}'
        }
    elif view_type == 'raw':
        return log_post.content, {'Content-Type': 'text/plain'}

    processed_content = log_post.content

    if log_post.is_markdown:
        processed_content = marko.convert(log_post.content)

    return render_template('view_log.html',
                           log_post=log_post,
                           processed_content=processed_content)
