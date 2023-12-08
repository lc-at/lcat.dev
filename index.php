<?php
define('BASEPATH', __DIR__);

require_once 'templating.php';
require_once 'transactions.php';

$posts = getAllPostsPinnedFirst();
renderTemplate('index.php', [
    'title' => 'Home',
    'posts' => $posts,
]);
