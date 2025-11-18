<?php
// app/models/hotel.php

/**
 * Modelo para gestionar los hoteles
 */
class Hotel extends Model
{
    // ================== MÉTODOS CRUD ==================

    /**
     * Obtiene todos los hoteles de la base de datos
     * @return array Lista de hoteles
     */
    public function getAll()
    {
        $db = $this->db();
        $stmt = $db->query("SELECT * FROM transfer_hoteles ORDER BY id_hotel ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtiene un hotel por si ID
     * @param int $id
     * @return array|null Hotel encontrado o null si no existe
     */
    public function getById($id)
    {
        $db = $this->db();
        $stmt = $db->prepare("SELECT * FROM transfer_hoteles WHERE id_hotel = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Obtiene un hotel por email
     * @param string email
     * @return array|null Hotel encontrado o null si no existe
     */
    public function getByEmail($email)
    {
        $db = $this->db();
        $stmt = $db->prepare("SELECT * FROM transfer_hoteles WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Obitene un hotel por usuario
     * @param string usuario
     * @return array|null Hotel encontrado o null si no existe
     */
    public function getByUsername($usuario)
    {
        $db = $this->db();
        $stmt = $db->prepare("SELECT * FROM transfer_hoteles WHERE usuario = ?");
        $stmt->execute([$usuario]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Crea un nuevo hotel en la base de datos
     * @param array $hotel Datos del hotel
     * @return bool True si se creó correctamente
     * @throws Exception Si hay error de validación
     */
    public function create($hotel)
    {
        // === Validación de datos ===
        $this->validar($hotel, false);

        // === Inserción en base de datos ===
        $db = $this->db();
        $hashPassword = SecurityHelper::hashPassword($hotel['password']);
        $stmt = $db->prepare("INSERT INTO transfer_hoteles
        (nombre, id_zona, comision, usuario, email, password)
        VALUES (?, ?, ?, ?, ?, ?)");
        return $stmt->execute([
            $hotel['nombre'],
            $hotel['id_zona'],
            $hotel['comision'],
            $hotel['usuario'],
            $hotel['email'],
            $hashPassword,
        ]);
    }

    /**
     * Actualiza los datos de un hotel existente en la base de datos
     * @param int $id ID del hotel
     * @param array $hotel Datos a actualizar
     * @return bool True si la actualización fue exitosa
     * @throws Exception Si hay error de validación
     */
    public function update($id, $hotel)
    {
        // === Validación de datos ===
        $hotel['id_hotel'] = $id;
        $this->validar($hotel, true);

        // === Actualización en base de datos ===
        $db = $this->db();
        $stmt = $db->prepare("UPDATE transfer_hoteles SET nombre = ?, id_zona = ?, comision = ?, usuario = ?, email = ? 
        WHERE id_hotel = ?");
        return $stmt->execute([
            $hotel['nombre'],
            $hotel['id_zona'],
            $hotel['comision'],
            $hotel['usuario'],
            $hotel['email'],
            $id,
        ]);
    }

    /**
     * Elimina un usuario por su ID
     * @param int $id
     * return bool True si la eliminación fue exitosa
     */
    public function delete($id)
    {
        $db = $this->db();
        try {
            $stmt = $db->prepare("DELETE FROM transfer_hoteles WHERE id_hotel = ?");
            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            // Si el error es de foreign key, lo detectamos
            if ($e->getCode() == '23000') {
                throw new Exception("No se puede eliminar el hotel porque está vinculado a una o más reservas.");
            } else {
                throw $e; // Otros errores
            }
        }
    }


    // ================== MÉTODOS AUXILIARES (HELPERS) ==================

    /**
     * Cambia la contraseña de la usuario
     * @param int $id
     * @param string $nuevoPassword (en texto plano)
     * @return bool
     */
    public function updatePassword($id, $nuevoPassword)
    {
        $db = $this->db();
        $hash = SecurityHelper::hashPassword($nuevoPassword);
        $stmt = $db->prepare("UPDATE transfer_hoteles SET password = ? WHERE id_hotel = ?");
        return $stmt->execute([$hash, $id]);
    }

    /**
     * Comprueba si existe un hotel por email.
     * @param string $email
     * @return int|false Devuelve el ID del hotel si existe, o false si no existe.
     */
    public function existsByEmail($email)
    {
        $db = $this->db();
        $stmt = $db->prepare("SELECT id_hotel FROM transfer_hoteles WHERE email = ?");
        $stmt->execute([$email]);
        $hotel = $stmt->fetch(PDO::FETCH_ASSOC);
        return $hotel ? $hotel['id_hotel'] : false;
    }

    /**
     * Comprueba si existe un hotel por nombre de usuario.
     * @param string $usuario
     * @return int|false Devuelve el ID del hotel si existe, o false si no existe.
     */
    public function existsByUsername($usuario)
    {
        $db = $this->db();
        $stmt = $db->prepare("SELECT id_hotel FROM transfer_hoteles WHERE usuario = ?");
        $stmt->execute([$usuario]);
        $hotel = $stmt->fetch(PDO::FETCH_ASSOC);
        return $hotel ? $hotel['id_hotel'] : false;
    }

    /**
     * Valida los datos del hotel antes de crear o actualizar.
     * @param array $datos
     * @param bool $esUpdate
     * @throws Exception Si hay algún error
     */
    private function validar($datos, $esUpdate = false)
    {
        if (empty($datos['nombre'])) throw new Exception('El nombre del hotel es obligatorio');
        if (empty($datos['usuario'])) throw new Exception('El nombre de usuario es obligatorio');
        if (empty($datos['email']) || !filter_var($datos['email'], FILTER_VALIDATE_EMAIL)) throw new Exception('El email es obligatorio y debe ser válido');
        if (empty($datos['id_zona'])) throw new Exception('La zona es obligatoria');

        $idEmail = $this->existsByEmail($datos['email']);
        $idUsuario = $this->existsByUsername($datos['usuario']);

        if (!$esUpdate && $idEmail) {
            throw new Exception('El email ya está registrado');
        }
        if (!$esUpdate && $idUsuario) {
            throw new Exception('El nombre de usuario ya está registrado');
        }
        // En update, permite coincidencia solo con el mismo hotel
        if ($esUpdate && $idEmail && $idEmail != $datos['id_hotel']) {
            throw new Exception('Ese email ya está registrado por otro hotel');
        }
        if ($esUpdate && $idUsuario && $idUsuario != $datos['id_hotel']) {
            throw new Exception('Ese nombre de usuario ya está registrado por otro hotel');
        }
    }
    public function countAll()
    {
        $db = $this->db();
        $stmt = $db->query("SELECT COUNT(*) FROM transfer_hoteles");
        return $stmt->fetchColumn();
    }
}
