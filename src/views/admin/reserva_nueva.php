<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nueva Reserva - Admin</title>
    <link rel="stylesheet" href="/public/css/style.css">
    <style>
        .form-container { max-width: 700px; text-align: left; margin: 2rem auto; }
        .row { display: flex; gap: 1rem; }
        .col { flex: 1; }
        h2 { border-bottom: 2px solid #007bff; padding-bottom: 0.5rem; margin-top: 2rem; font-size: 1.2rem; color: #007bff; }
        .back-link { display: inline-block; margin-bottom: 1rem; color: #666; text-decoration: none; }
    </style>
</head>
<body>

    <div class="form-container">
        <a href="/admin/dashboard" class="back-link">← Volver al Panel</a>
        <h1>Nueva Reserva (Admin)</h1>

        <?php
        if (isset($_SESSION['error_message'])) {
            echo '<p style="color:red; background:#fee; padding:1rem;">' . $_SESSION['error_message'] . '</p>';
            unset($_SESSION['error_message']);
        }
        ?>

        <form action="/admin/reserva/create" method="POST">
            
            <h2>1. Tipo de Trayecto</h2>
            <div class="form-group">
                <label for="tipo_trayecto">Selecciona trayecto:</label>
                <select id="tipo_trayecto" name="id_tipo_reserva" onchange="cambiarFormulario()" required>
                    <option value="1">Aeropuerto -> Hotel (Llegada)</option>
                    <option value="2">Hotel -> Aeropuerto (Salida)</option>
                </select>
            </div>

            <h2>2. Datos del Vuelo</h2>
            <div class="row">
                <div class="col form-group">
                    <label for="fecha">Fecha Vuelo:</label>
                    <input type="date" id="fecha" name="fecha_vuelo" required>
                </div>
                <div class="col form-group">
                    <label for="hora">Hora Vuelo:</label>
                    <input type="time" id="hora" name="hora_vuelo" required>
                </div>
            </div>

            <div class="form-group">
                <label for="num_vuelo">Número de Vuelo:</label>
                <input type="text" id="num_vuelo" name="numero_vuelo" placeholder="Ej: VY1234" required>
            </div>

            <div id="bloque_llegada">
                <div class="form-group">
                    <label for="aeropuerto_origen">Aeropuerto de Origen:</label>
                    <input type="text" id="aeropuerto_origen" name="origen_vuelo">
                </div>
            </div>

            <div id="bloque_salida" style="display: none;">
                <div class="form-group">
                    <label for="hora_recogida">Hora de Recogida en Hotel:</label>
                    <input type="time" id="hora_recogida" name="hora_recogida">
                </div>
            </div>

            <h2>3. Detalles del Transfer</h2>
            <div class="form-group">
                <label for="hotel_id">Hotel:</label>
                <select id="hotel_id" name="id_hotel" required>
                    <option value="">-- Selecciona Hotel --</option>
                    <?php foreach ($hoteles as $hotel): ?>
                        <option value="<?php echo $hotel['id_hotel']; ?>">
                            <?php echo htmlspecialchars($hotel['usuario']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="row">
                <div class="col form-group">
                    <label for="vehiculo_id">Vehículo:</label>
                    <select id="vehiculo_id" name="id_vehiculo" required>
                        <option value="">-- Selecciona --</option>
                        <?php foreach ($vehiculos as $v): ?>
                            <option value="<?php echo $v['id_vehiculo']; ?>">
                                <?php echo htmlspecialchars($v['Descripción']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col form-group">
                    <label for="num_viajeros">Nº Viajeros:</label>
                    <input type="number" id="num_viajeros" name="num_viajeros" min="1" value="1" required>
                </div>
            </div>

            <h2>4. Datos del Cliente</h2>
            <div class="form-group">
                <label for="email_cliente">Email del Cliente:</label>
                <input type="email" id="email_cliente" name="email_cliente" placeholder="cliente@email.com" required>
            </div>

            <button type="submit" style="margin-top: 1rem;">Confirmar Reserva</button>
        </form>
    </div>

    <script>
        function cambiarFormulario() {
            const tipo = document.getElementById('tipo_trayecto').value;
            const bloqueLlegada = document.getElementById('bloque_llegada');
            const bloqueSalida = document.getElementById('bloque_salida');

            if (tipo === '1') {
                bloqueLlegada.style.display = 'block';
                bloqueSalida.style.display = 'none';
            } else {
                bloqueLlegada.style.display = 'none';
                bloqueSalida.style.display = 'block';
            }
        }
    </script>
</body>
</html>