<?php
// app/models/Precio.php

/**
 * Modelo para gestionar los precios de transfer
 */
class Precio extends Model
{
    /**
     * Obtiene todos los precios de la base de datos
     * @return array Lista de precios
     */
    public function getAll()
    {
        $db = $this->db();
        $stmt = $db->query("SELECT * FROM transfer_precios ORDER BY id_precios ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtiene un precio por su ID
     * @param int $id
     * @return array|null Precio encontrado o null si no existe
     */
    public function getById($id)
    {
        $db = $this->db();
        $stmt = $db->prepare("SELECT * FROM transfer_precios WHERE id_precios = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Crea un nuevo precio
     * @param array $precio Datos del precio (id_vehiculo, id_hotel, precio)
     * @return bool True si se creó correctamente
     * @throws Exception Si hay errores de validación
     */
    public function create($precio)
    {
        // === Validación de datos ===
        $this->validar($precio);

        // === Inserción en base de datos ===
        $db = $this->db();
        $stmt = $db->prepare("INSERT INTO transfer_precios (id_vehiculo, id_hotel, Precio) VALUES (?, ?, ?)");
        return $stmt->execute([
            $precio['id_vehiculo'],
            $precio['id_hotel'],
            $precio['precio'],
        ]);
    }

    /**
     * Actualiza los datos de un precio existente
     * @param int $id
     * @param array $precio
     * @return bool
     * @throws Exception Si hay errores de validación
     */
    public function update($id, $precio)
    {
        // === Validación de datos ===
        $this->validar($precio);

        // === Actualización en base de datos ===
        $db = $this->db();
        $stmt = $db->prepare("UPDATE transfer_precios SET id_vehiculo = ?, id_hotel = ?, Precio = ? WHERE id_precios = ?");
        return $stmt->execute([
            $precio['id_vehiculo'],
            $precio['id_hotel'],
            $precio['precio'],
            $id
        ]);
    }

    /**
     * Elimina un precio por su ID
     * @param int $id
     * @return bool
     */
    public function delete($id)
    {
        $db = $this->db();
        try {
            $stmt = $db->prepare("DELETE FROM transfer_precios WHERE id_precios = ?");
            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            if ($e->getCode() === '23000') {
                throw new Exception("No se puede eliminar este precio porque está vinculado.");
            }
            throw $e;
        }
    }

    // ================== MÉTODOS AUXILIARES (HELPERS) ==================

    /**
     * Valida los datos del precio antes de crear o actualizar.
     * @param array $datos
     * @throws Exception Si hay algún error
     */
    private function validar($datos)
    {
        if (empty($datos['id_vehiculo'])) {
            throw new Exception('El vehículo es obligatorio');
        }
        if (empty($datos['id_hotel'])) {
            throw new Exception('El hotel es obligatorio');
        }
        if (!isset($datos['precio']) || !is_numeric($datos['precio']) || $datos['precio'] < 0) {
            throw new Exception('El precio debe ser un valor numérico válido y positivo');
        }
    }
}
