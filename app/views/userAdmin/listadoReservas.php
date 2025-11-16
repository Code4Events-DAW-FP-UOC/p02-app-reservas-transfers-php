<?php require __DIR__ . '/../components/header.php'; ?>
<?php require __DIR__ . '/../components/navbar.php'; ?>

<div class="d-flex" style="min-height: 100vh;">
    <?php require __DIR__ . '/../components/sidebar.php'; ?>
    <main class="flex-grow-1 p-5">
        <h2 class="mb-4">Listado de reservas</h2>
        <table class="table table-striped table-hover align-middle">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Localizador</th>
                    <th>Hotel</th>
                    <th>Tipo</th>
                    <th>Viajero</th>
                    <th>Fecha reserva</th>
                    <th>Fecha modif.</th>
                    <th>Destino</th>
                    <th>Fecha entrada</th>
                    <th>Hora entrada</th>
                    <th>Núm. vuelo entrada</th>
                    <th>Origen vuelo</th>
                    <th>Hora salida</th>
                    <th>Fecha salida</th>
                    <th>Nº viajeros</th>
                    <th>Vehículo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($reservas)): ?>
                    <tr>
                        <td colspan="17" class="text-center text-muted">No hay reservas registradas.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($reservas as $reserva): ?>
                        <tr>
                            <td><?= htmlspecialchars($reserva['id_reserva']) ?></td>
                            <td><?= htmlspecialchars($reserva['localizador']) ?></td>
                            <td><?= htmlspecialchars($reserva['hotel_nombre'] ?? '-') ?></td>
                            <td><?= htmlspecialchars($reserva['tipo_reserva']) ?></td>
                            <td><?= htmlspecialchars($reserva['viajero_nombre'] . ' ' . $reserva['viajero_apellido1']) ?></td>
                            <td><?= htmlspecialchars($reserva['fecha_reserva']) ?></td>
                            <td><?= htmlspecialchars($reserva['fecha_modificacion']) ?></td>
                            <td><?= htmlspecialchars($reserva['destino_nombre']) ?></td>
                            <td><?= htmlspecialchars($reserva['fecha_entrada'] ?? '-') ?></td>
                            <td><?= htmlspecialchars($reserva['hora_entrada'] ?? '-') ?></td>
                            <td><?= htmlspecialchars($reserva['numero_vuelo_entrada']) ?></td>
                            <td><?= htmlspecialchars($reserva['origen_vuelo_entrada']) ?></td>
                            <td><?= htmlspecialchars($reserva['hora_vuelo_salida'] ?? '-') ?></td>
                            <td><?= htmlspecialchars($reserva['fecha_vuelo_salida'] ?? '-') ?></td>
                            <td><?= htmlspecialchars($reserva['num_viajeros']) ?></td>
                            <td><?= htmlspecialchars($reserva['vehiculo_descripcion']) ?></td>
                            <td>
                                <a href="/userAdmin/editarReserva/<?= $reserva['id_reserva'] ?>" class="btn btn-sm btn-primary me-2" title="Editar">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <a href="/userAdmin/eliminarReserva/<?= $reserva['id_reserva'] ?>"
                                    class="btn btn-outline-danger btn-sm ms-2"
                                    onclick="return confirm('¿Seguro que quieres borrar esta reserva?');"
                                    title="Borrar">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach ?>
                <?php endif ?>
            </tbody>
        </table>
</div>
</div>
</main>
</div>

<?php require __DIR__ . '/../components/footer.php'; ?>