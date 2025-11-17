<?php
// 1. Iniciem la sessió per poder accedir a $_SESSION
session_start();

// 2. Incluim la configuració i els controladors necessaris
require_once 'config/db.php';
require_once 'controllers/AuthController.php';
require_once 'controllers/AdminController.php';
require_once 'controllers/ReservaController.php';

// 3. Instanciem el controlador d'autenticació
// (Li passem la connexió $pdo que ve de db.php)
$authController = new AuthController($pdo);
$adminController = new AdminController($pdo);
$reservaController = new ReservaController($pdo);

// 4. Obtenim la ruta de la URL (o 'home' per defecte)
$route = $_GET['route'] ?? 'home';

// 5. Mirem quin mètode s'està fent servir (GET o POST)
$method = $_SERVER['REQUEST_METHOD'];

// 6. EL ROUTER PRINCIPAL (Switch)
switch ($route) {
    
    // --- PÀGINA D'INICI ---
    case 'home':
        // Si l'usuari ja està loguejat, el redirigim al seu panell
        if (isset($_SESSION['user_role'])) {
            if ($_SESSION['user_role'] === 'admin') {
                header('Location: /admin/dashboard');
            } else {
                header('Location: /particular/dashboard');
            }
            exit;
        }
        // Si no, el portem al login
        header('Location: /login');
        break;

    // --- AUTENTICACIÓ (Login, Register, Logout) ---
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

    // --- PANELL ADMINISTRADOR ---
    case 'admin/dashboard':
        // Seguretat: Si no és admin, fora!
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
            $_SESSION['error_message'] = "Accés denegat: No ets administrador.";
            header('Location: /login'); 
            exit;
        }
        // Carreguem la vista del menú blau
        require_once 'views/admin/dashboard.php';
        break;

    // --- PANELL PARTICULAR ---
    case 'particular/dashboard':
        // Seguretat: Si no està loguejat, fora!
        if (!isset($_SESSION['user_role'])) {
            header('Location: /login'); 
            exit;
        }
        // Carreguem la vista del menú verd
        require_once 'views/particular/dashboard.php';
        break;
    // RUTA PER VEURE EL FORMULARI
    case 'admin/reserva/nueva':
        $adminController->showNewReservaForm();
        break;

    // RUTA PER PROCESSAR EL FORMULARI (POST)
    case 'admin/reserva/create':
        if ($method === 'POST') {
            $adminController->createReserva();
        }
        break;
    // RUTA PER VEURE DETALLS (CONFIRMACIÓ)
    case 'admin/reserva/detalles':
        $adminController->showReservaDetails();
        break;
    //RUTA LLISTAT DE RESERVES
    case 'admin/reservas':
        $adminController->listReservas();
        break;
    // --- RUTES CLIENT PARTICULAR ---
    case 'reservar':
        $reservaController->showForm();
        break;

    case 'reservar/create':
        if ($method === 'POST') $reservaController->create();
        break;

    case 'mis-reservas':
        $reservaController->listMyReservations();
        break;
    // --- ERROR 404 ---
    default:
        http_response_code(404);
        echo "<h1>Error 404</h1><p>Pàgina no trobada.</p>";
        break;
}
?>