<?php
session_start();
require_once 'config/db.php';
require_once 'controllers/AuthController.php';

$authController = new AuthController($pdo);

$route = $_GET['route'] ?? 'home';
$method = $_SERVER['REQUEST_METHOD'];

switch ($route) {
    case 'home':
        echo "¡Bienvenido a Isla Transfers!";
        break;

    // --- Rutas de Autenticación ---
    case 'login':
        if ($method === 'GET') {
            $authController->showLoginForm();
        } else if ($method === 'POST') {
            $authController->processLogin();
        }
        break;

    case 'register':
        if ($method === 'GET') {
            $authController->showRegisterForm();
        } else if ($method === 'POST') {
            $authController->processRegister();
        }
        break;

    case 'logout':
        $authController->logout();
        break;

    // --- Rutas de Administración (Protegidas) ---
    case 'admin/dashboard':
        
        // Comprobación de Login (temporal, sin rol)
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error_message'] = "Debes iniciar sesión para acceder.";
            header('Location: /login');
            exit;
        }
        
        // Canviem el nom per 'nombre' (de la BBDD)
        echo "Bienvenido al Panel de Administración, " . htmlspecialchars($_SESSION['user_name']);
        echo '<br><a href="/logout">Cerrar sesión</a>';
        break;

    default:
        http_response_code(404);
        echo "Error 404: Página no encontrada";
        // require_once 'views/404.php'; 
        break;
}
?>