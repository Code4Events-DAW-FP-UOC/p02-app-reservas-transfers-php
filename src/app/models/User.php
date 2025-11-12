<?php
require_once __DIR__ . "/../core/Model.php";

class User extends Model {
    public function findByEmail($email) {
        $stmt = $this->pdo->prepare("SELECT * FROM `transfer_viajeros` WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($nombre, $apellido1, $apellido2, $direccion, $codigoPostal, $ciudad, $pais, $email, $password, $rol) {
        $stmt = $this->pdo->prepare("INSERT INTO `transfer_viajeros` (`nombre`, `apellido1`, `apellido2`, `direccion`, `codigoPostal`, `ciudad`, `pais`, `email`, `password`,`rol`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        return $stmt->execute([$nombre, $apellido1, $apellido2, $direccion, $codigoPostal, $ciudad, $pais, $email, $password, $rol]);
    }
}