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

    public function getUsers() {
        $stmt = $this->pdo->prepare("SELECT * FROM `transfer_viajeros`");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteUser($email){
        $stmt = $this->pdo->prepare("DELETE FROM `transfer_viajeros` WHERE email = ?");
        return $stmt->execute([$email]);
    }

    public function updateUser($id_viajero, $nombre, $apellido1, $apellido2, $direccion, $codigoPostal, $ciudad, $pais, $email, $password, $rol) {
        $passwordHasheada = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->pdo->prepare("UPDATE `transfer_viajeros` SET `nombre` = ?, `apellido1` = ?, `apellido2` = ?, `direccion` = ?, `codigoPostal` = ?, `ciudad` = ?, `pais` = ?, `email` = ?, `password` = ?,`rol` = ? WHERE id_viajero = ?");
        $stmt->execute([$nombre, $apellido1, $apellido2, $direccion, $codigoPostal, $ciudad, $pais, $email, $passwordHasheada, $rol, $id_viajero]);
        return $stmt->rowCount() == 0;
    }
}