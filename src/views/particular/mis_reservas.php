<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis Reservas</title>
    <link rel="stylesheet" href="/public/css/style.css">
    <style>
        .container { max-width: 1000px; margin: 2rem auto; padding: 2rem; background: white; border-radius: 8px; }
        table { width: 100%; border-collapse: collapse; margin-top: 1rem; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background-color: #28a745; color: white; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Mis Reservas</h1>
        <a href="/particular/dashboard">← Volver</a>

        <?php if (isset($_SESSION['success_message'])) echo '<p style="color:green">'.$_SESSION['success_message'].'</p>'; unset($_SESSION['success_message']); ?>

        <?php if (empty($reservas)): ?>
            <p>No tienes reservas.</p>
            <a href="/reservar">¡Haz tu primera reserva!</a>
        <?php else: ?>
            <table>
                <thead><tr><th>Localizador</th><th>Fecha Viaje</th><th>Trayecto</th><th>Hotel</th><th>Vehículo</th></tr></thead>
                <tbody>
                    <?php foreach ($reservas as $r): ?>
                        <tr>
                            <td><strong><?php echo $r['localizador']; ?></strong></td>
                            <td><?php echo ($r['id_tipo_reserva'] == 1) ? $r['fecha_entrada'] : $r['fecha_vuelo_salida']; ?></td>
                            <td><?php echo ($r['id_tipo_reserva'] == 1) ? 'Aeropuerto ➝ Hotel' : 'Hotel ➝ Aeropuerto'; ?></td>
                            <td><?php echo htmlspecialchars($r['nombre_hotel']); ?></td>
                            <td><?php echo htmlspecialchars($r['nombre_vehiculo']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>