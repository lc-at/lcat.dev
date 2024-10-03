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

if ($searchQuery = ($_GET['q'] ?? false)) {
    if (strlen($searchQuery) < 4) {
        flash('Search query must be at least 4 characters long');
        redirect(getHomeURL());
    }
    flash('Showing results for: ' . $searchQuery);
    $posts = searchPosts($searchQuery, $limit, $offset);

    if (!isLoggedIn() && strlen($searchQuery) < 10 && count($posts) > 1) {
        $posts = array_filter($posts, function ($post) {
            return !$post->isHidden();
        });
    }
} else {
    $posts = getAllPostsPinnedFirst($limit, $offset);
    if (!isLoggedIn()) {
        $posts = array_filter($posts, function ($post) {
            return !$post->isHidden();
        });
    }
}


renderTemplate('post_list', [
    'title' => 'Home',
    'posts' => $posts,
    'limit' => $limit,
    'offset' => $offset,
]);
