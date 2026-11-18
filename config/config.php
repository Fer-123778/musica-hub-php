<?php
$env = parse_ini_file(__DIR__ . '/../.env');

define('APP_NAME', $env['APP_NAME'] ?? 'Música Hub');
define('APP_EMAIL', $env['APP_EMAIL'] ?? '');
define('APP_ENV', $env['APP_ENV'] ?? 'local');