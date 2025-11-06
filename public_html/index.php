<?php
spl_autoload_register(function ($class) {
    if (file_exists("../core/$class.php")) require_once "../core/$class.php";
    else if (file_exists("../app/controllers/$class.php")) require_once "../app/controllers/$class.php";
    else if (file_exists("../app/models/$class.php")) require_once "../app/models/$class.php";
});

$router = new Router();
$router->route();
