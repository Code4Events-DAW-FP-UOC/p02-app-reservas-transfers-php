<?php
// src/controllers/ReservasController.php

require_once __DIR__ . '/../models/Reserva.php';

class ReservasController
{
    public function listado()
    {
        $reservas = Reserva::getAll();
        include __DIR__ . '/../views/reservas_listado.php';
    }
}