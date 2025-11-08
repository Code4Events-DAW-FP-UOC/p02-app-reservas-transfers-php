<?php
class AuthController extends Controller
{
    public function login()
    {
        session_start();
        $error = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            $userModel = $this->model('User');
            $user = $userModel->getByEmail($email);

            if ($user && password_verify($password, $user['password'])) {
                // Guardar usuario en la sesión
                $_SESSION['user_id'] = $user['id_viajero'];
                $_SESSION['user_name'] = $user['nombre'];

                // Redirige al panel correspondiente
                header('Location: /user/dashboard');
                exit;
            } else {
                $error = "Correo o contraseña incorrectos.";
            }
        }

        $this->view('auth/login', ['error' => $error]);
    }

    public function logout()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        session_unset();
        session_destroy();
        header('Location: /auth/login');
        exit;
    }
}
