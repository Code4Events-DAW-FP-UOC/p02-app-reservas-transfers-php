<?php
class UserAdminController extends Controller
{
    // Solo permite acceso a admins
    protected function requireAdmin()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (empty($_SESSION['user_id']) || ($_SESSION['user_rol'] ?? '') !== 'admin') {
            header('Location: /auth/login');
            exit;
        }
    }

    public function dashboard()
    {
        $this->requireAdmin();
        // Aquí puedes cargar datos de estadísticas si quieres
        $this->view('userAdmin/dashboard');
    }

    public function nuevaReserva()
    {
        $this->requireAdmin();
        // Lógica para mostrar el formulario de alta
        $this->view('userAdmin/nueva_reserva');
    }

    public function listadoReservas()
    {
        $this->requireAdmin();
        // Lógica para obtener reservas
        // $reservas = ...;
        $this->view('userAdmin/listado_reservas'/*, ['reservas' => $reservas] */);
    }

    public function calendario()
    {
        $this->requireAdmin();
        // Lógica para cargar datos del calendario
        $this->view('userAdmin/calendario');
    }

    public function gestionUsuarios()
    {
        $this->requireAdmin();
        // Lógica para mostrar gestión de usuarios
        $this->view('userAdmin/gestion_usuarios');
    }
}
