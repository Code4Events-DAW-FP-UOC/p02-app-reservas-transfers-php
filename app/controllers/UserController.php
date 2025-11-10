<?php
class UserController extends Controller
{
    public function edit()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (empty($_SESSION['user_id'])) {
            header('Location: /auth/login');
            exit;
        }
        $error = null;
        $success = null;

        $userModel = $this->model('User');
        $usuario = $userModel->getById($_SESSION['user_id']);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = trim($_POST['nombre'] ?? '');
            $apellido1 = trim($_POST['apellido1'] ?? '');
            $apellido2 = trim($_POST['apellido2'] ?? '');
            $direccion = trim($_POST['direccion'] ?? '');
            $codigoPostal = trim($_POST['codigoPostal'] ?? '');
            $ciudad = trim($_POST['ciudad'] ?? '');
            $pais = trim($_POST['pais'] ?? '');
            $password = $_POST['password'] ?? null;
            $confirm = $_POST['confirm_password'] ?? null;

            // Validación básica
            if (!$nombre || !$apellido1) {
                $error = "El nombre y primer apellido son obligatorios.";
            } elseif (!empty($password) || !empty($confirm)) {
                if ($password !== $confirm) {
                    $error = "Las contraseñas no coinciden.";
                } elseif (strlen($password) < 6) {
                    $error = "La nueva contraseña debe tener al menos 6 caracteres.";
                }
            } else {
                $ok = $userModel->updateProfile(
                    $_SESSION['user_id'],
                    $nombre,
                    $apellido1,
                    $apellido2,
                    $direccion,
                    $codigoPostal,
                    $ciudad,
                    $pais,
                    $password // solo cambiará si se ha introducido
                );
                if ($ok) {
                    $success = "Perfil actualizado correctamente.";
                    // Actualiza el nombre en la sesión
                    $_SESSION['user_name'] = $nombre;
                    // Refresca los datos del usuario para mostrar los cambios en la vista
                    $usuario = $userModel->getById($_SESSION['user_id']);
                } else {
                    $error = "Error al actualizar el perfil.";
                }
            }
        }

        // Carga la vista, pasando el usuario actual y los mensajes de éxito/error
        $this->view('user/edit', [
            'usuario' => $usuario,
            'error' => $error,
            'success' => $success
        ]);
    }
}
