<?php
//app/models/TipoReserva.php

/**
 * Modelo para gestionar los tipos de reserva
 */
class TipoReserva extends Model
{
    // ================== MÉTODOS CRUD ==================

    /**
     * Obtiene todos los tipos de reserva de la base de datos
     * @return array Lista de tipos de reserva
     */
    public function getAll()
    {
        $db = $this->db();
        $stmt = $db->query("SELECT * FROM transfer_tipo_reservas ORDER BY id_tipo_reserva ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtiene un tipo de reserva por su ID
     * @param int $id
     * @return array|null Tipo de reserva encontrado o null si no existe 
     */
    public function getById($id)
    {
        $db = $this->db();
        $stmt = $db->prepare("SELECT * FROM transfer_tipo_reservas WHERE id_tipo_reserva = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Crea un nuevo tipo de reserva en la base de datos
     * @param array $tipo_reserva Datos del tipo de reserva
     * @return bool True si se creó correctamente, false si hubo error
     * @throws Exception Si hay errores de validación
     */
    public function create($tipo_reserva)
    {
        // === Validación de datos ===  
        $this->validar($tipo_reserva, false);

        // === Inserción en base de datos ===
        $db = $this->db();
        $stmt = $db->prepare("INSERT INTO transfer_tipo_reservas (descripcion) VALUES (?)");
        return $stmt->execute([
            $tipo_reserva['descripcion'],
        ]);
    }

    /**
     * Actualiza un tipo de reserva existente
     * @param int $id
     * @param array $tipo_reserva
     * @return bool
     * @throws Exception Si hya errores de validación
     */
    public function update($id, $tipo_reserva)
    {
        $this->validar($tipo_reserva, true);

        $db = $this->db();
        $stmt = $db->prepare("UPDATE transfer_tipo_reservas SET descripcion = ? WHERE id_tipo_reserva = ?");
        return $stmt->execute([
            $tipo_reserva['descripcion'],
            $id
        ]);
    }

    /**
     * Elimina un tipo de reserva por su ID
     * @param int $id
     * @return bool
     */
    public function delete($id)
    {
        $db = $this->db();
        try {
            $stmt = $db->prepare("DELETE FROM transfer_tipo_reservas WHERE id_tipo_reserva = ?");
            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            if ($e->getCode() === '23000') {
                throw new Exception("No se puede eliminar este tipo de reserva porque está vinculado a reservas.");
            }
            throw $e;
        }
    }

    // ================== MÉTODOS AUXILIARES (HELPERS) ==================

    /**
     * Valida los datos del tipo de reserva antes de crear o actualizar.
     * @param array $datos
     * @throws Exception Si hay algún error
     */
    private function validar($datos)
    {
        if (empty($datos['descripcion'])) {
            throw new Exception('La descripción del tipo de reserva es obligatoria');
        }
    }
}
