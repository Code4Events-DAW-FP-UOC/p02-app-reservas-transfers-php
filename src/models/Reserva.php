<?php
// src/models/Reserva.php

require_once __DIR__ . '/../config/config.php';

class Reserva 
{
    public static function getAll()
    {
        $pdo = getPDO();
        if (!$pdo) {
        die("Error: No se pudo obtener la conexión PDO en Reserva::getAll()");
    }
        $sql = "SELECT * FROM transfer_reservas";
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll();
    }
}

?>