<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

$config = array(
    'database_path' => 'lcat.db',

    'totp_secret' => 'youcangeneratethissecretonline',
    'totp_digits' => '6',
    'totp_period' => '30',
    'totp_offset' => 0,
    'totp_algo' => 'sha256',
);

foreach ($config as $key => $value) {
    if ($env = getenv(strtoupper($key))) {
        $config[$key] = $env;
    }
}
