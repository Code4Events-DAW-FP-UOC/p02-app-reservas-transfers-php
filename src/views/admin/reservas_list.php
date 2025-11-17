<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado Reservas - Admin</title>
    <link rel="stylesheet" href="/public/css/style.css">
    <style>
        .list-container { max-width: 1200px; margin: 2rem auto; padding: 1rem; background: white; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
        .top-bar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; }
        .btn-new { background: #28a745; color: white; padding: 10px 15px; text-decoration: none; border-radius: 5px; font-weight: bold; }
        
        /* Estils de la Taula */
        table { width: 100%; border-collapse: collapse; margin-top: 1rem; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background-color: #007bff; color: white; }
        tr:hover { background-color: #f1f1f1; }
        
        /* Badges per l'estat o tipus */
        .badge-ida { background: #17a2b8; color: white; padding: 3px 8px; border-radius: 10px; font-size: 0.8rem; }
        .badge-vuelta { background: #ffc107; color: #333; padding: 3px 8px; border-radius: 10px; font-size: 0.8rem; }
        
        .actions a { margin-right: 5px; text-decoration: none; font-size: 1.2rem; }
    </style>
</head>
<body>

    <div class="list-container">
        <div class="top-bar">
            <h1>Gestión de Reservas</h1>
            <div>
                <a href="/admin/dashboard" class="btn-back" style="margin-right: 10px; color: #666;">Volver</a>
                <a href="/admin/reserva/nueva" class="btn-new">➕ Nueva Reserva</a>
            </div>
        </div>

        <?php if (empty($reservas)): ?>
            <p style="text-align: center; color: #666;">No hay reservas registradas todavía.</p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>LOC</th>
                        <th>Fecha Viaje</th>
                        <th>Tipo</th>
                        <th>Cliente</th>
                        <th>Hotel</th>
                        <th>Vehículo</th>
                        <th>Vuelo</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($reservas as $r): ?>
                        <tr>
                            <td><strong><?php echo htmlspecialchars($r['localizador']); ?></strong></td>
                            
                            <td>
                                <?php 
                                    if ($r['id_tipo_reserva'] == 1) {
                                        // Arribada: mostrem data entrada + hora entrada
                                        echo date('d/m/Y', strtotime($r['fecha_entrada'])) . '<br>' . substr($r['hora_entrada'], 11, 5);
                                    } else {
                                        // Sortida: mostrem data sortida + hora sortida (o recollida)
                                        echo date('d/m/Y', strtotime($r['fecha_vuelo_salida'])) . '<br>' . substr($r['hora_vuelo_salida'], 11, 5);
                                    }
                                ?>
                            </td>

                            <td>
                                <?php if ($r['id_tipo_reserva'] == 1): ?>
                                    <span class="badge-ida">Llegada 🛬</span>
                                <?php else: ?>
                                    <span class="badge-vuelta">Salida 🛫</span>
                                <?php endif; ?>
                            </td>

                            <td>
                                <?php echo htmlspecialchars($r['nombre_cliente'] . ' ' . $r['apellido_cliente']); ?><br>
                                <small style="color:#666"><?php echo htmlspecialchars($r['email_cliente_real']); ?></small>
                            </td>

                            <td><?php echo htmlspecialchars($r['nombre_hotel']); ?></td>
                            <td><?php echo htmlspecialchars($r['nombre_vehiculo']); ?></td>
                            <td><?php echo htmlspecialchars($r['numero_vuelo_entrada']); ?></td>

                            <td class="actions">
                                <a href="/admin/reserva/detalles?loc=<?php echo $r['localizador']; ?>" title="Ver Detalle">👁️</a>
                                <a href="#" title="Editar" onclick="alert('Próximamente')">✏️</a>
                                <a href="#" title="Eliminar" onclick="alert('Próximamente')" style="color:red;">🗑️</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>

</body>
</html>