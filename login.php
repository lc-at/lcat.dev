<?php
define('BASEPATH', __DIR__);

require_once 'templating.php';
require_once 'transactions.php';
require_once 'urls.php';
require_once 'auth.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $code = $_POST['code'] ?? '';
    if (empty($code)) {
        die('Trying something?');
    }

    if (checkLoginOTP($code)) {
        setLoggedIn(true);
        flash('Welcome back!');
        redirect(getHomeURL());
    } else {
        flash('Invalid code');
    }
}

renderTemplate('login', [
    'title' => 'Login',
]);
