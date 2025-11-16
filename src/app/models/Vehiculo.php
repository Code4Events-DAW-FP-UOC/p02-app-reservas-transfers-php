<?php
require_once __DIR__ . "/../core/Model.php";

class Vehiculo extends Model {
    public function findById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM `transfer_vehiculo` WHERE id_vehiculo = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getVehiculos() {
        $stmt = $this->pdo->prepare("SELECT * FROM `transfer_vehiculo`");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}