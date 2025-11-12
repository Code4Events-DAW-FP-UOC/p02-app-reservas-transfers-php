<?php
class Router {
    private $routes = [];

    public function __construct() {
        $this->routes = [
            '/' => ['IndexController', 'index'],
            '/login' => ['AuthenticationController', 'login'],
            '/login/process' => ['AuthenticationController', 'loginProcess'],
            '/register' => ['AuthenticationController', 'register'],
            '/register/process' => ['AuthenticationController', 'registerProcess'],
            '/logout' => ['AuthenticationController', 'logout'],
            '/particularpanel' => ['ParticularController', 'panel'],
            '/corporatepanel' => ['CorporateController', 'panel'],
            '/adminpanel' => ['AdminController', 'panel'],
        ];
    }

    public function direct($uri) {
        $uri = strtok($uri, '?'); // quitar query string

        if (array_key_exists($uri, $this->routes)) {
            $controllerName = $this->routes[$uri][0];
            $methodName = $this->routes[$uri][1];

            $controllerFile = __DIR__ . '/../controllers/' . $controllerName . '.php';

            if (file_exists($controllerFile)) {
                require_once $controllerFile;
                $controller = new $controllerName();

                if (method_exists($controller, $methodName)) {
                    $controller->$methodName();
                } else {
                    header("HTTP/1.0 404 Not Found");
                    echo "Método {$methodName} no encontrado en controlador {$controllerName}.";
                }
            } else {
                header("HTTP/1.0 404 Not Found");
                echo "Controlador {$controllerName} no encontrado.";
            }
        } else {
            header("HTTP/1.0 404 Not Found");
            echo "Ruta {$uri} no encontrada.";
        }
    }
}