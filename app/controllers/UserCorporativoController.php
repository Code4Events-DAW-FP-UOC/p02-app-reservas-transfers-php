<?php

/**
 * Controlador para el panel del usuario corporativo (hoteles).
 * Gestiona el dashboard y posibles funcionalidades exclusivas para hoteles.
 */
class UserCorporativoController extends Controller
{
    /**
     * Solo permite acceso a usuarios autenticados tipo hotel.
     * Redirige a login si no está logueado.
     *
     * @return void
     */
    protected function requireHotel()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        // Si el usuario no tiene sesión, o el rol no corresponde a corporativo, redirige
        if (empty($_SESSION['user_id'])) {
            header('Location: /auth/login');
            exit;
        }
    }

    /**
     * Muestra el dashboard del usuario corporativo (hotel).
     * @return void
     */
    public function dashboard()
    {
        $this->requireHotel();
        // Aquí puedes cargar datos propios del hotel (reservas asociadas, etc)
        $this->view('userCorporativo/dashboard');
    }

    /**
     * Muestra y procesa el formulario de edición de perfil para un hotel corporativo.
     * Permite modificar los datos del hotel y actualizar la contraseña si se desea.
     * 
     * @return void
     */
    public function editarPerfil()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (empty($_SESSION['user_id']) || ($_SESSION['user_rol'] ?? '') !== 'corporativo') {
            header('Location: /auth/login');
            exit;
        }

        $error = null;
        $success = null;

        $hotelModel = $this->model('Hotel');
        $hotel = $hotelModel->getById($_SESSION['user_id']);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre      = trim($_POST['nombre'] ?? '');
            $id_zona     = $_POST['id_zona'] ?? null;
            $comision    = $_POST['comision'] ?? 0;
            $usuario     = trim($_POST['usuario'] ?? '');
            $email       = trim($_POST['email'] ?? '');
            $password    = $_POST['password'] ?? null;
            $confirm     = $_POST['confirm_password'] ?? null;

            // Validación básica
            if (!$nombre || !$usuario || !$email || !$id_zona) {
                $error = "Los campos nombre, usuario, email y zona son obligatorios.";
            } elseif (!empty($password) || !empty($confirm)) {
                if ($password !== $confirm) {
                    $error = "Las contraseñas no coinciden.";
                } elseif (strlen($password) < 6) {
                    $error = "La nueva contraseña debe tener al menos 6 caracteres.";
                }
            } else {
                // Solo actualiza el password si se ha introducido y confirmado
                $datos = [
                    'nombre'   => $nombre,
                    'id_zona'  => $id_zona,
                    'comision' => $comision,
                    'usuario'  => $usuario,
                    'email'    => $email,
                ];
                if (!empty($password)) {
                    $datos['password'] = $password;
                }

                try {
                    $ok = $hotelModel->update($_SESSION['user_id'], $datos);
                    if ($ok) {
                        $success = "Perfil actualizado correctamente.";
                        // Actualiza el nombre en la sesión
                        $_SESSION['user_name'] = $nombre;
                        $hotel = $hotelModel->getById($_SESSION['user_id']); // refresca datos
                    } else {
                        $error = "Error al actualizar el perfil.";
                    }
                } catch (Exception $e) {
                    $error = $e->getMessage();
                }
            }
        }

        $zonaModel = new Zona();
        $zonas = $zonaModel->getAll();

        $this->view('userCorporativo/editPerfil', [
            'hotel' => $hotel,
            'zonas' => $zonas,
            'error' => $error,
            'success' => $success
        ]);
    }
}
