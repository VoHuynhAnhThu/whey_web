<?php

declare(strict_types=1);

$appConfig = require __DIR__ . '/config/app.php';

date_default_timezone_set($appConfig['timezone'] ?? 'UTC');

ini_set('display_errors', ($appConfig['display_errors'] ?? false) ? '1' : '0');
error_reporting(E_ALL);

session_start();

spl_autoload_register(function (string $class): void {
    $paths = [
        __DIR__ . '/core/' . $class . '.php',
        __DIR__ . '/controllers/' . $class . '.php',
        __DIR__ . '/models/' . $class . '.php',
    ];

    foreach ($paths as $path) {
        if (file_exists($path)) {
            require_once $path;
            return;
        }
    }
});

// Load global helpers (asset URL builder, etc.)
require_once __DIR__ . '/core/helpers.php';

$router = new Router();
require __DIR__ . '/routes/web.php';
$router->dispatch($_SERVER['REQUEST_URI'] ?? '/', $_SERVER['REQUEST_METHOD'] ?? 'GET');
