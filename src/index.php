<?php
require_once __DIR__ . '/config/config.php';
# echo "Hola, esta es la base del proyecto Isla Transfers (MVC básico)";

echo "Prueba de conexión a la BBDD: ";

try {
    $pdo = getPDO();
    echo "¡Conexión OK!";

} catch (Exception $e) {
    echo $e->getMessage();
}
?>