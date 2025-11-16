<?php require __DIR__ . '/../components/header.php'; ?>
<?php require __DIR__ . '/../components/navbar.php'; ?>

<div class="container mt-4">
    <div class="btn-group mb-3">
        <a href="/userAdmin/calendario" class="btn btn-outline-primary">Mes</a>
        <a href="/userAdmin/calendarioSemana" class="btn btn-outline-primary">Semana</a>
        <a href="/userAdmin/calendarioDia" class="btn btn-outline-primary active">Día</a>
    </div>

    <h2 class="mb-4">Calendario de reservas - Vista diaria</h2>
    <table class="table table-bordered table-hover">
        <thead class="table-light">
            <tr>
                <th>Fecha</th>
                <th>Tipo</th>
                <th>Hotel</th>
                <th>Viajero</th>
                <th>Destino</th>
                <th>Nº vuelo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($reservas as $reserva): ?>
                <tr>
                    <td><?= htmlspecialchars($reserva['fecha_entrada'] ?? '-') ?></td>
                    <td><?= htmlspecialchars($reserva['descripcion_tipo'] ?? '-') ?></td>
                    <td><?= htmlspecialchars($reserva['nombre_hotel'] ?? '-') ?></td>
                    <td><?= htmlspecialchars($reserva['nombre_viajero'] ?? '-') ?></td>
                    <td><?= htmlspecialchars($reserva['destino_hotel'] ?? '-') ?></td>
                    <td><?= htmlspecialchars($reserva['numero_vuelo_entrada'] ?? '-') ?></td>
                    <td>
                        <a href="/userAdmin/verReserva/<?= $reserva['id_reserva'] ?>" class="btn btn-sm btn-info">Detalles</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($reservas)): ?>
                <tr>
                    <td colspan="7" class="text-center">No hay reservas para este día.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require __DIR__ . '/../components/footer.php'; ?>