<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

function redirect($url)
{
    header('Location: ' . $url);
    exit();
}

function flashNextURL($url)
{
    $_SESSION['next_url'] = $url;
}

function getFlashedNextURL()
{
    if (isset($_SESSION['next_url'])) {
        $url = $_SESSION['next_url'];
        unset($_SESSION['next_url']);
        return $url;
    }
    return null;
}

function getPostViewURL($post_id, $hidden = false)
{
    return 'post.php?id=' . $post_id . ($hidden ? '&hidden=1' : '');
}

function getPostEditURL($post_id)
{
    return 'edit.php?id=' . $post_id;
}

function getPostDeleteURL($post_id)
{
    return 'delete.php?id=' . $post_id;
}

function getContactURL()
{
    return 'contact.php';
}

function getPostCreateURL()
{
    return 'write.php';
}

function getLoginURL()
{
    return 'login.php';
}

function getLogoutURL()
{
    return 'logout.php';
}

function getHomeURL()
{
    return 'index.php';
}
