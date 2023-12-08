<?php
define('BASEPATH', __DIR__);

require_once 'templating.php';
require_once 'transactions.php';

$id = $_GET['id'];
if (empty($id)) {
    die('nothing to show');
}

$post = getPostById($id);

if (empty($post)) {
    die('nothing to show');
}

renderTemplate('view_post.php', [
    'title' => $post['title'],
    'post' => $post,
]);
