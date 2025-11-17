<?php
require_once __DIR__ . "/../core/Model.php";

class Reserva extends Model {
     public function findById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM `transfer_reservas` WHERE id_reserva = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($localizador, $id_hotel, $id_tipo_reserva, $email, $fecha_reserva, $fecha_modificacion, $id_destino, $fecha_entrada, $hora_entrada, $numero_vuelo_entrada, $origen_vuelo_entrada, $hora_vuelo_salida, $fecha_vuelo_salida, $num_viajeros, $id_vehiculo, $creador_id) {
        $stmt = $this->pdo->prepare("INSERT INTO `transfer_reservas` (`localizador`, `id_hotel`, `id_tipo_reserva`, `email_cliente`, `fecha_reserva`, `fecha_modificacion`, `id_destino`, `fecha_entrada`, `hora_entrada`,`numero_vuelo_entrada`, `origen_vuelo_entrada`, `hora_vuelo_salida`, `fecha_vuelo_salida`, `num_viajeros`, `id_vehiculo`, `id_creador`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        return $stmt->execute([$localizador, $id_hotel, $id_tipo_reserva, $email, $fecha_reserva, $fecha_modificacion, $id_destino, $fecha_entrada, $hora_entrada, $numero_vuelo_entrada, $origen_vuelo_entrada, $hora_vuelo_salida, $fecha_vuelo_salida, $num_viajeros, $id_vehiculo, $creador_id]);
    }

    public function getReservas() {
        $sql = "SELECT 
                r.localizador,
                r.fecha_modificacion,
                tr.Descripción AS tipo_reserva_desc,
                h.nombre_hotel,
                v.email AS email_cliente,
                vh.Descripción AS vehiculo_desc,
                r.num_viajeros,
                r.numero_vuelo_entrada,
                r.id_reserva,
                r.fecha_entrada,
                r.hora_entrada,
                r.origen_vuelo_entrada,
                r.fecha_vuelo_salida,
                r.hora_vuelo_salida,
                vc.email AS email_creador            
            FROM 
                transfer_reservas AS r
            LEFT JOIN 
                transfer_tipo_reserva AS tr ON r.id_tipo_reserva = tr.id_tipo_reserva
            LEFT JOIN 
                tranfer_hotel AS h ON r.id_destino = h.id_hotel
            LEFT JOIN 
                transfer_viajeros AS v ON r.email_cliente = v.id_viajero
            LEFT JOIN 
                transfer_vehiculo AS vh ON r.id_vehiculo = vh.id_vehiculo
            LEFT JOIN
                transfer_viajeros AS vc ON r.id_creador = vc.id_viajero
            ORDER BY 
                r.fecha_modificacion DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteReserva($id){
        $stmt = $this->pdo->prepare("DELETE FROM `transfer_reservas` WHERE id_reserva = ?");
        return $stmt->execute([$id]);
    }

    public function updateReserva($id, $localizador, $id_hotel, $id_tipo_reserva, $email, $fecha_reserva, $fecha_modificacion, $id_destino, $fecha_entrada, $hora_entrada, $numero_vuelo_entrada, $origen_vuelo_entrada, $hora_vuelo_salida, $fecha_vuelo_salida, $num_viajeros, $id_vehiculo) {
        $stmt = $this->pdo->prepare("UPDATE `transfer_reservas` SET `localizador` = ?, `id_hotel` = ?, `id_tipo_reserva` = ?, `email_cliente` = ?, `fecha_reserva` = ?, `fecha_modificacion` = ?, `id_destino` = ?, `fecha_entrada` = ?, `hora_entrada` = ?,`numero_vuelo_entrada` = ?,`origen_vuelo_entrada` = ?,`hora_vuelo_salida` = ?,`fecha_vuelo_salida` = ?,`num_viajeros` = ?,`id_vehiculo` = ? WHERE id_reserva = ?");
        $stmt->execute([$localizador, $id_hotel, $id_tipo_reserva, $email, $fecha_reserva, $fecha_modificacion, $id_destino, $fecha_entrada, $hora_entrada, $numero_vuelo_entrada, $origen_vuelo_entrada, $hora_vuelo_salida, $fecha_vuelo_salida, $num_viajeros, $id_vehiculo, $id]);
        return $stmt->rowCount() >= 0;
    }
}