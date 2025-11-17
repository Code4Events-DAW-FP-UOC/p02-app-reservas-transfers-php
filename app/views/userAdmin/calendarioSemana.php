<?php require __DIR__ . '/../components/header.php'; ?>
<?php require __DIR__ . '/../components/navbar.php'; ?>

<div class="d-flex" style="min-height: 100vh;">
    <?php require __DIR__ . '/../components/sidebar.php'; ?>
    <main class="flex-grow-1 p-5">
        <?php
        $nombresSemana = ['Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb', 'Dom'];
        $dias = [];
        $inicio = strtotime($fechaInicio);
        for ($i = 0; $i < 7; $i++) {
            $dias[] = date('Y-m-d', strtotime("+$i day", $inicio));
        }
        $reservasPorDia = [];
        foreach ($reservas as $r) {
            $fecha = null;
            if (!empty($r['fecha_entrada']) && in_array($r['fecha_entrada'], $dias)) {
                $fecha = $r['fecha_entrada'];
            } elseif (!empty($r['fecha_vuelo_salida']) && in_array($r['fecha_vuelo_salida'], $dias)) {
                $fecha = $r['fecha_vuelo_salida'];
            }
            if ($fecha) $reservasPorDia[$fecha][] = $r;
        }
        function fechaFormateada($f)
        {
            return date('j', strtotime($f));
        }
        setlocale(LC_TIME, 'es_ES.UTF-8');
        ?>
        <div class="container mt-4">
            <h2 class="mb-4">Calendario de reservas - Semana del <?= date('d/m', strtotime($fechaInicio)) ?> al <?= date('d/m/Y', strtotime($fechaFin)) ?></h2>
            <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap">
                <form method="get" class="d-flex align-items-center gap-2">
                    <input type="date" name="fecha" value="<?= $fechaInicio ?>" class="form-control">
                    <button class="btn btn-outline-primary">Ir</button>
                </form>
                <div class="btn-group">
                    <a href="/userAdmin/calendario" class="btn btn-outline-primary">Mes</a>
                    <a href="/userAdmin/calendarioSemana?fecha=<?= $fechaInicio ?>" class="btn btn-outline-primary active">Semana</a>
                    <a href="/userAdmin/calendarioDia?fecha=<?= $fechaInicio ?>" class="btn btn-outline-primary">Día</a>
                </div>
                <div class="d-flex gap-3 align-items-center">
                    <span><span class="badge bg-success">&nbsp;</span> Aeropuerto→Hotel</span>
                    <span><span class="badge bg-warning text-dark">&nbsp;</span> Hotel→Aeropuerto</span>
                    <span><span class="badge bg-primary">&nbsp;</span> Ida y vuelta</span>
                </div>
            </div>
            <table class="table table-bordered text-center align-middle">
                <thead>
                    <tr>
                        <?php foreach ($nombresSemana as $i => $nombre): ?>
                            <th><?= $nombre ?><br><?= fechaFormateada($dias[$i]) ?></th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <?php foreach ($dias as $fecha): ?>
                            <td class="p-1">
                                <?php if (!empty($reservasPorDia[$fecha])): ?>
                                    <?php foreach ($reservasPorDia[$fecha] as $r):
                                        $color = match ((int)$r['id_tipo_reserva']) {
                                            1 => 'success',
                                            2 => 'warning text-dark',
                                            3 => 'primary',
                                            default => 'secondary'
                                        };
                                        $nombre = htmlspecialchars($r['nombre_viajero'] ?? $r['nombre_hotel'] ?? '-');
                                        $hora = htmlspecialchars(substr($r['hora_entrada'] ?? $r['hora_vuelo_salida'] ?? '', 0, 5));
                                    ?>
                                        <span class="badge bg-<?= $color ?> d-block my-1" style="cursor:pointer;" onclick="window.location.href='/userAdmin/verReserva/<?= $r['id_reserva'] ?>'">
                                            <?= $nombre ?> — <?= $hora ?>
                                        </span>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </td>
                        <?php endforeach; ?>
                    </tr>
                </tbody>
            </table>
    </main>
</div>

<?php require __DIR__ . '/../components/footer.php'; ?>