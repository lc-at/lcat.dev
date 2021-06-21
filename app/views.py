from flask import render_template

from . import app


@app.route('/')
def root():
    return render_template('home.html')

@app.route('/sudo')
def sudo():
    return render_template('sudo.html')
