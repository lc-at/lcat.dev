<?php
define('BASEPATH', __DIR__);

require_once 'templating.php';
require_once 'transactions.php';
require_once 'urls.php';

$id = $_GET['id'] ?? '';
if (empty($id)) {
    flash('Trying something?');
    redirect(getHomeURL());
}

$post = getPost($id);
$hasHiddenParameter = $_GET['hidden'] ?? '' === '1';

if (empty($post) || ($post->isHidden() && !$hasHiddenParameter)) {
    flash('Post not found, sorry');
    redirect(getHomeURL());
}

$mimeType = $_GET['mimetype'] ?? '';
if (!empty($mimeType)) {
    if (!preg_match('/\w+/[-+\w]+/', $mimeType)) {
        flash('Invalid mime type');
        redirect(getHomeURL());
    }
    header('Content-Type: ' . $mimeType);
    die($post->content);
}

renderTemplate('post_view', [
    'title' => $post->title,
    'post' => $post,
]);
