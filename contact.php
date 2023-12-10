<?php
define('BASEPATH', __DIR__);

require_once 'templating.php';
require_once 'transactions.php';
require_once 'urls.php';

$post = getContactPost();

if (empty($post)) {
    flash('Contact page not found');
    redirect(getHomeURL());
}

renderTemplate('post_view', [
    'title' => 'Contact',
    'post' => $post,
]);
