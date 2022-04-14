import re

import marko
from flask import Markup, url_for

from ..models import LogPost


def md_to_html(content):
    return Markup(marko.convert(content))


def log_id_autoref(content):

    def replace(match):
        log_id = match.group(1)
        external_lp = LogPost.query.filter(
            LogPost.id.ilike(f'{log_id}%')).first()
        if not external_lp:
            return log_id
        url = url_for('home.view_log', log_post_id=external_lp.id)
        return f'<a class="log-id-ref" href="{url}">{log_id}</a>'

    return re.sub(r'\b([-0-9a-f]{4,})\b', replace, content, re.M | re.I)
