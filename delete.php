<?php
define('BASEPATH', __DIR__);

require_once 'transactions.php';
require_once 'urls.php';

$id = $_GET['id'] ?? '';
if (empty($id)) {
    flash('Post ID is required');
    redirect(getHomeURL());
}

$post = getPost($id);
if (empty($post)) {
    flash('Post not found');
    redirect(getHomeURL());
}

$deletedPostId = deletePost($id);
flash('Post deleted');
redirect(getHomeURL());
