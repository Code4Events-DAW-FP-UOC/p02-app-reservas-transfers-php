<?php
// Iniciamos la sesión en todas las páginas 
session_start();

require_once 'config/db.php';



//leemos la ruta que nos pasa el .htaccess
$route = $_GET['route'] ?? 'home'; // Si no hay ruta, vamos a 'home'


// switch simple para decidir qué vista cargar
switch ($route) {
    case 'home':
        echo "¡Bienvenido a Isla Transfers!";
        break;

    case 'login':
        echo "Esta es la página de Login.";
        break;

    case 'register':
        echo "Esta es la página de Registro.";
        break;

    case 'admin/dashboard':
        echo "Este es el Panel de Administración.";
        break;

    default:
        http_response_code(404);
        echo "Error 404: Página no encontrada";
        break;
}

?>