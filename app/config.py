import os

SQLALCHEMY_DATABASE_URI = os.environ.get('DATABASE_URL')
SUPERUSER_PASSWORD = os.environ.get('SU_PASSWORD')

