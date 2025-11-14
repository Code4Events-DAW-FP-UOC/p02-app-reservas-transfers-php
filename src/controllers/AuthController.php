<?php

// Importem el Model
require_once __DIR__ . '/../models/User.php';

class AuthController
{
    private $userModel;

    public function __construct($pdo)
    {
        $this->userModel = new User($pdo);
    }

    // Muestra el formulario de registro (GET)
    public function showRegisterForm()
    {
        require_once __DIR__ . '/../views/register.php';
    }

    // Procesa los datos del formulario de registro (POST)
    public function processRegister()
    {
        // Recogemos todos los campos del formulario
        $data = [
            'nombre'       => $_POST['nombre'] ?? '',
            'apellido1'    => $_POST['apellido1'] ?? '',
            'apellido2'    => $_POST['apellido2'] ?? '',
            'email'        => $_POST['email'] ?? '',
            'password'     => $_POST['password'] ?? '',
            'direccion'    => $_POST['direccion'] ?? '',
            'codigoPostal' => $_POST['codigoPostal'] ?? '',
            'ciudad'       => $_POST['ciudad'] ?? '',
            'pais'         => $_POST['pais'] ?? ''
        ];

        // Comprobación mínima
        if (empty($data['nombre']) || empty($data['apellido1']) || empty($data['email']) || empty($data['password'])) {
            $_SESSION['error_message'] = "Los campos nombre, primer apellido, email y contraseña son obligatorios.";
            header('Location: /register'); 
            exit;
        }

        // Passem totes les dades al model
        $success = $this->userModel->register($data);

        if ($success) {
            header('Location: /login'); 
            exit;
        } else {
            $_SESSION['error_message'] = "El email ya existe o ha habido un error.";
            header('Location: /register'); 
            exit;
        }
    }

    // Muestra el formulario de login (GET)
    public function showLoginForm()
    {
        require_once __DIR__ . '/../views/login.php';
    }

    // Procesa los datos del formulario de login (POST)
    public function processLogin()
    {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        $user = $this->userModel->login($email, $password);

        if ($user) {
            // LOGIN CORRECTE
            $_SESSION['user_id'] = $user['id_viajero']; 
            $_SESSION['user_name'] = $user['nombre'];
            
            // Definim manualment quin email és l'administrador.
            $adminEmail = 'admin@isla.com'; 

            if ($user['email'] === $adminEmail) {
                $_SESSION['user_role'] = 'admin';
                header('Location: /admin/dashboard'); // Redirigim al menú BLAU
            } else {
                $_SESSION['user_role'] = 'particular';
                header('Location: /particular/dashboard'); // Redirigim al menú VERD
            }
            exit;
            
        } else {
            // ... (codi d'error igual que abans) ...
            $_SESSION['error_message'] = "Email o contraseña incorrectos.";
            header('Location: /login'); 
            exit;
        }
    }

    // Cerrar la sesión
    public function logout()
    {
        session_destroy();
        header('Location: /login');
        exit;
    }
}
?>