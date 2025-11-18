<?php require __DIR__ . '/../components/header.php'; ?>
<?php require __DIR__ . '/../components/navbar.php'; ?>

<div class="container mt-4">
    <h2>Mis reservas</h2>
    <table class="table table-striped table-hover mt-3">
        <thead>
            <tr>
                <th>Localizador</th>
                <th>Fecha</th>
                <th>Hotel</th>
                <th>Destino</th>
                <th>Tipo de reserva</th>
                <th>Creada por</th>
                <th>Detalles</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($reservas)): ?>
                <tr>
                    <td colspan="7" class="text-center">No tienes reservas registradas.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($reservas as $reserva): ?>
                    <tr>
                        <td><?= htmlspecialchars($reserva['localizador']) ?></td>
                        <td><?= htmlspecialchars($reserva['fecha_reserva']) ?></td>
                        <td><?= htmlspecialchars($reserva['hotel_nombre'] ?? '—') ?></td>
                        <td><?= htmlspecialchars($reserva['destino_hotel'] ?? '—') ?></td>
                        <td><?= htmlspecialchars($reserva['tipo_reserva_nombre'] ?? '—') ?></td>
                        <td>
                            <?php
                            if (empty($reserva['creador_nombre'])) {
                                echo "—";
                            } elseif ($reserva['id_creador'] == $_SESSION['user_id']) {
                                echo "Tú";
                            } elseif (/*!empty($reserva['creador_rol']) && */$reserva['creador_rol'] == 'admin') {
                                echo "Administrador";
                            } else {
                                echo htmlspecialchars($reserva['creador_nombre'] . ' ' . $reserva['creador_apellido1']);
                            }
                            ?>
                        </td>
                        <td>
                            <a href="/user/verReserva/<?= $reserva['id_reserva'] ?>" class="btn btn-sm btn-outline-primary">
                                Ver detalles
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

</div>
<?php require __DIR__ . '/../components/footer.php'; ?>