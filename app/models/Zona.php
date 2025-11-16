<?php
// app/models/Zona.php

/**
 * Modelo para gestionar las zonas
 */
class Zona extends Model
{
    /**
     * Obtiene todas las zonas de la base de datos
     * @return array Lista de zonas
     */
    public function getAll()
    {
        $db = $this->db();
        $stmt = $db->query("SELECT * FROM transfer_zonas ORDER BY id_zona ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtiene una zona por su ID
     * @param int $id
     * @return array|null Zona encontrada o null si no existe
     */
    public function getById($id)
    {
        $db = $this->db();
        $stmt = $db->prepare("SELECT * FROM transfer_zonas WHERE id_zona = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Crea una nueva zona
     * @param array $zona Datos de la zona
     * @return bool True si se creó correctamente
     * @throws Exception Si hay errores de validación
     */
    public function create($zona)
    {
        // === Validación de datos ===  
        $this->validar($zona);

        // === Inserción en base de datos ===
        $db = $this->db();
        $stmt = $db->prepare("INSERT INTO transfer_zonas (descripcion) VALUES (?)");
        return $stmt->execute([
            $zona['descripcion'],
        ]);
    }

    /**
     * Actualiza una zona existente
     * @param int $id
     * @param array $zona
     * @return bool
     * @throws Exception Si hay errores de validación
     */
    public function update($id, $zona)
    {
        // === Validación de datos ===
        $this->validar($zona);

        // === Actualización en base de datos ===
        $db = $this->db();
        $stmt = $db->prepare("UPDATE transfer_zonas SET descripcion = ? WHERE id_zona = ?");
        return $stmt->execute([
            $zona['descripcion'],
            $id
        ]);
    }

    /**
     * Elimina una zona por su ID
     * @param int $id
     * @return bool
     */
    public function delete($id)
    {
        $db = $this->db();
        try {
            $stmt = $db->prepare("DELETE FROM transfer_zonas WHERE id_zona = ?");
            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            // Si el error es de foreign key, lo detectamos
            if ($e->getCode() == '23000') {
                throw new Exception("No se puede eliminar la zona porque está vinculado a una o más reservas.");
            } else {
                throw $e; // Otros errores
            }
        }
    }

    // ================== MÉTODOS AUXILIARES (HELPERS) ==================

    /**
     * Valida los datos de la zona antes de crear o actualizar.
     * @param array $datos
     * @throws Exception Si hay algún error
     */
    private function validar($datos)
    {
        if (empty($datos['descripcion'])) {
            throw new Exception('La descripción de la zona es obligatoria');
        }
    }
}
