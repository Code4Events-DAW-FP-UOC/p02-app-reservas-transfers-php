<?php
// src/config/config.php

// Parametros de conexión a la base de datos
define('DB_HOST', 'db');                // El nombre del servicio en Docker, NO 'localhost'
define('DB_NAME', 'islatransfers');     // Nombre de la base de datos
define('DB_USER', 'islatransfers');     // Usuario
define('DB_PASS', 'islatransfers');     // Contraseña

function getPDO() {
    try {
        $dsn = 'mysql:host='. DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4';
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ];
        return new PDO($dsn, DB_USER, DB_PASS, $options);
    } catch (PDOException $e) {
        die ("Error de conexión a la base de datos: ". $e->getMessage());
    }
}
?>