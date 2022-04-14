from flask import Blueprint, current_app, render_template, request, session

from ..models import LogPost

bp = Blueprint('home', __name__)


@bp.route('/')
def root():
    limit = current_app.config.get('MAX_PUBLIC_POSTS')
    if 'authed' in session:
        limit = None
    log_posts = LogPost.query.order_by(
        LogPost.is_pinned.desc(), LogPost.created.desc()).limit(limit).all()
    return render_template('home.html', log_posts=log_posts)


@bp.route('/search')
def search():
    keyword = request.args.get('keyword')
    if keyword and len(keyword) >= 5:
        log_posts = LogPost.query.filter(
            (LogPost.title.ilike(f'%{keyword}%'))
            | (LogPost.content.ilike(f'%{keyword}%'))
            | (LogPost.id == keyword)).order_by(LogPost.created.desc()).limit(
                current_app.config.get('MAX_PUBLIC_POSTS')).all()
        return render_template('search.html', log_posts=log_posts, search=True)
    return render_template('search.html')


@bp.route('/contact')
def contact():
    return render_template('contact.html')


@bp.route('/log/<log_post_id>')
@bp.route('/log/<log_post_id>/<view_type>')
def view_log(log_post_id, view_type=None):
    log_post = LogPost.query.filter_by(id=log_post_id).first_or_404()

    if view_type == 'download':
        return log_post.content, {
            'Content-Type': 'application/octet-stream',
            'Content-Disposition': f'attachment;filename={log_post.id}'
        }
    elif view_type == 'raw':
        return log_post.content, {'Content-Type': 'text/plain'}

    return render_template('view_log.html',
                           log_post=log_post,
                           content=log_post.content)
