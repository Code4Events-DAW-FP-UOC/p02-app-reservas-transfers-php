<?php
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/Reserva.php';
require_once __DIR__ . '/../models/Hotel.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Vehiculo.php';


class AdminController extends Controller{

    private $userModel;
    private $hotelModel;
    private $reservaModel;
    private $vehiculoModel;
    private $data;

    public function __construct() {
        $this->userModel = new User();
        $this->hotelModel = new Hotel();
        $this->reservaModel = new Reserva();
        $this->vehiculoModel = new Vehiculo();
        $this->data =[];
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function panel(){

        $lista_reservas = $this->reservaModel->getReservas();

        $this->data['lista_reservas'] = $lista_reservas;

        $this->view('admin_panel', $this->data);
        
    }

    public function nuevaReserva() {
        $tipo_reserva = '';
        $lista_hoteles = '';
        $lista_usuarios = '';
        $lista_vehiculos = '';

        if($_SERVER['REQUEST_METHOD'] == 'POST'){

            $accion = $_POST['accion'] ?? '';
            $tipo_reserva = $_POST['id_tipo_reserva'] ?? 0;

            if($accion == 'seleccionar_tipo'){
                $lista_hoteles = $this->hotelModel->getHoteles();
                $lista_usuarios = $this->userModel->getUsers();
                $lista_vehiculos = $this->vehiculoModel->getVehiculos();
            }elseif($accion == 'crear_reserva') {
                $fecha_entrada = $_POST['fecha_entrada'] ?? '';
                $hora_entrada = $_POST['hora_entrada'] ?? '';
                $numero_vuelo_entrada = trim($_POST['numero_vuelo_entrada'] ?? '');
                $origen_vuelo_entrada = trim($_POST['origen_vuelo_entrada'] ?? '');
                $fecha_vuelo_salida = $_POST['fecha_vuelo_salida'] ?? '';
                $hora_vuelo_salida_raw = $_POST['hora_vuelo_salida'] ?? '';
                $id_hotel = $_POST['id_hotel'] ?? '';
                $email_usuario = $_POST['email_usuario'] ?? '';
                $num_viajeros = trim($_POST['num_viajeros'] ?? '');
                $id_vehiculo = $_POST['id_vehiculo'] ?? '';
                $fecha_reserva = date('Y-m-d H:i:s');
                $fecha_modificacion = $fecha_reserva;
                $localizador = $this->generarLocalizador();

                if (empty($fecha_entrada)) {
                    $fecha_entrada = date('Y-m-d');
                }
                if (empty($hora_entrada)) {
                    $hora_entrada = date('H:i:s');
                }
                if (empty($fecha_vuelo_salida)) {
                    $fecha_vuelo_salida = date('Y-m-d');
                    echo "¡ENTRÓ AQUÍ! Fecha de entrada estaba vacía.\n";
                    echo "Valor asignado: " . $fecha_entrada . "\n";
                    die();
                }
                if (empty($hora_vuelo_salida_raw)) {
                    $hora_vuelo_salida = date('Y-m-d H:i:s'); 
                }else{
                    $hora_vuelo_salida = $fecha_vuelo_salida . ' ' . $hora_vuelo_salida_raw;
                }
                if($this->reservaModel->create($localizador, $id_hotel, $tipo_reserva, $email_usuario, $fecha_reserva, $fecha_modificacion, $id_hotel, $fecha_entrada, $hora_entrada, $numero_vuelo_entrada, $origen_vuelo_entrada, $hora_vuelo_salida, $fecha_vuelo_salida, $num_viajeros, $id_vehiculo)){
                    $_SESSION['success'] = 'Reserva añadida';
                    header('Location: /adminpanel');
                    exit;
                } else {
                    $_SESSION['error'] = 'Error al añid reserva';
                    header('Location: /adminpanel');
                    exit;
                }
            }
        }

        $this->data['tipo_reserva'] = $tipo_reserva;
        $this->data['lista_hoteles'] = $lista_hoteles;
        $this->data['lista_usuarios'] = $lista_usuarios;
        $this->data['lista_vehiculos'] = $lista_vehiculos;

        $this->panel();
        
    }

    public function eliminarReserva(){
        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            if($this->reservaModel->deleteReserva($id)){
                $_SESSION['success'] = 'Reserva Eliminada';
                header('Location: /adminpanel');
                exit;
            } else {
                $_SESSION['error'] = 'No se ha podido eliminar la reserva';
                header('Location: /adminpanel');
                exit;
            }
        }
    }

    public function editarReserva(){
        header('Location: /adminpanel');
        exit;
    }

    public function generarLocalizador(){
        //'UOC-ABC123'
        $randString = uniqid();
        $slicedString = substr($randString, 0, 6);
        $localizador = "UOC-" . $slicedString;
        return $localizador;
    }

}