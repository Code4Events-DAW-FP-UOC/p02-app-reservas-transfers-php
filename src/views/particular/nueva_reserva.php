<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Solicitar Transfer</title>
    <link rel="stylesheet" href="/public/css/style.css">
    <style>.form-container { max-width: 700px; margin: 2rem auto; }</style>
</head>
<body>
    <div class="form-container">
        <h1>Solicitar Nuevo Transfer</h1>
        
        <?php if (isset($_SESSION['error_message'])) echo '<p style="color:red">'.$_SESSION['error_message'].'</p>'; unset($_SESSION['error_message']); ?>

        <form action="/reservar/create" method="POST">
            <label>Tipo:</label>
            <select name="id_tipo_reserva" required>
                <option value="1">Aeropuerto -> Hotel</option>
                <option value="2">Hotel -> Aeropuerto</option>
            </select>

            <br><br>
            <label>Fecha (Mínimo 48h antelación):</label>
            <input type="date" name="fecha_vuelo" 
                   min="<?php echo date('Y-m-d', strtotime('+2 days')); ?>" required>

            <label>Hora:</label>
            <input type="time" name="hora_vuelo" required>

            <br><br>
            <label>Hotel:</label>
            <select name="id_hotel" required>
                <?php foreach ($hoteles as $h): ?>
                    <option value="<?php echo $h['id_hotel']; ?>"><?php echo $h['usuario']; ?></option>
                <?php endforeach; ?>
            </select>

            <label>Vehículo:</label>
            <select name="id_vehiculo" required>
                <?php foreach ($vehiculos as $v): ?>
                    <option value="<?php echo $v['id_vehiculo']; ?>"><?php echo $v['Descripción']; ?></option>
                <?php endforeach; ?>
            </select>

            <br><br>
            <label>Viajeros:</label> <input type="number" name="num_viajeros" value="1" min="1" required>
            <label>Nº Vuelo:</label> <input type="text" name="numero_vuelo" required>
            
            <br><br>
            <button type="submit">Solicitar Reserva</button>
        </form>
    </div>
</body>
</html>