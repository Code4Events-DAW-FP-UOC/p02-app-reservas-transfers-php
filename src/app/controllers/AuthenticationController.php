<?php
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/User.php';

class AuthenticationController extends Controller {
    private $userModel;

    public function __construct() {
        $this->userModel = new User();
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    // Show login form
    public function login() {
        $this->view('login');
    }

    // Process login
    public function loginProcess() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email']);
            $password = $_POST['password'];
            $user = $this->userModel->findByEmail($email);

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id_viajero'];
                $_SESSION['user_role'] = $user['rol'];
                $_SESSION['username'] = $user['nombre'];
                header('Location: /');
                exit;
            } else {
                $_SESSION['error'] = 'Usuario o contraseña incorrecto.';
                header('Location: /login');
                exit;
            }
        } else {
            header('Location: /login');
            exit;
        }
    }

    // Show register form
    public function register() {
        $this->view('register');
    }

    // Process register
    public function registerProcess() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = trim($_POST['nombre'] ?? '');
            $apellido1 = trim($_POST['apellido1' ?? '']);
            $apellido2 = trim($_POST['apellido2' ?? '']);
            $direccion = trim($_POST['direccion' ?? '']);
            $codigoPostal = trim($_POST['codigoPostal' ?? '']);
            $ciudad = trim($_POST['ciudad' ?? '']);
            $pais = trim($_POST['pais' ?? '']);
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $verify = $_POST['verify'] ?? '';
            $rol = $_POST['rol'] ?? 'particular';

            $password_hashed = password_hash($password, PASSWORD_DEFAULT);

            if($password !== $verify){
                $_SESSION['error'] = 'Las contraseñas no coinciden';
                header('Location: /register');
                exit;
            }

            if ($this->userModel->findByEmail($email)) {
                $_SESSION['error'] = 'Ya existe un usuario con este correo.';
                header('Location: /register');
                exit;
            }

            if ($this->userModel->create($nombre, $apellido1, $apellido2, $direccion, $codigoPostal, $ciudad, $pais, $email, $password_hashed, $rol)) {
                $_SESSION['success'] = 'Registration complete, please login.';
                header('Location: /login');
                exit;
            } else {
                $_SESSION['error'] = 'Registration failed.';
                header('Location: /register');
                exit;
            }
        } else {
            header('Location: /register');
            exit;
        }
    }

    // Logout
    public function logout() {
        session_destroy();
        header('Location: /');
        exit;
    }
}