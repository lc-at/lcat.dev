import datetime

from flask import (Blueprint, abort, flash, redirect, render_template, request,
                   session, url_for)

from .models import LogPost, User, db
from .views import requires_auth

bp = Blueprint('admin', __name__, url_prefix='/administrator')


@bp.route('/login', methods=['GET', 'POST'])
def login():
    if session.get('authed'):
        return redirect(url_for('root'))
    elif request.method == 'POST':
        if User.authenticate(request.form.get('password', '')):
            session['authed'] = True
            flash('Authentication  successful.')
            return redirect(url_for('root'))
        elif request.form.get('password') == 'password':
            flash('No, not this time.')
        else:
            flash('Invalid password entered.')
    return render_template('admin/login.html')

@bp.route('/change-password', methods=['GET', 'POST'])
@requires_auth
def change_password():
    if request.method == 'POST':
        new_password = request.form.get('new_password')
        confirm_new_password = request.form.get('confirm_new_password')

        if not (new_password and confirm_new_password):
            abort(403)
        elif new_password != confirm_new_password:
            flash('Password unchanged.')
        else:
            User.change_password(new_password)
            flash('Password changed.')
            return logout()
    return render_template('admin/change_password.html')

@bp.route('/logout')
@requires_auth
def logout():
    session.pop('authed')
    return redirect(url_for('root'))


@bp.route('/write-log', methods=['GET', 'POST'])
@requires_auth
def write_log():
    if request.method == 'POST':
        title = request.form.get('title')
        content = request.form.get('content')
        is_markdown = request.form.get('is_md') is not None

        if not (title and content):
            abort(403)

        log = LogPost(title, content, is_markdown)
        db.session.add(log)
        db.session.commit()

        flash('Log post added successfully.')
        return redirect(url_for('root'))

    return render_template('admin/write_log.html')


@bp.route('/edit-log/<log_post_id>', methods=['GET', 'POST'])
@requires_auth
def edit_log(log_post_id):
    log_post = LogPost.query.filter_by(id=log_post_id).first_or_404()
    if request.method == 'POST':
        title = request.form.get('title')
        content = request.form.get('content')
        is_markdown = request.form.get('is_md') is not None

        if not (title and content):
            abort(403)

        log_post.title = title
        log_post.content = content
        log_post.is_markdown = is_markdown
        log_post.last_updated = datetime.datetime.now()
        db.session.commit()

        flash(f'Updated log post {log_post.id}.')

    return render_template('admin/edit_log.html', log_post=log_post)


@bp.route('/delete/<log_post_id>')
@bp.requires_auth
def delete_log(log_post_id):
    log_post = LogPost.query.filter_by(id=log_post_id).first_or_404()
    db.session.delete(log_post)
    db.session.commit()
    flash(f'Deleted log post {log_post.id}.')
    return redirect(request.referrer or url_for('root'))
