<?php

/**
 * Controlador de autenticación de usuarios y hoteles.
 * Gestiona el login, logout y registro de usuarios particulares, administradores y corporativos.
 *
 * Métodos:
 * - login(): Muestra el formulario de acceso y gestiona la autenticación.
 * - logout(): Cierra la sesión del usuario actual.
 * - registro(): Muestra y procesa el formulario de registro para usuarios y hoteles.
 */
class AuthController extends Controller
{
    /**
     * Muestra el formulario de login y procesa el acceso de usuarios (por email) y hoteles (por usuario).
     *
     * @return void
     */
    public function login()
    {
        session_start();
        $error = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $identificador = trim($_POST['identificador'] ?? '');
            $password = $_POST['password'] ?? '';

            if (filter_var($identificador, FILTER_VALIDATE_EMAIL)) {
                $userModel = $this->model('User');
                $user = $userModel->getByEmail($identificador);

                if ($user && password_verify($password, $user['password'])) {
                    $_SESSION['user_id'] = $user['id_viajero'];
                    $_SESSION['user_name'] = $user['nombre'] . " " . $user['apellido1'];
                    $_SESSION['user_rol'] = $user['rol'];
                    header('Location: ' . ($user['rol'] === 'admin' ? '/userAdmin/dashboard' : '/user/dashboard'));
                    exit;
                }
            } else {
                $hotelModel = $this->model('Hotel');
                $hotel = $hotelModel->getByUsername($identificador);

                if ($hotel && password_verify($password, $hotel['password'])) {
                    $_SESSION['user_id'] = $hotel['id_hotel'];
                    $_SESSION['user_name'] = $hotel['nombre'];
                    $_SESSION['user_rol'] = 'corporativo';
                    header('Location: /userCorporativo/dashboard');
                    exit;
                }
            }
            $error = "Correo, usuario o contraseña incorrectos.";
        }

        $this->view('auth/login', ['error' => $error]);
    }

    /**
     * Cierra la sesión y redirige al formulario de login.
     *
     * @return void
     */
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

    /**
     * Muestra el formulario de registro y procesa el alta de usuario o hotel.
     * Si el registro es de hotel/corporativo, procesa los datos correspondientes.
     * Si es usuario particular/administrador, valida y crea en la tabla de usuarios.
     *
     * @return void
     */
    public function registro()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        $error = null;
        $success = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $esCorporativo = isset($_POST['es_corporativo']) && $_POST['es_corporativo'] === 'on';

            if ($esCorporativo) {
                // ------ REGISTRO CORPORATIVO (hotel) ------
                $nombre_corporativo = trim($_POST['nombre_corporativo'] ?? '');
                $usuario_corporativo = trim($_POST['usuario_corporativo'] ?? '');
                $id_zona = $_POST['id_zona'] ?? null;
                $email_corporativo = trim($_POST['email_corporativo'] ?? '');
                $password_corporativo = $_POST['password_corporativo'] ?? '';
                $confirm_corporativo = $_POST['confirm_corporativo'] ?? '';

                // Validación
                if (!$nombre_corporativo || !$usuario_corporativo || !$email_corporativo || !$password_corporativo || !$confirm_corporativo) {
                    $error = 'Todos los campos son obligatorios.';
                } else if ($password_corporativo !== $confirm_corporativo) {
                    $error = 'Las contraseñas no coinciden.';
                } else {
                    $corporativoModel = $this->model('Hotel');
                    if ($corporativoModel->getByUsername($usuario_corporativo)) {
                        $error = "El nombre de usuario ya está registrado.";
                    } else {
                        $ok = $corporativoModel->create([
                            'nombre' => $nombre_corporativo,
                            'id_zona' => $id_zona,
                            'comision' => 0,
                            'usuario' => $usuario_corporativo,
                            'email' => $email_corporativo,
                            'password' => $password_corporativo,
                        ]);
                        if ($ok) {
                            $success = "¡Registro de hotel completado! Ahora puede iniciar sesión.";
                        } else {
                            $error = "Error al registra el hotel. Intenta más tarde.";
                        }
                    }
                }
            } else {
                // ------ REGISTRO USUARIO (particular/admin) ------
                $nombre = trim($_POST['nombre'] ?? '');
                $apellido1 = trim($_POST['apellido1'] ?? '');
                $apellido2 = trim($_POST['apellido2'] ?? '');
                $rol = trim($_POST['rol'] ?? 'particular');
                $direccion = trim($_POST['direccion'] ?? '');
                $codigoPostal = trim($_POST['codigoPostal'] ?? '');
                $ciudad = trim($_POST['ciudad'] ?? '');
                $pais = trim($_POST['pais'] ?? '');
                $email = trim($_POST['email'] ?? '');
                $password = $_POST['password'] ?? '';
                $confirm = $_POST['confirm'] ?? '';
                // Validación básica
                if (!$nombre || !$apellido1 || !$email || !$password || !$confirm) {
                    $error = "Por favor, completa todos los campos obligatorios.";
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
                        $ok = $userModel->create([
                            'nombre' => $nombre,
                            'apellido1' => $apellido1,
                            'apellido2' => $apellido2,
                            'direccion' => $direccion,
                            'codigoPostal' => $codigoPostal,
                            'ciudad' => $ciudad,
                            'pais' => $pais,
                            'email' => $email,
                            'password' => $password,
                            'rol' => $rol,
                        ]);
                        if ($ok) {
                            $success = "¡Registro completado! Ahora puede iniciar sesión.";
                        } else {
                            $error = "Error al registrar. Intenta más tarde.";
                        }
                    }
                }
            }
        }

        $zonaModel = new Zona();
        $zonas = $zonaModel->getAll();

        $this->view('auth/registro', ['error' => $error, 'success' => $success, 'zonas' => $zonas]);
    }
}
