<?php
class UserParticularController extends Controller
{
    public function dashboard()
    {
        // Solo permite acceso si el usuario está logueado
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (empty($_SESSION['user_id'])) {
            header('Location: /auth/login');
            exit;
        }
        // Carga la vista del dashboard
        $this->view('userParticular/dashboard');
    }
}
