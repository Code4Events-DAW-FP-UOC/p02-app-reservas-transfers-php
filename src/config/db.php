<?php
$host = 'db';          
$dbname = 'isla_transfers'; 
$username = 'root';
$password = 'root';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $pdo->exec("SET NAMES 'utf8'");
    
} catch (PDOException $e) {
    die("ERROR: No s'ha pogut connectar a la base de dades. " . $e->getMessage());
}

?>