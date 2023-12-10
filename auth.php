<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

require 'config.php';
require 'totp.php';

if (!isset($_SESSION)) {
    session_start();
}

function checkLoginOTP($code)
{
    global $config;
    $totp = new TOTP();
    $validCode = $totp->getOTP(
        $config['totp_secret'],
        $config['totp_digits'],
        $config['totp_period'],
        $config['totp_offset'],
        $config['totp_algo']
    )['otp'];

    if ($code === $validCode) {
        return true;
    } else {
        return false;
    }
}

function setLoggedIn($value)
{
    $_SESSION['logged_in'] = $value;
}

function isLoggedIn()
{
    if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
        return true;
    } else {
        return false;
    }
}

function requireLogin()
{
    if (!isLoggedIn()) {
        redirect(getLoginURL());
        exit();
    }
}
