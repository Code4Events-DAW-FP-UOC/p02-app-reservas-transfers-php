<?php
//app/models/Reserva.php

/**
 * Modelo para gestionar las reservas
 */
class Reserva extends Model
{
    // ================== MÉTODOS CRUD ==================

    /**
     * Obtiener todas las reservas de la base de datos
     * @return array Lista de reservas
     */
    public function getAll()
    {
        $db = $this->db();
        $stmt = $db->query("SELECT * FROM transfer_reservas ORDER BY id_reserva ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtiene una reserva por su ID
     * @param int $id
     * @return array|null Reserva encontrada o null si no existe
     */
    public function getById($id)
    {
        $db = $this->db();
        $stmt = $db->prepare("SELECT * FROM transfer_reservas WHERE id_reserva = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Crea una nueva reserva en la base de datos
     * @param array $reserva Datos de la reserva
     * @return bool True si se creó correctamente
     * @throws Exception Si hay errores de validación
     */
    public function create($reserva)
    {
        // === Validación de datos ===  
        $this->validar($reserva, false);

        // === Generar localizador único ===
        $localizador = $this->generarLocalizador();

        // === Inserción en base de datos ===
        $db = $this->db();
        $stmt = $db->prepare("INSERT INTO transfer_reservas
        (localizador, id_hotel, id_tipo_reserva, id_viajero, id_creador, fecha_reserva, fecha_modificacion, id_destino, fecha_entrada, hora_entrada, numero_vuelo_entrada, origen_vuelo_entrada, hora_vuelo_salida, fecha_vuelo_salida, num_viajeros, id_vehiculo)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        // Auxiliar local para controlar nulos y vacíos
        $nullSiVacio = function ($valor) {
            return (isset($valor) && $valor !== '' && strtolower($valor) !== 'null') ? $valor : null;
        };

        return $stmt->execute([
            $localizador,
            $nullSiVacio($reserva['id_hotel'] ?? null),
            $reserva['id_tipo_reserva'],
            $reserva['id_viajero'],
            $reserva['id_creador'], // <--- este es nuevo
            $reserva['fecha_reserva'],
            $reserva['fecha_modificacion'] ?? date('Y-m-d H:i:s'),
            $nullSiVacio($reserva['id_destino'] ?? null),
            $nullSiVacio($reserva['fecha_entrada'] ?? null),
            $nullSiVacio($reserva['hora_entrada'] ?? null),
            $nullSiVacio($reserva['numero_vuelo_entrada'] ?? null),
            $nullSiVacio($reserva['origen_vuelo_entrada'] ?? null),
            $nullSiVacio($reserva['hora_vuelo_salida'] ?? null),
            $nullSiVacio($reserva['fecha_vuelo_salida'] ?? null),
            $nullSiVacio($reserva['num_viajeros'] ?? null),
            $nullSiVacio($reserva['id_vehiculo'] ?? null),
        ]);
    }

    /**
     * Actualiza los datos de una reserva existente en la base de datos
     * @param int $id ID de la reserva
     * @param array $reserva Datos a actualizar
     * @return bool True si la actualización fue exitosa
     * @throws Exception Si hay errores de validación
     */
    public function update($id, $reserva)
    {
        // === Validación de datos ===  
        $this->validar($reserva, true);

        $db = $this->db();
        $fecha_modificacion = date('Y-m-d H:i:s');

        /** 
         * Convierte valores vacíos ('', null, 'null') en NULL real para MySQL
         */
        $nullSiVacio = function ($v) {
            if (!isset($v)) return null;
            if ($v === '') return null;
            if (strtolower($v) === 'null') return null;
            return $v;
        };

        $stmt = $db->prepare("UPDATE transfer_reservas SET 
            id_hotel = ?, 
            id_tipo_reserva = ?, 
            id_viajero = ?, 
            fecha_modificacion = ?,
            id_destino = ?, 
            fecha_entrada = ?, 
            hora_entrada = ?, 
            numero_vuelo_entrada = ?, 
            origen_vuelo_entrada = ?, 
            hora_vuelo_salida = ?, 
            fecha_vuelo_salida = ?, 
            num_viajeros = ?, 
            id_vehiculo = ?
        WHERE id_reserva = ?");

        return $stmt->execute([
            $nullSiVacio($reserva['id_hotel'] ?? null),
            $reserva['id_tipo_reserva'],
            $reserva['id_viajero'],
            $fecha_modificacion,
            $nullSiVacio($reserva['id_destino'] ?? null),
            $nullSiVacio($reserva['fecha_entrada'] ?? null),
            $nullSiVacio($reserva['hora_entrada'] ?? null),
            $nullSiVacio($reserva['numero_vuelo_entrada'] ?? null),
            $nullSiVacio($reserva['origen_vuelo_entrada'] ?? null),
            $nullSiVacio($reserva['hora_vuelo_salida'] ?? null),
            $nullSiVacio($reserva['fecha_vuelo_salida'] ?? null),
            $nullSiVacio($reserva['num_viajeros'] ?? null),
            $nullSiVacio($reserva['id_vehiculo'] ?? null),
            $id
        ]);
    }

    /**
     * Elimina una reserva por su ID
     * @param int $id
     * return bool True si la eliminación fue exitosa
     */
    public function delete($id)
    {
        $db = $this->db();
        $stmt = $db->prepare("DELETE FROM transfer_reservas WHERE id_reserva = ?");
        return $stmt->execute([$id]);
    }

    // ================== MÉTODOS AUXILIARES (HELPERS) ==================

    /**
     * Valida los datos de la reserva antes de crear o actualizar.
     * @param array $datos
     * @param bool $esUpdate
     * @throws Exception Si hay algún error
     */
    private function validar($datos, $esUpdate = false)
    {
        $errores = [];
        // Solo obligatorio en creación
        if (!$esUpdate && empty($datos['fecha_reserva'])) {
            $errores[] = 'Fecha de reserva obligatoria';
        }
        if (empty($datos['id_tipo_reserva'])) $errores[] = 'Tipo de reserva obligatorio';
        if (empty($datos['id_viajero']))      $errores[] = 'Viajero obligatorio';
        if (empty($datos['id_vehiculo']))     $errores[] = 'Vehículo obligatorio';

        // ... resto de validaciones según el tipo ...
        switch ($datos['id_tipo_reserva']) {
            case 1:
                if (empty($datos['numero_vuelo_entrada'])) $errores[] = 'Número de vuelo de entrada obligatorio';
                if (empty($datos['origen_vuelo_entrada'])) $errores[] = 'Origen de vuelo de entrada obligatorio';
                break;
            case 2:
                if (empty($datos['hora_vuelo_salida'])) $errores[] = 'Hora de vuelo de salida obligatoria';
                break;
            case 3:
                if (empty($datos['numero_vuelo_entrada'])) $errores[] = 'Número de vuelo de entrada obligatorio';
                if (empty($datos['origen_vuelo_entrada'])) $errores[] = 'Origen de vuelo de entrada obligatorio';
                if (empty($datos['hora_vuelo_salida'])) $errores[] = 'Hora de vuelo de salida obligatoria';
                break;
        }

        if (!empty($errores)) {
            throw new Exception('Errores en la reserva: ' . implode(', ', $errores));
        }

        // === Validación de fechas de viaje ===
        $hoy = new DateTimeImmutable('today');

        // --- Fecha de entrada (ida) ---
        if (!empty($datos['fecha_entrada'])) {
            $fechaEntrada = DateTimeImmutable::createFromFormat('Y-m-d', $datos['fecha_entrada']);

            if (!$fechaEntrada) {
                throw new Exception('La fecha de llegada no es válida.');
            }

            // No permitir fechas anteriores a hoy
            if ($fechaEntrada < $hoy) {
                throw new Exception('La fecha de llegada no puede ser anterior a hoy.');
            }
        }

        // --- Fecha de salida (vuelta) ---
        if (!empty($datos['fecha_vuelo_salida'])) {
            $fechaSalida = DateTimeImmutable::createFromFormat('Y-m-d', $datos['fecha_vuelo_salida']);

            if (!$fechaSalida) {
                throw new Exception('La fecha de salida no es válida.');
            }

            // No permitir fechas anteriores a hoy
            if ($fechaSalida < $hoy) {
                throw new Exception('La fecha de salida no puede ser anterior a hoy.');
            }
        }

        // --- Comprobación ida/vuelta: salida > entrada ---
        if (!empty($datos['fecha_entrada']) && !empty($datos['fecha_vuelo_salida'])) {
            // En este punto $fechaEntrada y $fechaSalida ya deberían estar definidos
            if ($fechaSalida <= $fechaEntrada) {
                throw new Exception('En reservas de ida y vuelta, la fecha de salida debe ser posterior a la fecha de entrada.');
            }
        }
    }


    /**
     * Genera un localizador único para la reserva
     * @return string
     */
    private function generarLocalizador()
    {
        do {
            $localizador = strtoupper(bin2hex(random_bytes(4)));
            $db = $this->db();
            $stmt = $db->prepare("SELECT COUNT(*) FROM transfer_reservas WHERE localizador = ?");
            $stmt->execute([$localizador]);
            $existe = $stmt->fetchColumn();
        } while ($existe > 0);
        return $localizador;
    }

    /**
     * Obtiene todas las reservas con información descriptiva
     * JOIN con hotel, viajero, tipo de reserva y vehículo
     *
     * @return array
     */
    public function getAllWithDetails()
    {
        $db = $this->db();
        $sql = "
        SELECT
            r.id_reserva,
            r.localizador,
            r.fecha_reserva,
            r.fecha_modificacion,
            r.fecha_entrada,
            r.hora_entrada,
            r.numero_vuelo_entrada,
            r.origen_vuelo_entrada,
            r.hora_vuelo_salida,
            r.fecha_vuelo_salida,
            r.num_viajeros,
            h.nombre AS hotel_nombre,
            v.nombre AS viajero_nombre,
            v.apellido1 AS viajero_apellido1,
            v.apellido2 AS viajero_apellido2,
            ve.descripcion AS vehiculo_descripcion,
            t.descripcion AS tipo_reserva,
            hd.nombre AS destino_nombre -- <<---- ¡aquí!
        FROM transfer_reservas r
        LEFT JOIN transfer_hoteles h ON r.id_hotel = h.id_hotel
        LEFT JOIN transfer_viajeros v ON r.id_viajero = v.id_viajero
        LEFT JOIN transfer_vehiculos ve ON r.id_vehiculo = ve.id_vehiculo
        LEFT JOIN transfer_tipo_reservas t ON r.id_tipo_reserva = t.id_tipo_reserva
        LEFT JOIN transfer_hoteles hd ON r.id_destino = hd.id_hotel -- <<---- este JOIN es para el destino
        ORDER BY r.id_reserva ASC
    ";
        $stmt = $db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtiene todas las reservas para un usuario con nombres descriptivos
     * @param int $id_viajero
     * @return array
     */
    public function getByViajeroIdWithDetails($id_viajero)
    {
        $db = $this->db();
        $stmt = $db->prepare("
            SELECT r.*, 
                h.nombre AS hotel_nombre, 
                d.nombre AS destino_hotel,
                t.descripcion AS tipo_reserva_nombre,
                c.nombre AS creador_nombre, c.apellido1 AS creador_apellido1, c.rol AS creador_rol
            FROM transfer_reservas r
            LEFT JOIN transfer_hoteles h ON r.id_hotel = h.id_hotel
            LEFT JOIN transfer_hoteles d ON r.id_destino = d.id_hotel
            LEFT JOIN transfer_tipo_reservas t ON r.id_tipo_reserva = t.id_tipo_reserva
            LEFT JOIN transfer_viajeros c ON r.id_creador = c.id_viajero
            WHERE r.id_viajero = ?
            ORDER BY r.fecha_reserva DESC
        ");
        $stmt->execute([$id_viajero]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Devuelve una reserva con nombres descriptivos (por id)
     * @param int $id_reserva
     * @return array|null
     */
    public function getByIdWithDetails($id)
    {
        $db = $this->db();
        $stmt = $db->prepare("
            SELECT  r.*, 
                    h.nombre AS hotel_nombre, 
                    d.nombre AS destino_hotel,
                    t.descripcion AS tipo_reserva_nombre,
                    CONCAT(v.nombre, ' ', v.apellido1) AS nombre_viajero,
                    v.email AS email_viajero,
                    ve.descripcion AS vehiculo_descripcion
            FROM transfer_reservas r
            LEFT JOIN transfer_hoteles h ON r.id_hotel = h.id_hotel
            LEFT JOIN transfer_hoteles d ON r.id_destino = d.id_hotel
            LEFT JOIN transfer_tipo_reservas t ON r.id_tipo_reserva = t.id_tipo_reserva
            LEFT JOIN transfer_viajeros v ON r.id_viajero = v.id_viajero
            LEFT JOIN transfer_vehiculos ve ON r.id_vehiculo = ve.id_vehiculo
            WHERE r.id_reserva = ?
            LIMIT 1
        ");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    /**
     * Obtiene reservas de un mes/año.
     */
    public function getByMonth($month, $year)
    {
        $db = $this->db();
        $stmt = $db->prepare("SELECT * FROM transfer_reservas WHERE MONTH(fecha_entrada) = ? AND YEAR(fecha_entrada) = ?");
        $stmt->execute([$month, $year]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtiene reservas por semana/año.
     */
    public function getByWeek($week, $year)
    {
        $db = $this->db();
        $stmt = $db->prepare("SELECT * FROM transfer_reservas WHERE WEEK(fecha_entrada, 1) = ? AND YEAR(fecha_entrada) = ?");
        $stmt->execute([$week, $year]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtiene reservas por día.
     */
    public function getByDay($day)
    {
        $db = $this->db();
        $stmt = $db->prepare("SELECT * FROM transfer_reservas WHERE DATE(fecha_entrada) = ?");
        $stmt->execute([$day]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtiene todas las reservas para un usuario concreto (por id_viajero)
     * @param int $id_viajero
     * @return array
     */
    public function getByViajeroId($id_viajero)
    {
        $db = $this->db();
        $stmt = $db->prepare("SELECT * FROM transfer_reservas WHERE id_viajero = ? ORDER BY fecha_reserva DESC");
        $stmt->execute([$id_viajero]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtiene todas las reservas entre dos fechas (inclusive).
     * Retorna campos descriptivos (no IDs).
     */
    public function getReservasByRangoFechas($fechaInicio, $fechaFin)
    {
        $db = $this->db();
        $sql = "
        SELECT r.*, 
            t.descripcion AS descripcion_tipo, 
            h.nombre AS nombre_hotel, 
            vh.nombre AS destino_hotel,
            CONCAT(v.nombre, ' ', v.apellido1) AS nombre_viajero,
            v.email AS email_viajero
        FROM transfer_reservas r
        LEFT JOIN transfer_tipo_reservas t ON r.id_tipo_reserva = t.id_tipo_reserva
        LEFT JOIN transfer_hoteles h ON r.id_hotel = h.id_hotel
        LEFT JOIN transfer_hoteles vh ON r.id_destino = vh.id_hotel
        LEFT JOIN transfer_viajeros v ON r.id_viajero = v.id_viajero
        WHERE 
            (r.fecha_entrada BETWEEN ? AND ? OR r.fecha_vuelo_salida BETWEEN ? AND ?)
        ORDER BY r.fecha_entrada ASC, r.hora_entrada ASC
        ";
        $stmt = $db->prepare($sql);
        $stmt->execute([$fechaInicio, $fechaFin, $fechaInicio, $fechaFin]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
