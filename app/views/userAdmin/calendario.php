<?php require __DIR__ . '/../components/header.php'; ?>
<?php require __DIR__ . '/../components/navbar.php'; ?>

<div class="d-flex" style="min-height: 100vh;">
    <?php require __DIR__ . '/../components/sidebar.php'; ?>
    <main class="flex-grow-1 p-5">
        <?php
        $diasEnMes = (int)date('t', strtotime("$year-$month-01"));
        $primerDiaSemana = date('N', strtotime("$year-$month-01"));
        $nombresMes = [
            1 => 'Enero',
            2 => 'Febrero',
            3 => 'Marzo',
            4 => 'Abril',
            5 => 'Mayo',
            6 => 'Junio',
            7 => 'Julio',
            8 => 'Agosto',
            9 => 'Septiembre',
            10 => 'Octubre',
            11 => 'Noviembre',
            12 => 'Diciembre'
        ];
        $nombresSemana = ['Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb', 'Dom'];
        $reservasPorDia = [];
        foreach ($reservas as $r) {
            $dia = null;
            // Si la reserva tiene fecha_entrada en este mes, cuenta para ese día
            if (!empty($r['fecha_entrada']) && date('Y-m', strtotime($r['fecha_entrada'])) == sprintf('%04d-%02d', $year, $month)) {
                $dia = (int)date('j', strtotime($r['fecha_entrada']));
            }
            // O si es solo vuelta, cuenta para ese día de vuelta
            elseif (!empty($r['fecha_vuelo_salida']) && date('Y-m', strtotime($r['fecha_vuelo_salida'])) == sprintf('%04d-%02d', $year, $month)) {
                $dia = (int)date('j', strtotime($r['fecha_vuelo_salida']));
            }
            if ($dia) $reservasPorDia[$dia][] = $r;
        }
        ?>
        <div class="container mt-4">
            <h2 class="mb-4">Calendario de reservas — <?= $nombresMes[(int)$month] ?> <?= $year ?></h2>
            <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap">
                <form method="get" class="d-flex align-items-center gap-2">
                    <input type="number" name="month" min="1" max="12" value="<?= $month ?>" class="form-control" style="width:90px">
                    <input type="number" name="year" min="2020" max="2100" value="<?= $year ?>" class="form-control" style="width:110px">
                    <button class="btn btn-outline-primary">Ir</button>
                </form>
                <div class="btn-group">
                    <a href="/userAdmin/calendario?month=<?= $month ?>&year=<?= $year ?>" class="btn btn-outline-primary active">Mes</a>
                    <a href="/userAdmin/calendarioSemana" class="btn btn-outline-primary">Semana</a>
                    <a href="/userAdmin/calendarioDia" class="btn btn-outline-primary">Día</a>
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
                        <?php foreach ($nombresSemana as $nombre): ?>
                            <th><?= $nombre ?></th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $dia = 1;
                    $semana = 1;
                    while ($dia <= $diasEnMes):
                        echo '<tr>';
                        for ($w = 1; $w <= 7; $w++) {
                            if (($semana === 1 && $w < $primerDiaSemana) || $dia > $diasEnMes) {
                                echo '<td></td>';
                            } else {
                                echo '<td class="p-1">';
                                echo '<strong>' . $dia . '</strong><br>';
                                if (!empty($reservasPorDia[$dia])) {
                                    foreach ($reservasPorDia[$dia] as $r) {
                                        $color = match ((int)$r['id_tipo_reserva']) {
                                            1 => 'success',
                                            2 => 'warning text-dark',
                                            3 => 'primary',
                                            default => 'secondary'
                                        };
                                        $nombre = htmlspecialchars($r['nombre_viajero'] ?? $r['nombre_hotel'] ?? '-');
                                        $hora = htmlspecialchars(substr($r['hora_entrada'] ?? $r['hora_vuelo_salida'] ?? '', 0, 5));
                                        echo '<span class="badge bg-' . $color . ' d-block my-1" style="cursor:pointer;" onclick="window.location.href=\'/userAdmin/verReserva/' . $r['id_reserva'] . '\'">'
                                            . $nombre . ' — ' . $hora
                                            . '</span>';
                                    }
                                }
                                echo '</td>';
                                $dia++;
                            }
                        }
                        echo '</tr>';
                        $semana++;
                    endwhile;
                    ?>
                </tbody>
            </table>
    </main>
</div>

<?php require __DIR__ . '/../components/footer.php'; ?>