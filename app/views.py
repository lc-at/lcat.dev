from . import app


@app.route('/')
def root():
    return 'ola minna san'
