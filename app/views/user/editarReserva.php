<?php require __DIR__ . '/../components/header.php'; ?>
<?php require __DIR__ . '/../components/navbar.php'; ?>

<div class="container mt-4" style="max-width: 900px;">
    <div class="card shadow p-4">
        <h2 class="mb-4">Editar reserva</h2>
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <?php if (!empty($success)): ?>
            <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>

        <form method="post" id="formReserva">
            <!-- Tipo de reserva -->
            <div class="mb-3">
                <label for="id_tipo_reserva" class="form-label">Tipo de reserva<span class="text-danger">*</span></label>
                <select class="form-select" name="id_tipo_reserva" id="id_tipo_reserva" required>
                    <option value="">Seleccione...</option>
                    <?php foreach ($tiposReserva as $tipo): ?>
                        <option value="<?= $tipo['id_tipo_reserva'] ?>" <?= ($reserva['id_tipo_reserva'] == $tipo['id_tipo_reserva'] ? 'selected' : '') ?>>
                            <?= htmlspecialchars($tipo['descripcion']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Aeropuerto -> Hotel -->
            <div id="aeropuertoHotelBlock" style="display:none;">
                <h5 class="mt-3">Datos de llegada (Aeropuerto → Hotel)</h5>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="fecha_entrada" class="form-label">Día de llegada<span class="text-danger">*</span></label>
                        <input type="date" class="form-control" name="fecha_entrada" id="fecha_entrada" value="<?= htmlspecialchars($reserva['fecha_entrada'] ?? '') ?>">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="hora_entrada" class="form-label">Hora de llegada<span class="text-danger">*</span></label>
                        <input type="time" class="form-control" name="hora_entrada" id="hora_entrada" value="<?= htmlspecialchars($reserva['hora_entrada'] ?? '') ?>">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="numero_vuelo_entrada" class="form-label">Número de vuelo<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="numero_vuelo_entrada" id="numero_vuelo_entrada" value="<?= htmlspecialchars($reserva['numero_vuelo_entrada'] ?? '') ?>">
                    </div>
                </div>
                <div class="mb-3">
                    <label for="origen_vuelo_entrada" class="form-label">Aeropuerto de origen<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="origen_vuelo_entrada" id="origen_vuelo_entrada" value="<?= htmlspecialchars($reserva['origen_vuelo_entrada'] ?? '') ?>">
                </div>
            </div>

            <!-- Hotel -> Aeropuerto -->
            <div id="hotelAeropuertoBlock" style="display:none;">
                <h5 class="mt-3">Datos de salida (Hotel → Aeropuerto)</h5>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="fecha_vuelo_salida" class="form-label">Día del vuelo<span class="text-danger">*</span></label>
                        <input type="date" class="form-control" name="fecha_vuelo_salida" id="fecha_vuelo_salida" value="<?= htmlspecialchars($reserva['fecha_vuelo_salida'] ?? '') ?>">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="hora_vuelo_salida" class="form-label">Hora del vuelo<span class="text-danger">*</span></label>
                        <input type="time" class="form-control" name="hora_vuelo_salida" id="hora_vuelo_salida" value="<?= htmlspecialchars($reserva['hora_vuelo_salida'] ?? '') ?>">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="numero_vuelo_salida" class="form-label">Número de vuelo<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="numero_vuelo_salida" id="numero_vuelo_salida" value="<?= htmlspecialchars($reserva['numero_vuelo_salida'] ?? '') ?>">
                    </div>
                </div>
                <div class="mb-3">
                    <label for="hora_entrada_salida" class="form-label">Hora de recogida<span class="text-danger">*</span></label>
                    <input type="time" class="form-control" name="hora_entrada_salida" id="hora_entrada_salida" value="<?= htmlspecialchars($reserva['hora_entrada_salida'] ?? '') ?>">
                </div>
            </div>

            <!-- Hotel de destino/recogida -->
            <div class="mb-3">
                <label for="id_hotel" class="form-label">Hotel de destino/recogida<span class="text-danger">*</span></label>
                <select class="form-select" name="id_hotel" id="id_hotel" required>
                    <option value="">Seleccione hotel...</option>
                    <?php foreach ($hoteles as $hotel): ?>
                        <option value="<?= $hotel['id_hotel'] ?>" <?= ($reserva['id_hotel'] == $hotel['id_hotel'] ? 'selected' : '') ?>>
                            <?= htmlspecialchars($hotel['nombre']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Número de viajeros -->
            <div class="mb-3">
                <label for="num_viajeros" class="form-label">Número de viajeros<span class="text-danger">*</span></label>
                <input type="number" min="1" max="8" class="form-control" name="num_viajeros" id="num_viajeros" value="<?= htmlspecialchars($reserva['num_viajeros']) ?>" required>
            </div>

            <!-- Vehículo -->
            <div class="mb-3 mt-4">
                <label for="id_vehiculo" class="form-label">Vehículo<span class="text-danger">*</span></label>
                <select class="form-select" name="id_vehiculo" id="id_vehiculo" required>
                    <option value="">Seleccione vehículo...</option>
                    <?php foreach ($vehiculos as $vehiculo): ?>
                        <option value="<?= $vehiculo['id_vehiculo'] ?>" <?= ($reserva['id_vehiculo'] == $vehiculo['id_vehiculo'] ? 'selected' : '') ?>>
                            <?= htmlspecialchars($vehiculo['descripcion']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <button type="submit" class="btn btn-primary w-100 mt-3">Guardar cambios</button>
            <a href="/user/misreservas" class="btn btn-secondary w-100 mt-2">Volver</a>
        </form>
    </div>
</div>

<script>
    // Mostrar/ocultar bloques según tipo de reserva (igual que en el alta)
    document.addEventListener('DOMContentLoaded', function() {
        const tipoReserva = document.getElementById('id_tipo_reserva');
        const aeropuertoHotelBlock = document.getElementById('aeropuertoHotelBlock');
        const hotelAeropuertoBlock = document.getElementById('hotelAeropuertoBlock');

        function updateFormFields() {
            aeropuertoHotelBlock.style.display = 'none';
            hotelAeropuertoBlock.style.display = 'none';
            if (tipoReserva.value === "1") {
                aeropuertoHotelBlock.style.display = '';
            } else if (tipoReserva.value === "2") {
                hotelAeropuertoBlock.style.display = '';
            } else if (tipoReserva.value === "3") {
                aeropuertoHotelBlock.style.display = '';
                hotelAeropuertoBlock.style.display = '';
            }
        }

        tipoReserva.addEventListener('change', updateFormFields);
        updateFormFields();
    });
</script>

<?php require __DIR__ . '/../components/footer.php'; ?>