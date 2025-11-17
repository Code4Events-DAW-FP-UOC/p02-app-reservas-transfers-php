<?php

require_once __DIR__ . '/../models/Reserva.php';

class ReservaController
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // 1. LLISTAT "MIS RESERVAS"
    public function listMyReservations()
    {
        $this->checkUser();
        $userId = $_SESSION['user_id']; 

        $reservaModel = new Reserva($this->pdo);
        $reservas = $reservaModel->getByUserId($userId);

        require_once __DIR__ . '/../views/particular/mis_reservas.php';
    }

    // 2. FORMULARI DE RESERVA
    public function showForm()
    {
        $this->checkUser();

        try {
            // Carreguem els desplegables igual que a l'admin
            $stmt = $this->pdo->query("SELECT * FROM tranfer_hotel ORDER BY usuario");
            $hoteles = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $stmt = $this->pdo->query("SELECT * FROM transfer_vehiculo");
            $vehiculos = $stmt->fetchAll(PDO::FETCH_ASSOC);

            require_once __DIR__ . '/../views/particular/nueva_reserva.php';
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
        }
    }

    // 3. CREAR RESERVA (AMB REGLA 48H)
    public function create()
    {
        $this->checkUser();

        // --- REGLA DE LES 48 HORES ---
        $fechaVuelo = $_POST['fecha_vuelo'];
        // Calculem la data mínima (Avui + 2 dies)
        $fechaMinima = date('Y-m-d', strtotime('+2 days'));

        if ($fechaVuelo < $fechaMinima) {
            $_SESSION['error_message'] = "Error: Las reservas deben hacerse con 48h de antelación.";
            header('Location: /reservar');
            exit;
        }

        $tipo = $_POST['id_tipo_reserva'];
        $fechaRaw = $_POST['fecha_vuelo'];
        
        if ($tipo == '1') { $horaRaw = $_POST['hora_vuelo']; } 
        else { $horaRaw = $_POST['hora_recogida']; }

        if (strlen($horaRaw) == 5) $horaRaw .= ":00";
        $datetimeCompleto = $fechaRaw . ' ' . $horaRaw;

        $datosReserva = [
            'id_tipo_reserva' => $tipo,
            'id_destino' => $_POST['id_hotel'],
            'id_vehiculo' => $_POST['id_vehiculo'],
            'num_viajeros' => $_POST['num_viajeros'],
            'email_cliente' => $_SESSION['user_id'], 
            'numero_vuelo_entrada' => $_POST['numero_vuelo'],
            
            'fecha_entrada' => $fechaRaw,
            'hora_entrada' => $datetimeCompleto,
            'origen_vuelo_entrada' => $_POST['origen_vuelo'] ?? '-',
            'fecha_vuelo_salida' => $fechaRaw,
            'hora_vuelo_salida' => $datetimeCompleto,
        ];

        $reservaModel = new Reserva($this->pdo);
        $localizador = $reservaModel->create($datosReserva);

        if ($localizador) {
            $_SESSION['success_message'] = "Reserva confirmada! Localitzador: " . $localizador;
            header('Location: /mis-reservas'); // Redirigim al llistat
            exit;
        } else {
            $_SESSION['error_message'] = "Error al guardar.";
            header('Location: /reservar');
            exit;
        }
    }

    private function checkUser() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }
    }
}
?>