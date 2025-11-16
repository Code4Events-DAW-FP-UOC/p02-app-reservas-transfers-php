<?php
require_once __DIR__ . "/../core/Model.php";

class Hotel extends Model {
    public function findById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM `tranfer_hotel` WHERE id_hotel = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getHoteles() {
        $stmt = $this->pdo->prepare("SELECT * FROM `tranfer_hotel`");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteHotel($id){
        $stmt = $this->pdo->prepare("DELETE FROM `tranfer_hotel` WHERE id_hotel = ?");
        return $stmt->execute([$id]);
    }


    /*
    public function updateHotele($id_viajero, $nombre, $apellido1, $apellido2, $direccion, $codigoPostal, $ciudad, $pais, $email, $password, $rol) {
        $passwordHasheada = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->pdo->prepare("UPDATE `transfer_hotel` SET `nombre` = ?, `apellido1` = ?, `apellido2` = ?, `direccion` = ?, `codigoPostal` = ?, `ciudad` = ?, `pais` = ?, `email` = ?, `password` = ?,`rol` = ? WHERE id_viajero = ?");
        $stmt->execute([$nombre, $apellido1, $apellido2, $direccion, $codigoPostal, $ciudad, $pais, $email, $passwordHasheada, $rol, $id_viajero]);
        return $stmt->rowCount() == 0;
    }
    public function create($nombre, $apellido1, $apellido2, $direccion, $codigoPostal, $ciudad, $pais, $email, $password, $rol) {
        $stmt = $this->pdo->prepare("INSERT INTO `transfer_hotel` (`nombre`, `apellido1`, `apellido2`, `direccion`, `codigoPostal`, `ciudad`, `pais`, `email`, `password`,`rol`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        return $stmt->execute([$nombre, $apellido1, $apellido2, $direccion, $codigoPostal, $ciudad, $pais, $email, $password, $rol]);
    }

    */
}