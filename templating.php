<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once 'auth.php';
require_once 'config.php';
require_once 'urls.php';

if (!isset($_SESSION)) {
    session_start();
}

function renderTemplate($templateName, $variables = [])
{
    $templatePath = 'template_' . $templateName . '.php';

    global $config;
    extract($variables);
    if (!is_readable($templatePath)) {
        return '';
    }

    require 'template_base.php';
}

function flash($message)
{
    $flashedMessages = $_SESSION['flash'] ?? [];
    $flashedMessages[] = htmlspecialchars($message);
    $_SESSION['flash'] = $flashedMessages;
}

function getFlashedMessages()
{
    $flashedMessages = $_SESSION['flash'] ?? [];
    unset($_SESSION['flash']);
    return $flashedMessages;
}
