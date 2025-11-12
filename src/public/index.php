<?php

if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }


require_once("../app/config/config.php");
require_once __DIR__ . '/../app/core/Router.php';

spl_autoload_register(function ($class) {
    $paths = [
        __DIR__ . '/../app/controllers/' . $class . '.php',
        __DIR__ . '/../app/models/' . $class . '.php',
        __DIR__ . '/../app/core/' . $class . '.php', 
        ];

    foreach ($paths as $file) {
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

$router = new Router();
$router->direct($_SERVER['REQUEST_URI']);