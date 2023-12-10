<?php
define('BASEPATH', __DIR__);

require_once 'templating.php';
require_once 'transactions.php';
require_once 'auth.php';

$limit = abs($_GET['limit'] ?? 20);
$offset = abs($_GET['offset'] ?? 0);

if (!isLoggedIn() && ($offset > 0 || $limit > 20)) {
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
} else {
    $posts = getAllPostsPinnedFirst($limit, $offset);
}

renderTemplate('post_list', [
    'title' => 'Home',
    'posts' => $posts,
    'limit' => $limit,
    'offset' => $offset,
]);
