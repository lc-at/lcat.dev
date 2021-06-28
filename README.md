# lcat.dev
This repository contains the source code for my personal website [lcat.dev](https://lcat.dev).

## Installing
1. `pip install -r requirements.txt`
2. `cp config.py.template config.py` and adjust `config.py` file accordingly.

## Deploying
Lcat is Flask-based and runs perfectly (tested) only on Python 3.7.3. 

- Below is an example of deployment using Gunicorn.
```
pip -r install requirements.txt
gunicorn -b :7211 wsgi:app
```

- Alternatively, you can also use Flask's development server.
```
python wsgi.py
```

## License
This project is licensed under MIT License.

## Contribution
Any kind of contribution is highly appreciated.
