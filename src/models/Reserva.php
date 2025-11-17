<?php

class Reserva
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function create($data)
    {
        $localizador = 'LOC-' . strtoupper(substr(md5(uniqid()), 0, 6));
        $fecha_actual = date('Y-m-d H:i:s');

        // --- ARREGLAMENT: BUSQUEM UN ID D'HOTEL VÀLID ---
        // Com que l'admin fa la reserva, assignem-la al primer hotel que trobem
        // per evitar errors de claus foranes.
        $stmtHotel = $this->pdo->query("SELECT id_hotel FROM tranfer_hotel LIMIT 1");
        $hotelValid = $stmtHotel->fetchColumn();
        
        if (!$hotelValid) {
            die("ERROR CRÍTIC: No hi ha cap hotel a la base de dades 'tranfer_hotel'. Crea'n un primer.");
        }
        // -----------------------------------------------

        $sql = "INSERT INTO transfer_reservas (
                    localizador, 
                    id_tipo_reserva, 
                    email_cliente, 
                    fecha_reserva, 
                    fecha_modificacion, 
                    id_destino, 
                    fecha_entrada, 
                    hora_entrada, 
                    numero_vuelo_entrada, 
                    origen_vuelo_entrada, 
                    fecha_vuelo_salida, 
                    hora_vuelo_salida, 
                    num_viajeros, 
                    id_vehiculo,
                    id_hotel 
                ) VALUES (
                    :localizador, 
                    :id_tipo_reserva, 
                    :email_cliente, 
                    :fecha_reserva, 
                    :fecha_modificacion, 
                    :id_destino, 
                    :fecha_entrada, 
                    :hora_entrada, 
                    :numero_vuelo_entrada, 
                    :origen_vuelo_entrada, 
                    :fecha_vuelo_salida, 
                    :hora_vuelo_salida, 
                    :num_viajeros, 
                    :id_vehiculo,
                    :hotel_real 
                )"; // <-- Hem canviat l'1 per :hotel_real

        try {
            $stmt = $this->pdo->prepare($sql);
            
            $stmt->execute([
                ':localizador' => $localizador,
                ':id_tipo_reserva' => $data['id_tipo_reserva'],
                ':email_cliente' => $data['email_cliente'],
                ':fecha_reserva' => $fecha_actual,
                ':fecha_modificacion' => $fecha_actual,
                ':id_destino' => $data['id_destino'],
                ':fecha_entrada' => $data['fecha_entrada'],
                ':hora_entrada' => $data['hora_entrada'],
                ':numero_vuelo_entrada' => $data['numero_vuelo_entrada'],
                ':origen_vuelo_entrada' => $data['origen_vuelo_entrada'],
                ':fecha_vuelo_salida' => $data['fecha_vuelo_salida'],
                ':hora_vuelo_salida' => $data['hora_vuelo_salida'],
                ':num_viajeros' => $data['num_viajeros'],
                ':id_vehiculo' => $data['id_vehiculo'],
                ':hotel_real' => $hotelValid // <-- Usem l'ID vàlid que hem trobat
            ]);

            return $localizador;

        } catch (PDOException $e) {
        error_log("Error SQL: " . $e->getMessage());
        return false; 
    }
    }
    public function getAll()
    {
        try {
            // Fem JOINs per no veure només IDs (1, 2...), sinó noms (Hotel X, Taxi Y...)
            // Usem 'LEFT JOIN' per si algun hotel/vehicle s'ha esborrat, que no peti la llista.
            $sql = "SELECT r.*, 
                           h.usuario as nombre_hotel, 
                           v.Descripción as nombre_vehiculo,
                           u.email as email_cliente_real,
                           u.nombre as nombre_cliente,
                           u.apellido1 as apellido_cliente
                    FROM transfer_reservas r
                    LEFT JOIN tranfer_hotel h ON r.id_destino = h.id_hotel
                    LEFT JOIN transfer_vehiculo v ON r.id_vehiculo = v.id_vehiculo
                    LEFT JOIN transfer_viajeros u ON r.email_cliente = u.id_viajero
                    ORDER BY r.fecha_reserva DESC"; // Les més noves primer

            $stmt = $this->pdo->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            error_log("Error getAll: " . $e->getMessage());
            return [];
        }
    }

    // funcio x obtenir reserves d'un usuari (per al panel client!)
    public function getByUserId($userId)
    {
        try {
            $sql = "SELECT r.*, 
                           h.usuario as nombre_hotel, 
                           v.Descripción as nombre_vehiculo
                    FROM transfer_reservas r
                    LEFT JOIN tranfer_hotel h ON r.id_destino = h.id_hotel
                    LEFT JOIN transfer_vehiculo v ON r.id_vehiculo = v.id_vehiculo
                    WHERE r.email_cliente = :uid  -- Filtrem per ID d'usuari
                    ORDER BY r.fecha_reserva DESC";

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':uid' => $userId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            error_log("Error getByUserId: " . $e->getMessage());
            return [];
        }
    }
} 
?>