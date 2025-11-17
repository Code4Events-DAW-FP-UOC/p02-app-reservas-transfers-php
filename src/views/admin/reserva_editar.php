<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Reserva - Admin</title>
    <link rel="stylesheet" href="/public/css/style.css">
    <style> .form-container { max-width: 800px; margin: 2rem auto; } </style>
</head>
<body>

    <div class="form-container">
        <a href="/admin/reservas" style="color:#666; text-decoration:none;">← Cancelar y Volver</a>
        <h1>Editar Reserva: <?php echo $reserva['localizador']; ?></h1>

        <?php if (isset($_SESSION['error_message'])) echo '<p style="color:red">'.$_SESSION['error_message'].'</p>'; unset($_SESSION['error_message']); ?>

        <form action="/admin/reserva/update" method="POST">
            <input type="hidden" name="id_reserva" value="<?php echo $reserva['id_reserva']; ?>">
            
            <div class="form-group">
                <label>Tipo de Trayecto:</label>
                <select id="tipo_trayecto" name="id_tipo_reserva" onchange="cambiarFormulario()" required>
                    <option value="1" <?php echo ($reserva['id_tipo_reserva'] == 1) ? 'selected' : ''; ?>>Aeropuerto -> Hotel</option>
                    <option value="2" <?php echo ($reserva['id_tipo_reserva'] == 2) ? 'selected' : ''; ?>>Hotel -> Aeropuerto</option>
                </select>
            </div>

            <?php 
                // Recuperem les dades correctes segons el tipus que tenia guardat
                $fechaVuelo = ($reserva['id_tipo_reserva'] == 1) ? $reserva['fecha_entrada'] : $reserva['fecha_vuelo_salida'];
                
                // L'hora ve com "YYYY-MM-DD HH:MM:SS", volem només "HH:MM"
                $horaCompleta = ($reserva['id_tipo_reserva'] == 1) ? $reserva['hora_entrada'] : $reserva['hora_vuelo_salida'];
                $horaVuelo = substr($horaCompleta, 11, 5); 
            ?>

            <div style="display:flex; gap:1rem;">
                <div style="flex:1" class="form-group">
                    <label>Fecha Vuelo:</label>
                    <input type="date" name="fecha_vuelo" value="<?php echo $fechaVuelo; ?>" required>
                </div>
                <div style="flex:1" class="form-group">
                    <label>Hora Vuelo:</label>
                    <input type="time" name="hora_vuelo" value="<?php echo $horaVuelo; ?>" required>
                </div>
            </div>

            <div class="form-group">
                <label>Número de Vuelo:</label>
                <input type="text" name="numero_vuelo" value="<?php echo htmlspecialchars($reserva['numero_vuelo_entrada']); ?>" required>
            </div>

            <div id="bloque_llegada">
                <div class="form-group">
                    <label>Aeropuerto de Origen:</label>
                    <input type="text" name="origen_vuelo" value="<?php echo htmlspecialchars($reserva['origen_vuelo_entrada']); ?>">
                </div>
            </div>

            <div id="bloque_salida" style="display: none;">
                <div class="form-group">
                    <label>Hora Recogida Hotel:</label>
                    <input type="time" name="hora_recogida" value="<?php echo $horaVuelo; ?>">
                </div>
            </div>

            <div class="form-group">
                <label>Hotel:</label>
                <select name="id_hotel" required>
                    <?php foreach ($hoteles as $hotel): ?>
                        <option value="<?php echo $hotel['id_hotel']; ?>" <?php echo ($hotel['id_hotel'] == $reserva['id_destino']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($hotel['usuario']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div style="display:flex; gap:1rem;">
                <div style="flex:1" class="form-group">
                    <label>Vehículo:</label>
                    <select name="id_vehiculo" required>
                        <?php foreach ($vehiculos as $v): ?>
                            <option value="<?php echo $v['id_vehiculo']; ?>" <?php echo ($v['id_vehiculo'] == $reserva['id_vehiculo']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($v['Descripción']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div style="flex:1" class="form-group">
                    <label>Viajeros:</label>
                    <input type="number" name="num_viajeros" min="1" value="<?php echo $reserva['num_viajeros']; ?>" required>
                </div>
            </div>

            <button type="submit" style="background:#ffc107; color:black; width:100%; margin-top:1rem; font-weight:bold; padding:1rem; border:none; cursor:pointer;">Guardar Cambios</button>
        </form>
    </div>

    <script>
        function cambiarFormulario() {
            const tipo = document.getElementById('tipo_trayecto').value;
            const bl = document.getElementById('bloque_llegada');
            const bs = document.getElementById('bloque_salida');
            if (tipo === '1') { bl.style.display = 'block'; bs.style.display = 'none'; } 
            else { bl.style.display = 'none'; bs.style.display = 'block'; }
        }
        // Executar a l'inici per mostrar el bloc correcte segons les dades carregades
        cambiarFormulario();
    </script>

</body>
</html>