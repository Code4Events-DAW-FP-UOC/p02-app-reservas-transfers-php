<?php
// app/models/user.php

/**
 * Modelo para gestionar los usuarios (particulares y adminstradores)
 */
class User extends Model
{
    // ================== MÉTODOS CRUD ==================

    /**
     * Obitiene todos los usuarios de la base de datos.
     * @return array Lista de usuarios
     */
    public function getAll()
    {
        $db = $this->db();
        $stmt = $db->query("SELECT * FROM transfer_viajeros ORDER BY id_viajero ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtiene un usuario por su ID
     * @param int $id
     * @return array|null Usuario encontrado o null si no existe
     */
    public function getById($id)
    {
        $db = $this->db();
        $stmt = $db->prepare("SELECT * FROM transfer_viajeros WHERE id_viajero = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Obtiene un usuario por su correo electrónico
     * @param string email
     * @return array|null Usuario encontrado o null si no existe, Exception si hay error de validación
     */
    public function getByEmail($email)
    {
        $db = $this->db();
        $stmt = $db->prepare("SELECT * FROM transfer_viajeros WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Crea un nuevo usuario en la base de datos
     * @param array $usuario Datos del usuario (asociativo)
     * @return bool True si se creó correctamente, false su hubo error
     */
    public function create($usuario)
    {
        // === Validación de datos ===
        $this->validar($usuario, false);

        // === Inserción en base de datos ===
        $db = $this->db();
        $hashPassword = SecurityHelper::hashPassword($usuario['password']);
        $stmt = $db->prepare("INSERT INTO transfer_viajeros
        (nombre, apellido1, apellido2, direccion, codigoPostal, ciudad, pais, email, password, rol)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        return $stmt->execute([
            $usuario['nombre'],
            $usuario['apellido1'],
            $usuario['apellido2'],
            $usuario['direccion'],
            $usuario['codigoPostal'],
            $usuario['ciudad'],
            $usuario['pais'],
            $usuario['email'],
            $hashPassword,
            $usuario['rol'],
        ]);
    }

    /**
     * Actualiza los datos de un usuario existente en la base de datos
     * @param int $id ID del usuario
     * @param array $usuario Datos a actualizar
     * @return bool True si la actualización fue exitosa, Exception si hay error de validación
     */
    public function update($id, $usuario)
    {

        // === Validación de datos ===
        $usuario['id_viajero'] = $id;
        $this->validar($usuario, true);



        // === Actualización en base de datos ===
        $db = $this->db();
        $stmt = $db->prepare("UPDATE transfer_viajeros SET nombre = ?, apellido1 = ?, apellido2 = ?, direccion = ?, codigoPostal = ?, ciudad = ?, pais = ?
        WHERE id_viajero = ?");
        return $stmt->execute([
            $usuario['nombre'],
            $usuario['apellido1'],
            $usuario['apellido2'],
            $usuario['direccion'],
            $usuario['codigoPostal'],
            $usuario['ciudad'],
            $usuario['pais'],
            $id,
        ]);
    }

    /**
     * Elimina un usuario por su ID
     * @param int $id
     * @return bool True si la eliminanción fue exitosa
     */
    public function delete($id)
    {
        $db = $this->db();
        try {
            $stmt = $db->prepare("DELETE FROM transfer_viajeros WHERE id_viajero = ?");
            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            // Si el error es de foreign key, lo detectamos
            if ($e->getCode() == '23000') {
                throw new Exception("No se puede eliminar el usuario porque está vinculado a una o más reservas.");
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
        $stmt = $db->prepare("UPDATE transfer_viajeros SET password = ? WHERE id_viajero = ?");
        return $stmt->execute([$hash, $id]);
    }

    /**
     * Comprueba si existe un usuario por email.
     * @param string $email
     * @return int|false Devuelve el ID del usuario si existe, o false si no existe.
     */
    public function existsByEmail($email)
    {
        $db = $this->db();
        $stmt = $db->prepare("SELECT id_viajero FROM transfer_viajeros WHERE email = ?");
        $stmt->execute([$email]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
        return $usuario ? $usuario['id_viajero'] : false;
    }

    /**
     * Valida los datos del usuario antes de crear o actualizar.
     * @param array $datos
     * @param bool $esUpdate
     * @throws Exception Si hay algún error
     */
    private function validar($datos, $esUpdate = false)
    {
        if (empty($datos['nombre'])) throw new Exception('El nombre es obligatorio.');
        if (empty($datos['apellido1'])) throw new Exception('El primer apellido es obligatoria.');
        // Email: Obligatorio solo al crear
        if (!$esUpdate) {
            if (empty($datos['email']) || !filter_var($datos['email'], FILTER_VALIDATE_EMAIL)) {
                throw new Exception('El email es obligatorio y debe ser válido');
            }
        } else {
            if (isset($datos['email']) && $datos['email'] !== '') {
                if (!filter_var($datos['email'], FILTER_VALIDATE_EMAIL)) {
                    throw new Exception('El email no es válido');
                }
            }
        }
        // Contraseña: obligatoria al crear, opcional al editar
        if (!$esUpdate) {
            if (empty($datos['password'])) throw new Exception('La contraseña es obligatoria.');
        } else {
            if (isset($datos['password']) && $datos['password'] !== '') {
            } else {
                unset($datos['password']);
            }
        }

        // --- Validación de unicidad de email ---
        if (isset($datos['email']) && $datos['email'] !== '') {
            $idExistente = $this->existsByEmail($datos['email']);
            if (!$esUpdate && $idExistente) {
                throw new Exception('El email ya está registrado');
            }
            // Si es update, permite que el email coincida solo con el mismo usuario
            if ($esUpdate && $idExistente && $idExistente != ($datos['id_viajero'] ?? null)) {
                throw new Exception('Ese email ya está registrado por otro usuario');
            }
        }
    }
}
