<?php

require_once __DIR__ . '/../models/Reserva.php';
require_once __DIR__ . '/../models/User.php';

class AdminController
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function index()
    {
        $this->checkAdmin();
        require_once __DIR__ . '/../views/admin/dashboard.php';
    }

    public function showNewReservaForm()
    {
        $this->checkAdmin();
        try {
            $stmt = $this->pdo->query("SELECT * FROM tranfer_hotel ORDER BY usuario");
            $hoteles = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $stmt = $this->pdo->query("SELECT * FROM transfer_vehiculo");
            $vehiculos = $stmt->fetchAll(PDO::FETCH_ASSOC);

            require_once __DIR__ . '/../views/admin/reserva_nueva.php';
        } catch (PDOException $e) {
            die("Error carregant dades: " . $e->getMessage());
        }
    }

    // --- FUNCIÓ ARREGLADA PER A DATETIME ---
    public function createReserva()
    {
        $this->checkAdmin();

        // 1. GESTIÓ USUARI
        $userModel = new User($this->pdo);
        $email = $_POST['email_cliente'] ?? '';
        $usuarioExistente = $userModel->findByEmail($email);
        
        if ($usuarioExistente) {
            $idCliente = $usuarioExistente['id_viajero'];
        } else {
            $datosUsuario = [
                'nombre' => 'Cliente', 'apellido1' => 'Provisional', 'apellido2' => '',
                'email' => $email, 'password' => '1234', 'direccion' => '',
                'codigoPostal' => '', 'ciudad' => '', 'pais' => ''
            ];
            $userModel->register($datosUsuario);
            $usuarioNuevo = $userModel->findByEmail($email);
            $idCliente = $usuarioNuevo['id_viajero'];
        }

        // 2. PREPARAR DADES
        $tipo = $_POST['id_tipo_reserva']; 
        
        // Recollim data i hora del formulari
        $fechaRaw = $_POST['fecha_vuelo'];
        
        if ($tipo == '1') {
            $horaRaw = $_POST['hora_vuelo'];
        } else {
            $horaRaw = $_POST['hora_recogida'];
        }

        // Assegurem format d'hora HH:MM:SS
        if (strlen($horaRaw) == 5) {
            $horaRaw .= ":00";
        }

        $datetimeCompleto = $fechaRaw . ' ' . $horaRaw;

        $datosReserva = [
            'id_tipo_reserva' => $tipo,
            'id_destino' => $_POST['id_hotel'],
            'id_vehiculo' => $_POST['id_vehiculo'],
            'num_viajeros' => $_POST['num_viajeros'],
            'email_cliente' => $idCliente,
            'numero_vuelo_entrada' => $_POST['numero_vuelo'],
            
            // Omplim TOTS els camps de data/hora amb el DATETIME complet
            // Així evitem errors de format i de nuls.
            'fecha_entrada' => $fechaRaw,
            'hora_entrada' => $datetimeCompleto, 
            'origen_vuelo_entrada' => $_POST['origen_vuelo'] ?? '-',
            
            'fecha_vuelo_salida' => $fechaRaw,
            'hora_vuelo_salida' => $datetimeCompleto, 
        ];

        // Si és el cas específic, assegurem les dades correctes, 
        // però mantenim els valors per defecte als altres per no trencar la BBDD
        if ($tipo == '1') {
            // ARRIBADA
            $datosReserva['origen_vuelo_entrada'] = $_POST['origen_vuelo'];
        } 
        // Si és SORTIDA, ja hem posat els valors per defecte a dalt

        // 3. CRIDAR AL MODEL
        $reservaModel = new Reserva($this->pdo);
        $localizador = $reservaModel->create($datosReserva);

        if ($localizador) {
            header('Location: /admin/reserva/detalles?loc=' . $localizador);
            exit;
        } else {
            $_SESSION['error_message'] = "Error al guardar.";
            header('Location: /admin/reserva/nueva');
            exit;
        }
    }

    public function showReservaDetails()
    {
        $this->checkAdmin();
        $localizador = $_GET['loc'] ?? null;
        if (!$localizador) { echo "Error: Falta localizador."; return; }

        try {
            $sql = "SELECT r.*, 
                           h.usuario as nombre_hotel, 
                           v.Descripción as nombre_vehiculo,
                           u.email as email_real_cliente
                    FROM transfer_reservas r
                    LEFT JOIN tranfer_hotel h ON r.id_destino = h.id_hotel
                    LEFT JOIN transfer_vehiculo v ON r.id_vehiculo = v.id_vehiculo
                    LEFT JOIN transfer_viajeros u ON r.email_cliente = u.id_viajero
                    WHERE r.localizador = :loc";

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':loc' => $localizador]);
            $reserva = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$reserva) { echo "Reserva no encontrada."; return; }
            require_once __DIR__ . '/../views/admin/reserva_detalles.php';

        } catch (PDOException $e) {
            die("Error SQL: " . $e->getMessage());
        }
    }
    public function listReservas()
    {
        $this->checkAdmin();

        // 1. Instanciem el model
        $reservaModel = new Reserva($this->pdo);
        
        // 2. Obtenim totes les dades
        $reservas = $reservaModel->getAll();

        // 3. Carreguem la vista (que crearem ara)
        require_once __DIR__ . '/../views/admin/reservas_list.php';
    }
    private function checkAdmin() {
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
            header('Location: /login');
            exit;
        }
    }
}
?>