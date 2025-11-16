<?php require __DIR__ . '/../components/header.php'; ?>
<?php require __DIR__ . '/../components/navbar.php'; ?>

<div class="container mt-5" style="max-width: 900px;">
    <div class="card shadow p-4">
        <h2 class="mb-4 text-center">Editar reserva</h2>
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <?php if (!empty($success)): ?>
            <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>

        <form method="post" action="">
            <input type="hidden" name="id_reserva" value="<?= htmlspecialchars($reserva['id_reserva']) ?>">

            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="id_hotel" class="form-label">Hotel</label>
                    <select name="id_hotel" id="id_hotel" class="form-select" required>
                        <option value="">Selecciona hotel</option>
                        <?php foreach ($hoteles as $hotel): ?>
                            <option value="<?= $hotel['id_hotel'] ?>" <?= ($reserva['id_hotel'] == $hotel['id_hotel'] ? 'selected' : '') ?>>
                                <?= htmlspecialchars($hotel['nombre']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="id_tipo_reserva" class="form-label">Tipo de reserva</label>
                    <select name="id_tipo_reserva" id="id_tipo_reserva" class="form-select" required>
                        <option value="">Selecciona tipo</option>
                        <?php foreach ($tiposReserva as $tipo): ?>
                            <option value="<?= $tipo['id_tipo_reserva'] ?>" <?= ($reserva['id_tipo_reserva'] == $tipo['id_tipo_reserva'] ? 'selected' : '') ?>>
                                <?= htmlspecialchars($tipo['descripcion']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="id_viajero" class="form-label">Viajero</label>
                    <select name="id_viajero" id="id_viajero" class="form-select" required>
                        <option value="">Selecciona viajero</option>
                        <?php foreach ($viajeros as $viajero): ?>
                            <option value="<?= $viajero['id_viajero'] ?>" <?= ($reserva['id_viajero'] == $viajero['id_viajero'] ? 'selected' : '') ?>>
                                <?= htmlspecialchars($viajero['nombre'] . ' ' . $viajero['apellido1']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="fecha_entrada" class="form-label">Fecha entrada</label>
                    <input type="date" name="fecha_entrada" id="fecha_entrada" class="form-control" value="<?= htmlspecialchars($reserva['fecha_entrada']) ?>" required>
                </div>
                <div class="col-md-6">
                    <label for="hora_entrada" class="form-label">Hora entrada</label>
                    <input type="time" name="hora_entrada" id="hora_entrada" class="form-control" value="<?= htmlspecialchars($reserva['hora_entrada']) ?>" required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="numero_vuelo_entrada" class="form-label">Nº vuelo entrada</label>
                    <input type="text" name="numero_vuelo_entrada" id="numero_vuelo_entrada" class="form-control" value="<?= htmlspecialchars($reserva['numero_vuelo_entrada']) ?>">
                </div>
                <div class="col-md-4">
                    <label for="origen_vuelo_entrada" class="form-label">Origen vuelo</label>
                    <input type="text" name="origen_vuelo_entrada" id="origen_vuelo_entrada" class="form-control" value="<?= htmlspecialchars($reserva['origen_vuelo_entrada']) ?>">
                </div>
                <div class="col-md-4">
                    <label for="id_destino" class="form-label">Destino</label>
                    <select name="id_destino" id="id_destino" class="form-select" required>
                        <option value="">Selecciona destino</option>
                        <?php foreach ($hoteles as $hotel): ?>
                            <option value="<?= $hotel['id_hotel'] ?>" <?= ($reserva['id_destino'] == $hotel['id_hotel'] ? 'selected' : '') ?>>
                                <?= htmlspecialchars($hotel['nombre']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="hora_vuelo_salida" class="form-label">Hora salida</label>
                    <input type="time" name="hora_vuelo_salida" id="hora_vuelo_salida" class="form-control" value="<?= htmlspecialchars($reserva['hora_vuelo_salida']) ?>">
                </div>
                <div class="col-md-4">
                    <label for="fecha_vuelo_salida" class="form-label">Fecha salida</label>
                    <input type="date" name="fecha_vuelo_salida" id="fecha_vuelo_salida" class="form-control" value="<?= htmlspecialchars($reserva['fecha_vuelo_salida']) ?>">
                </div>
                <div class="col-md-4">
                    <label for="num_viajeros" class="form-label">Nº viajeros</label>
                    <input type="number" name="num_viajeros" id="num_viajeros" class="form-control" min="1" value="<?= htmlspecialchars($reserva['num_viajeros']) ?>">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="id_vehiculo" class="form-label">Vehículo</label>
                    <select name="id_vehiculo" id="id_vehiculo" class="form-select" required>
                        <option value="">Selecciona vehículo</option>
                        <?php foreach ($vehiculos as $vehiculo): ?>
                            <option value="<?= $vehiculo['id_vehiculo'] ?>" <?= ($reserva['id_vehiculo'] == $vehiculo['id_vehiculo'] ? 'selected' : '') ?>>
                                <?= htmlspecialchars($vehiculo['descripcion']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="text-center mt-4">
                <button type="submit" class="btn btn-primary px-5">Guardar cambios</button>
                <a href="/userAdmin/listadoReservas" class="btn btn-secondary ms-3">Cancelar</a>
            </div>
        </form>
    </div>
</div>
<?php require __DIR__ . '/../components/footer.php'; ?>