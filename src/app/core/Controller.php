<?php
class Controller {
    // Método para cargar modelos
    public function model($model) {
        require_once __DIR__ . "/../models/$model.php";
        return new $model();
    }
    // Método para cargar vistas
    public function view($view, $data = []) {
        extract($data);
        require __DIR__ . "/../views/$view.php";
    }
}