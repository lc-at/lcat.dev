<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

function renderTemplate($templateName, $variables)
{
    $templatePath = __DIR__ . '/templates/' . $templateName;
    extract($variables);
    if (!is_readable($templatePath)) {
        return '';
    }

    include 'templates/base.php';
}
