<?php
$hoy = date('Y-m-d');
require __DIR__ . '/../components/header.php';
require __DIR__ . '/../components/navbar.php';
?>

<div class="container mt-4" style="max-width: 900px;">
    <div class="card shadow p-4">
        <h2 class="mb-4">Crear nueva reserva</h2>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <?php if (!empty($success)): ?>
            <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>


        <form method="post" id="formReserva">

            <!-- Tipo de reserva -->
            <div class="mb-3">
                <label for="id_tipo_reserva" class="form-label">
                    Tipo de reserva <span class="text-danger">*</span>
                </label>
                <select name="id_tipo_reserva" id="id_tipo_reserva" class="form-select" required>
                    <option value="">Seleccione...</option>
                    <?php foreach ($tiposReserva as $t): ?>
                        <option value="<?= $t['id_tipo_reserva'] ?>">
                            <?= htmlspecialchars($t['descripcion']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- BLOQUE AEROPUERTO → HOTEL -->
            <div id="aeropuertoHotelBlock" style="display:none;">
                <h5>Datos de llegada (Aeropuerto → Hotel)</h5>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label>Día de llegada</label>
                        <input type="date" class="form-control"
                            name="fecha_entrada" id="fecha_entrada"
                            min="<?= $hoy ?>">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Hora de llegada</label>
                        <input type="time" class="form-control" name="hora_entrada" id="hora_entrada">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Número de vuelo</label>
                        <input type="text" class="form-control" name="numero_vuelo_entrada" id="numero_vuelo_entrada">
                    </div>
                </div>

                <div class="mb-3">
                    <label>Aeropuerto de origen</label>
                    <input type="text" class="form-control" name="origen_vuelo_entrada" id="origen_vuelo_entrada">
                </div>
            </div>

            <!-- BLOQUE HOTEL → AEROPUERTO -->
            <div id="hotelAeropuertoBlock" style="display:none;">
                <h5>Datos de salida (Hotel → Aeropuerto)</h5>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label>Día del vuelo</label>
                        <input type="date" class="form-control"
                            name="fecha_vuelo_salida" id="fecha_vuelo_salida"
                            min="<?= $hoy ?>">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Hora del vuelo</label>
                        <input type="time" class="form-control" name="hora_vuelo_salida" id="hora_vuelo_salida">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Número de vuelo</label>
                        <input type="text" class="form-control" name="numero_vuelo_salida" id="numero_vuelo_salida">
                    </div>
                </div>

                <div class="mb-3">
                    <label>Hora de recogida</label>
                    <input type="time" class="form-control" name="hora_entrada_salida" id="hora_entrada_salida">
                </div>
            </div>

            <!-- Hotel destino / recogida -->
            <div class="mb-3">
                <label for="id_hotel" class="form-label">Hotel destino/recogida*</label>
                <select name="id_hotel" id="id_hotel" class="form-select" required>
                    <option value="">Seleccione hotel...</option>
                    <?php foreach ($hoteles as $h): ?>
                        <option value="<?= $h['id_hotel'] ?>"><?= htmlspecialchars($h['nombre']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Número de viajeros -->
            <div class="mb-3">
                <label>Número de viajeros</label>
                <input type="number" class="form-control" name="num_viajeros" id="num_viajeros"
                    min="1" max="50" value="1" required>
            </div>

            <!-- Viajero -->
            <div class="mb-3">
                <label>Viajero existente o nuevo</label>
                <select class="form-select" name="id_viajero" id="id_viajero">
                    <option value="">Nuevo viajero</option>
                    <?php foreach ($viajeros as $v): ?>
                        <option value="<?= $v['id_viajero'] ?>">
                            <?= htmlspecialchars($v['email']) ?>
                            (<?= htmlspecialchars($v['nombre'] . " " . $v['apellido1']) ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Datos del viajero NUEVO -->
            <div id="datosViajeroBlock" class="border p-3 rounded" style="display:block;">

                <h5 class="mt-2">Datos del nuevo viajero</h5>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label>Nombre*</label>
                        <input type="text" class="form-control" name="nombre">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Primer apellido*</label>
                        <input type="text" class="form-control" name="apellido1">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Segundo apellido</label>
                        <input type="text" class="form-control" name="apellido2">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Dirección</label>
                        <input type="text" class="form-control" name="direccion">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label>Código postal</label>
                        <input type="text" class="form-control" name="codigoPostal">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label>Ciudad</label>
                        <input type="text" class="form-control" name="ciudad">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>País</label>
                        <input type="text" class="form-control" name="pais">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Correo electrónico*</label>
                        <input type="email" class="form-control" name="email">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Contraseña*</label>
                        <input type="password" class="form-control" name="password">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Confirmar contraseña*</label>
                        <input type="password" class="form-control" name="confirm">
                    </div>
                </div>
            </div>

            <!-- Vehículo -->
            <div class="mb-3">
                <label>Vehículo*</label>
                <select name="id_vehiculo" class="form-select" required>
                    <option value="">Seleccione vehículo...</option>
                    <?php foreach ($vehiculos as $v): ?>
                        <option value="<?= $v['id_vehiculo'] ?>"><?= htmlspecialchars($v['descripcion']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <button class="btn btn-primary w-100 mt-3">Crear reserva</button>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tipoReserva = document.getElementById('id_tipo_reserva');
        const blockIda = document.getElementById('aeropuertoHotelBlock');
        const blockVuelta = document.getElementById('hotelAeropuertoBlock');
        const idViajero = document.getElementById('id_viajero');
        const blockNuevoViajero = document.getElementById('datosViajeroBlock');

        function updateBlocks() {
            blockIda.style.display = "none";
            blockVuelta.style.display = "none";

            if (tipoReserva.value === "1") blockIda.style.display = "";
            if (tipoReserva.value === "2") blockVuelta.style.display = "";
            if (tipoReserva.value === "3") {
                blockIda.style.display = "";
                blockVuelta.style.display = "";
            }
        }

        tipoReserva.addEventListener('change', updateBlocks);
        updateBlocks();

        idViajero.addEventListener('change', () => {
            blockNuevoViajero.style.display = idViajero.value ? "none" : "block";
        });
        // Al recargar la página, si hay seleccionado un viajero existente, oculta el bloque de nuevo viajero
        if (idViajero.value) {
            blockNuevoViajero.style.display = "none";
        }
    });
</script>

<?php require __DIR__ . '/../components/footer.php'; ?>