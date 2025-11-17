<?php require __DIR__ . '/../components/header.php'; ?>
<?php require __DIR__ . '/../components/navbar.php'; ?>

<div class="d-flex" style="min-height: 100vh;">
    <?php require __DIR__ . '/../components/sidebar.php'; ?>
    <main class="flex-grow-1 p-5">
        <?php
        $fechaMostrada = isset($fecha) ? $fecha : date('Y-m-d');
        ?>
        <div class="container mt-4">
            <h2 class="mb-4">Calendario de reservas - Reservas del día <?= date('d/m/Y', strtotime($fechaMostrada)) ?></h2>
            <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap">
                <form method="get" class="d-flex align-items-center gap-2">
                    <input type="date" name="fecha" value="<?= $fechaMostrada ?>" class="form-control">
                    <button class="btn btn-outline-primary">Ir</button>
                </form>
                <div class="btn-group">
                    <a href="/userAdmin/calendario" class="btn btn-outline-primary">Mes</a>
                    <a href="/userAdmin/calendarioSemana?fecha=<?= $fechaMostrada ?>" class="btn btn-outline-primary">Semana</a>
                    <a href="/userAdmin/calendarioDia?fecha=<?= $fechaMostrada ?>" class="btn btn-outline-primary active">Día</a>
                </div>
                <div class="d-flex gap-3 align-items-center">
                    <span><span class="badge bg-success">&nbsp;</span> Aeropuerto→Hotel</span>
                    <span><span class="badge bg-warning text-dark">&nbsp;</span> Hotel→Aeropuerto</span>
                    <span><span class="badge bg-primary">&nbsp;</span> Ida y vuelta</span>
                </div>
            </div>
            <table class="table table-bordered align-middle">
                <thead>
                    <tr>
                        <th>Hora</th>
                        <th>Tipo</th>
                        <th>Viajero</th>
                        <th>Reservo Hotel</th>
                        <th>Destino</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($reservas)): ?>
                        <tr>
                            <td colspan="6" class="text-center">No hay reservas para este día.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($reservas as $r):
                            $color = match ((int)$r['id_tipo_reserva']) {
                                1 => 'success',
                                2 => 'warning text-dark',
                                3 => 'primary',
                                default => 'secondary'
                            };
                            $nombre = htmlspecialchars($r['nombre_viajero'] ?? $r['nombre_hotel'] ?? '-');
                            $hora = htmlspecialchars(substr($r['hora_entrada'] ?? $r['hora_vuelo_salida'] ?? '', 0, 5));
                        ?>
                            <tr>
                                <td><span class="badge bg-<?= $color ?>"><?= $hora ?></span></td>
                                <td><?= htmlspecialchars($r['descripcion_tipo'] ?? '-') ?></td>
                                <td><?= $nombre ?></td>
                                <td><?= htmlspecialchars($r['nombre_hotel'] ?? '-') ?></td>
                                <td><?= htmlspecialchars($r['destino_hotel'] ?? '-') ?></td>
                                <td>
                                    <a href="/userAdmin/verReserva/<?= $r['id_reserva'] ?>" class="btn btn-sm btn-info">Detalles</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
    </main>
</div>

<?php require __DIR__ . '/../components/footer.php'; ?>