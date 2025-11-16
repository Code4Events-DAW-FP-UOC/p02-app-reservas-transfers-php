<?php require __DIR__ . '/../components/header.php'; ?>
<?php require __DIR__ . '/../components/navbar.php'; ?>

<div class="container mt-4" style="max-width: 700px;">
    <div class="card shadow p-4">
        <h2 class="mb-4">Detalle de reserva</h2>
        <?php if (empty($reserva)): ?>
            <div class="alert alert-warning">Reserva no encontrada.</div>
        <?php else: ?>
            <dl class="row">
                <dt class="col-sm-4">Localizador</dt>
                <dd class="col-sm-8"><?= htmlspecialchars($reserva['localizador']) ?></dd>

                <dt class="col-sm-4">Fecha reserva</dt>
                <dd class="col-sm-8"><?= htmlspecialchars($reserva['fecha_reserva']) ?></dd>

                <dt class="col-sm-4">Hotel</dt>
                <dd class="col-sm-8"><?= htmlspecialchars($reserva['destino_hotel'] ?? '—') ?></dd>

                <dt class="col-sm-4">Tipo de reserva</dt>
                <dd class="col-sm-8"><?= htmlspecialchars($reserva['tipo_reserva_nombre'] ?? '—') ?></dd>

                <dt class="col-sm-4">Fecha entrada</dt>
                <dd class="col-sm-8"><?= htmlspecialchars($reserva['fecha_entrada'] ?? '') ?></dd>

                <dt class="col-sm-4">Hora entrada</dt>
                <dd class="col-sm-8"><?= htmlspecialchars($reserva['hora_entrada'] ?? '') ?></dd>

                <dt class="col-sm-4">Número vuelo entrada</dt>
                <dd class="col-sm-8"><?= htmlspecialchars($reserva['numero_vuelo_entrada'] ?? '') ?></dd>

                <dt class="col-sm-4">Origen vuelo entrada</dt>
                <dd class="col-sm-8"><?= htmlspecialchars($reserva['origen_vuelo_entrada'] ?? '') ?></dd>

                <dt class="col-sm-4">Fecha vuelo salida</dt>
                <dd class="col-sm-8"><?= htmlspecialchars($reserva['fecha_vuelo_salida'] ?? '') ?></dd>

                <dt class="col-sm-4">Hora vuelo salida</dt>
                <dd class="col-sm-8"><?= htmlspecialchars($reserva['hora_vuelo_salida'] ?? '') ?></dd>

                <dt class="col-sm-4">Número de viajeros</dt>
                <dd class="col-sm-8"><?= htmlspecialchars($reserva['num_viajeros']) ?></dd>
            </dl>
        <?php endif; ?>
        <a href="/user/misreservas" class="btn btn-secondary">Volver a mis reservas</a>
    </div>
</div>
<?php require __DIR__ . '/../components/footer.php'; ?>