<?php require __DIR__ . '/../components/header.php'; ?>
<?php require __DIR__ . '/../components/navbar.php'; ?>

<div class="container mt-4">
    <h2>Mis reservas</h2>
    <table class="table table-striped table-hover mt-3">
        <thead>
            <tr>
                <th>Localizador</th>
                <th>Reservo Hotel</th>
                <th>Fecha</th>
                <th>Hotel destino</th>
                <th>Tipo de reserva</th>
                <th>Detalles</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($reservas)): ?>
                <tr>
                    <td colspan="6" class="text-center">No tienes reservas registradas.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($reservas as $reserva): ?>
                    <tr>
                        <td><?= htmlspecialchars($reserva['localizador']) ?></td>
                        <td><?= htmlspecialchars($reserva['hotel_nombre'] ?? '—') ?></td>
                        <td><?= htmlspecialchars($reserva['fecha_reserva']) ?></td>
                        <td><?= htmlspecialchars($reserva['destino_hotel'] ?? '—') ?></td>
                        <td><?= htmlspecialchars($reserva['tipo_reserva_nombre'] ?? '—') ?></td>
                        <td>
                            <a href="/user/verDetallesReserva/<?= $reserva['id_reserva'] ?>" class="btn btn-sm btn-outline-primary me-1">
                                Ver detalles
                            </a>
                            <?php
                            // Solo permitir editar/borrar si la reserva es futura (> 48 horas)
                            $fechaReserva = new DateTime($reserva['fecha_entrada'] ?? $reserva['fecha_reserva']);
                            $ahora = new DateTime();
                            $diferenciaHoras = ($fechaReserva->getTimestamp() - $ahora->getTimestamp()) / 3600;
                            if ($diferenciaHoras > 48):
                            ?>
                                <a href="/user/editarReserva/<?= $reserva['id_reserva'] ?>" class="btn btn-sm btn-primary me-1" title="Editar">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <a href="/user/eliminarReserva/<?= $reserva['id_reserva'] ?>" class="btn btn-sm btn-outline-danger" title="Eliminar" onclick="return confirm('¿Seguro que quieres eliminar la reserva?');">
                                    <i class="bi bi-trash"></i>
                                </a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

</div>
<?php require __DIR__ . '/../components/footer.php'; ?>