<?php
define('BASEPATH', __DIR__);

require_once 'templating.php';
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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $isPinned = !empty($_POST['isPinned']);

    if (empty($title) || empty($content)) {
        flash('Title and content are required');
    } else {
        updatePost($id, $title, $content, $isPinned);
        $post = getPost($id);
        flash('Post updated');
    }
}

renderTemplate('post_form', [
    'title' => 'Edit',
    'post' => $post,
]);
