<?php
define('BASEPATH', __DIR__);

require_once 'auth.php';
require_once 'templating.php';
require_once 'urls.php';

if (isLoggedIn()) {
    flash('Bye-bye!');
    setLoggedIn(false);
    redirect(getHomeURL());
}
