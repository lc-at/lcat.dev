<?php
define('BASEPATH', __DIR__);

require_once 'templating.php';
require_once 'transactions.php';
require_once 'auth.php';

if (!is_numeric($_GET['limit'] ?? 0) || !is_numeric($_GET['offset'] ?? 0)) {
    flash('Eh???');
    redirect(getHomeURL());
}

$max_limit = 20 + random_int(0, 20);

$limit = abs($_GET['limit'] ?? 20);
$offset = abs($_GET['offset'] ?? 0);

if (!isLoggedIn() && ($offset > 0 || $limit > $max_limit)) {
    flash('You must be logged in to view more posts');
    redirect(getHomeURL());
}

$show_hidden = false;
if ($searchQuery = ($_GET['q'] ?? false)) {
    if (strlen($searchQuery) < 4) {
        flash('Search query must be at least 4 characters long');
        redirect(getHomeURL());
    }
    flash('Showing results for: ' . $searchQuery);
    $posts = searchPosts($searchQuery, $limit, $offset);

    if (strlen($searchQuery) > 10 && count($posts) === 1) {
        $show_hidden = true;
    }
} else {
    $posts = getAllPostsPinnedFirst($limit, $offset);
}

if (!isLoggedIn() && !$show_hidden) {
    $posts = array_filter($posts, function ($post) {
        return !$post->isHidden();
    });
}

if (isset($_GET['rss'])) {
    header('Content-Type: application/rss+xml');
    renderTemplate('rss', [
        'posts' => $posts,
    ], null);
} else {
    renderTemplate('post_list', [
        'title' => 'Home',
        'posts' => $posts,
        'limit' => $limit,
        'offset' => $offset,
    ]);
}
