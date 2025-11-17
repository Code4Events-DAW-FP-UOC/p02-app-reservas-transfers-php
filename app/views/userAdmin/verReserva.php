<?php require __DIR__ . '/../components/header.php'; ?>
<?php require __DIR__ . '/../components/navbar.php'; ?>

<div class="container mt-4" style="max-width: 700px;">
    <div class="card shadow p-4">
        <h2 class="mb-4">Detalle de la Reserva</h2>
        <?php if (empty($reserva)): ?>
            <div class="alert alert-warning">Reserva no encontrada.</div>
        <?php else: ?>
            <dl class="row">
                <dt class="col-sm-4">Localizador</dt>
                <dd class="col-sm-8"><?= htmlspecialchars($reserva['localizador']) ?></dd>

                <dt class="col-sm-4">Tipo de reserva</dt>
                <dd class="col-sm-8"><?= htmlspecialchars($reserva['tipo_reserva_nombre'] ?? $reserva['descripcion_tipo'] ?? '-') ?></dd>

                <dt class="col-sm-4">Hotel de recogida</dt>
                <dd class="col-sm-8"><?= htmlspecialchars($reserva['hotel_nombre'] ?? '-') ?></dd>

                <dt class="col-sm-4">Destino</dt>
                <dd class="col-sm-8"><?= htmlspecialchars($reserva['destino_hotel'] ?? '-') ?></dd>

                <dt class="col-sm-4">Viajero</dt>
                <dd class="col-sm-8">
                    <?= htmlspecialchars($reserva['nombre_viajero'] ?? '-') ?>
                    <?php if (!empty($reserva['email_viajero'])): ?>
                        <span class="d-block text-muted" style="font-size: 0.9em;"><?= htmlspecialchars($reserva['email_viajero']) ?></span>
                    <?php endif; ?>
                </dd>

                <?php if (!empty($reserva['fecha_entrada'])): ?>
                    <dt class="col-sm-4">Fecha de llegada</dt>
                    <dd class="col-sm-8"><?= htmlspecialchars($reserva['fecha_entrada']) ?> <?= htmlspecialchars($reserva['hora_entrada'] ?? '') ?></dd>
                <?php endif; ?>

                <?php if (!empty($reserva['numero_vuelo_entrada'])): ?>
                    <dt class="col-sm-4">Vuelo de entrada</dt>
                    <dd class="col-sm-8">
                        Nº <?= htmlspecialchars($reserva['numero_vuelo_entrada']) ?>
                        <?php if (!empty($reserva['origen_vuelo_entrada'])): ?>
                            (Origen: <?= htmlspecialchars($reserva['origen_vuelo_entrada']) ?>)
                        <?php endif; ?>
                    </dd>
                <?php endif; ?>

                <?php if (!empty($reserva['fecha_vuelo_salida'])): ?>
                    <dt class="col-sm-4">Fecha de vuelo de salida</dt>
                    <dd class="col-sm-8"><?= htmlspecialchars($reserva['fecha_vuelo_salida']) ?> <?= htmlspecialchars($reserva['hora_vuelo_salida'] ?? '') ?></dd>
                <?php endif; ?>

                <?php if (!empty($reserva['numero_vuelo_salida'])): ?>
                    <dt class="col-sm-4">Vuelo de salida</dt>
                    <dd class="col-sm-8">
                        Nº <?= htmlspecialchars($reserva['numero_vuelo_salida']) ?>
                    </dd>
                <?php endif; ?>

                <dt class="col-sm-4">Vehículo</dt>
                <dd class="col-sm-8"><?= htmlspecialchars($reserva['vehiculo_descripcion'] ?? '-') ?></dd>

                <dt class="col-sm-4">Número de viajeros</dt>
                <dd class="col-sm-8"><?= htmlspecialchars($reserva['num_viajeros']) ?></dd>

                <dt class="col-sm-4">Fecha de reserva</dt>
                <dd class="col-sm-8"><?= htmlspecialchars($reserva['fecha_reserva']) ?></dd>

                <dt class="col-sm-4">Última modificación</dt>
                <dd class="col-sm-8"><?= htmlspecialchars($reserva['fecha_modificacion']) ?></dd>
            </dl>
        <?php endif; ?>
        <a href="javascript:history.back()" class="btn btn-secondary mt-2">Volver</a>
    </div>
</div>
<?php require __DIR__ . '/../components/footer.php'; ?>