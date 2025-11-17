<?php
require_once __DIR__ . '/../models/User.php';


class PerfilController extends Controller{

    private $userModel;

     public function __construct() {
        $this->userModel = new User();
        $this->data =[];
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function panel(){

        $this->view('perfil_user', $this->data);
        
    }

    public function updatePerfil(){

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email_original = $_POST['email_original'];

            $usuario = $this->userModel->findByEmail($email_original);

            if ($usuario === false) {
                $_SESSION['error'] = 'Usuario no encontrado.';
                header('Location: /perfil'); // Redirect to a safe page
                exit;
            }

            $nombre = empty(trim($_POST['nombre'])) ? $usuario['nombre'] : trim($_POST['nombre']);
            $email = empty(trim($_POST['email'])) ? $usuario['email'] : trim($_POST['email']);
            $password_nueva = $_POST['password_nueva'] ?? '';
            $confirmar_password = $_POST['confirmar_password'] ?? '';
            
            

            if(empty($password_nueva)){
                $password_hashed = $usuario['password'];
            }else{
                $password_hashed = password_hash($password_nueva, PASSWORD_DEFAULT);
                if($password_nueva !== $confirmar_password){
                    $_SESSION['error'] = 'Las contraseñas no coinciden';
                    header('Location: /perfil');
                    exit;
                }
            }

            $id_viajero = $usuario['id_viajero'];
            $apellido1 = $usuario['apellido1'];
            $apellido2 = $usuario['apellido2'];
            $direccion = $usuario['direccion'];
            $codigoPostal = $usuario['codigoPostal'];
            $ciudad = $usuario['ciudad'];
            $pais = $usuario['pais'];
            $rol = $usuario['rol'];
            
            if($this->userModel->updateUser($id_viajero, $nombre, $apellido1, $apellido2, $direccion, $codigoPostal, $ciudad, $pais, $email, $password_hashed, $rol)){
                $_SESSION['success'] = 'Perfil actualizado';
                header('Location: /logout');
                exit;
            } else {
                $_SESSION['error'] = 'Error al editar el perfil';
                header('Location: /logout');
                exit;
            }
            
        }

    }


}