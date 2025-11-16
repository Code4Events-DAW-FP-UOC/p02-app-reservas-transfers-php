<?php
// app/models/Vehiculo.php

/**
 * Modelo para gestionar los vehículos
 */
class Vehiculo extends Model
{
    /**
     * Obtiene todos los vehículos de la base de datos
     * @return array Lista de vehículos
     */
    public function getAll()
    {
        $db = $this->db();
        $stmt = $db->query("SELECT * FROM transfer_vehiculos ORDER BY id_vehiculo ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtiene un vehículo por su ID
     * @param int $id
     * @return array|null Vehículo encontrado o null si no existe
     */
    public function getById($id)
    {
        $db = $this->db();
        $stmt = $db->prepare("SELECT * FROM transfer_vehiculos WHERE id_vehiculo = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Crea un nuevo vehículo
     * @param array $vehiculo Datos del vehículo
     * @return bool True si se creó correctamente
     * @throws Exception Si hay errores de validación
     */
    public function create($vehiculo)
    {
        // === Validación de datos ===
        $this->validar($vehiculo);

        // === Inserción en base de datos ===
        $db = $this->db();
        $stmt = $db->prepare("INSERT INTO transfer_vehiculos (descripcion, email_conductor, password) VALUES (?, ?, ?)");
        return $stmt->execute([
            $vehiculo['descripcion'],
            $vehiculo['email_conductor'],
            $vehiculo['password'], // aquí podrías usar hash si es requerido
        ]);
    }

    /**
     * Actualiza los datos de un vehículo existente
     * @param int $id
     * @param array $vehiculo
     * @return bool
     * @throws Exception Si hay errores de validación
     */
    public function update($id, $vehiculo)
    {
        // === Validación de datos ===
        $this->validar($vehiculo);

        // === Actualización en base de datos ===
        $db = $this->db();
        $stmt = $db->prepare("UPDATE transfer_vehiculos SET descripcion = ?, email_conductor = ?, password = ? WHERE id_vehiculo = ?");
        $hashPassword = SecurityHelper::hashPassword($vehiculo['password']);
        return $stmt->execute([
            $vehiculo['descripcion'],
            $vehiculo['email_conductor'],
            $hashPassword,
            $id
        ]);
    }

    /**
     * Elimina un vehículo por su ID
     * @param int $id
     * @return bool
     */
    public function delete($id)
    {
        $db = $this->db();
        try {
            $stmt = $db->prepare("DELETE FROM transfer_vehiculos WHERE id_vehiculo = ?");
            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            // Si el error es de foreign key, lo detectamos
            if ($e->getCode() == '23000') {
                throw new Exception("No se puede eliminar el vehiculo porque está vinculado a una o más reservas.");
            } else {
                throw $e; // Otros errores
            }
        }
    }

    // ================== MÉTODOS AUXILIARES (HELPERS) ==================

    /**
     * Cambia la contraseña del usuario
     * @param int $id
     * @param string $nuevoPassword (en texto plano)
     * @return bool
     */
    public function updatePassword($id, $newPassword)
    {
        $db = $this->db();
        $hash = SecurityHelper::hashPassword($newPassword);
        $stmt = $db->prepare("UPDATE transfer_vehiculos SET password = ? WHERE id_vehiculo = ?");
        return $stmt->execute([$hash, $id]);
    }

    /**
     * Valida los datos del vehículo antes de crear o actualizar.
     * @param array $datos
     * @throws Exception Si hay algún error
     */
    private function validar($datos)
    {
        if (empty($datos['descripcion'])) {
            throw new Exception('La descripción del vehículo es obligatoria');
        }
        if (empty($datos['email_conductor']) || !filter_var($datos['email_conductor'], FILTER_VALIDATE_EMAIL)) {
            throw new Exception('El email del conductor es obligatorio y debe ser válido');
        }
        if (empty($datos['password'])) {
            throw new Exception('La contraseña del conductor es obligatoria');
        }
    }
}
