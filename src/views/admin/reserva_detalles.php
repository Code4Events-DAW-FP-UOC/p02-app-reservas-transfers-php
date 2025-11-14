<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reserva Confirmada - Isla Transfers</title>
    <link rel="stylesheet" href="/public/css/style.css">
    <style>
        .ticket-container { max-width: 600px; margin: 3rem auto; background: white; padding: 2rem; border-radius: 10px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); border-top: 5px solid #28a745; }
        .success-icon { font-size: 3rem; color: #28a745; text-align: center; margin-bottom: 1rem; }
        .ticket-header { text-align: center; border-bottom: 2px dashed #eee; padding-bottom: 1.5rem; margin-bottom: 1.5rem; }
        .localizador { font-size: 1.5rem; font-weight: bold; letter-spacing: 2px; background: #f8f9fa; padding: 0.5rem 1rem; border-radius: 5px; border: 1px solid #ddd; display: inline-block; margin-top: 0.5rem; color: #333; }
        .detail-row { display: flex; justify-content: space-between; padding: 0.8rem 0; border-bottom: 1px solid #f1f1f1; }
        .detail-label { color: #666; font-weight: 500; }
        .detail-value { font-weight: bold; color: #333; }
        .actions { margin-top: 2rem; text-align: center; }
        .btn-back { background-color: #6c757d; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; }
        .btn-print { background-color: #007bff; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; margin-left: 10px; cursor: pointer; border: none; }
    </style>
</head>
<body>

    <div class="ticket-container">
        <div class="success-icon">✅</div>
        <div class="ticket-header">
            <h1>¡Reserva Confirmada!</h1>
            <p>La reserva se ha guardado correctamente en el sistema.</p>
            <div class="localizador"><?php echo htmlspecialchars($reserva['localizador']); ?></div>
        </div>

        <div class="detail-row">
            <span class="detail-label">Cliente:</span>
            <span class="detail-value"><?php echo htmlspecialchars($reserva['email_cliente']); ?></span>
        </div>

        <div class="detail-row">
            <span class="detail-label">Trayecto:</span>
            <span class="detail-value">
                <?php echo ($reserva['id_tipo_reserva'] == 1) ? 'Aeropuerto ➝ Hotel' : 'Hotel ➝ Aeropuerto'; ?>
            </span>
        </div>

        <div class="detail-row">
            <span class="detail-label">Hotel:</span>
            <span class="detail-value"><?php echo htmlspecialchars($reserva['nombre_hotel']); ?></span>
        </div>

        <div class="detail-row">
            <span class="detail-label">Vehículo:</span>
            <span class="detail-value"><?php echo htmlspecialchars($reserva['nombre_vehiculo']); ?></span>
        </div>

        <div class="detail-row">
            <span class="detail-label">Viajeros:</span>
            <span class="detail-value"><?php echo htmlspecialchars($reserva['num_viajeros']); ?> pax</span>
        </div>

        <div class="detail-row">
            <span class="detail-label">Fecha Vuelo:</span>
            <span class="detail-value">
                <?php 
                    // Si és tipus 1 (Arribada), mirem fecha_entrada, si no fecha_vuelo_salida
                    echo ($reserva['id_tipo_reserva'] == 1) 
                        ? htmlspecialchars($reserva['fecha_entrada'] . ' ' . $reserva['hora_entrada']) 
                        : htmlspecialchars($reserva['fecha_vuelo_salida'] . ' ' . $reserva['hora_vuelo_salida']);
                ?>
            </span>
        </div>

        <div class="detail-row">
            <span class="detail-label">Nº Vuelo:</span>
            <span class="detail-value"><?php echo htmlspecialchars($reserva['numero_vuelo_entrada']); ?></span>
        </div>

        <div class="actions">
            <a href="/admin/dashboard" class="btn-back">Volver al Panel</a>
            <button onclick="window.print()" class="btn-print">🖨️ Imprimir</button>
        </div>
    </div>

</body>
</html>