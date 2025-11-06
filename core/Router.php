<?php
class Router
{
    public function route()
    {
        $url = $_GET['url'] ?? '';
        $url = trim($url, '/');
        $parts = explode('/', $url);

        $controllerName = !empty($parts[0]) ? ucfirst($parts[0]) . 'Controller' : 'HomeController';
        $method = $parts[1] ?? 'index';
        $params = array_slice($parts, 2);

        if (file_exists("../app/controllers/$controllerName.php")) {
            $controller = new $controllerName();
            if (method_exists($controller, $method)) {
                call_user_func_array([$controller, $method], $params);
            } else {
                echo "Mètode no trobat.";
            }
        } else {
            echo "Controlador no trobat.";
        }
    }
}
