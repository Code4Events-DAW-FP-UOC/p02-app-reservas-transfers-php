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
                $_SESSION['user_rol'] = $user['rol'];

                // Redirección según rol
                switch ($_SESSION['user_rol']) {
                    case 'admin':
                        header('Location: /userAdmin/dashboard');
                        break;
                    case 'corporativo':
                        header('Location: /userCorporativo/dashboard');
                        break;
                    case 'particular':
                    default:
                        header('Location: /userParticular/dashboard');
                        break;
                }
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

    public function registro()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        $error = null;
        $success = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = trim($_POST['nombre'] ?? '');
            $apellido1 = trim($_POST['apellido1' ?? '']);
            $apellido2 = trim($_POST['apellido2' ?? '']);
            $rol = $_POST['rol'] ?? 'particular';
            $direccion = trim($_POST['direccion' ?? '']);
            $codigoPostal = trim($_POST['codigoPostal' ?? '']);
            $ciudad = trim($_POST['ciudad' ?? '']);
            $pais = trim($_POST['pais' ?? '']);
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $confirm = $_POST['confirm'] ?? '';

            // Validación básica
            if (!$nombre || !$apellido1 || !$email || !$password || !$confirm) {
                $error = "Por favor, completa todos los campos.";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = "El correo electrónico no es válido.";
            } elseif ($password !== $confirm) {
                $error = "Las contraseñas no coinciden.";
            } else {
                $userModel = $this->model('User');
                // ¿Ya existe el email?
                if ($userModel->getByEmail($email)) {
                    $error = "El correo electrónico ya está registrado.";
                } else {
                    $ok = $userModel->registro($nombre, $apellido1, $apellido2, $direccion, $codigoPostal, $ciudad, $pais, $email, $password, $rol);
                    if ($ok) {
                        $success = "¡Registro completado! Ahora puedes iniciar sesión.";
                    } else {
                        $error = "Error al registrar. Intenta más tarde.";
                    }
                }
            }
        }

        $this->view('auth/registro', ['error' => $error, 'success' => $success]);
    }
}
