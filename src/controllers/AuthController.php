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

    // --- REGISTRE ---

    public function showRegisterForm()
    {
        require_once __DIR__ . '/../views/register.php';
    }

    public function processRegister()
    {
        // Recollim tots els camps del formulari
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

        // Comprovació mínima
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

    // --- LOGIN ---

    public function showLoginForm()
    {
        require_once __DIR__ . '/../views/login.php';
    }

    public function processLogin()
    {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        $user = $this->userModel->login($email, $password);

        if ($user) {
            // LOGIN CORRECTE
            $_SESSION['user_id'] = $user['id_viajero']; 
            $_SESSION['user_name'] = $user['nombre'];
            
            // LÒGICA DE ROLS
            $adminEmail = 'admin@isla.com'; 

            if ($user['email'] === $adminEmail) {
                $_SESSION['user_role'] = 'admin';
                header('Location: /admin/dashboard');
            } else {
                $_SESSION['user_role'] = 'particular';
                header('Location: /particular/dashboard');
            }
            exit;
            
        } else {
            // LOGIN INCORRECTE
            $_SESSION['error_message'] = "Email o contraseña incorrectos.";
            header('Location: /login'); 
            exit;
        }
    }

    // --- PERFIL (NOU) ---

    public function showProfile()
    {
        // Comprovem que estigui loguejat
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login'); exit;
        }

        // Busquem les dades de la BD
        $user = $this->userModel->findById($_SESSION['user_id']);

        require_once __DIR__ . '/../views/profile.php';
    }

    public function updateProfile()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login'); exit;
        }

        $id = $_SESSION['user_id'];
        $nombre = $_POST['nombre'];
        $email = $_POST['email'];
        $password = $_POST['password']; // Pot estar buit

        $success = $this->userModel->update($id, $nombre, $email, $password);

        if ($success) {
            $_SESSION['user_name'] = $nombre; // Actualitzem la sessió també
            $_SESSION['success_message'] = "Perfil actualitzat correctament.";
        } else {
            $_SESSION['error_message'] = "Error en actualitzar el perfil.";
        }

        header('Location: /perfil');
        exit;
    }

    // --- LOGOUT ---

    public function logout()
    {
        session_destroy();
        header('Location: /login');
        exit;
    }

} // Final de la classe
?>