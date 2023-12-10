<?php
define('BASEPATH', __DIR__);

require_once 'templating.php';
require_once 'transactions.php';
require_once 'urls.php';
require_once 'auth.php';

requireLogin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $content = $_POST['content'] ?? '';
    $isPinned = !empty($_POST['isPinned']);

    if (empty($title) || empty($content)) {
        flash('Title and content are required');
    } else {
        $newPostId = createPost($title, $content, $isPinned);
        flash('Post created');

        redirect(getPostViewURL($newPostId));
    }
} else {
    renderTemplate('post_form', [
        'title' => 'Write',
    ]);
}
