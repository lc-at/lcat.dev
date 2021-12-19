import marko
from flask import Markup


def md_to_html(content):
    return Markup(marko.convert(content))
