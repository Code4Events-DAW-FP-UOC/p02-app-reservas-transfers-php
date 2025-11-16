<?php require __DIR__ . '/../components/header.php'; ?>
<?php require __DIR__ . '/../components/navbar.php'; ?>

<div class="container mt-4">
    <h2>Calendario de Reservas (mes: <?= htmlspecialchars($month) ?>/<?= htmlspecialchars($year) ?>)</h2>
    <form class="row g-3 mb-3" method="get">
        <div class="col-auto">
            <label for="month" class="form-label">Mes:</label>
            <select id="month" name="month" class="form-select">
                <?php for ($m = 1; $m <= 12; $m++): ?>
                    <option value="<?= $m ?>" <?= $m == $month ? 'selected' : '' ?>>
                        <?= str_pad($m, 2, '0', STR_PAD_LEFT) ?>
                    </option>
                <?php endfor; ?>
            </select>
        </div>
        <div class="col-auto">
            <label for="year" class="form-label">Año:</label>
            <input type="number" id="year" name="year" value="<?= htmlspecialchars($year) ?>" class="form-control" style="width:90px">
        </div>
        <div class="col-auto align-self-end">
            <button type="submit" class="btn btn-primary">Ver</button>
        </div>
        <div class="col-auto align-self-end">
            <a href="/userAdmin/calendarioSemana" class="btn btn-secondary">Vista semanal</a>
            <a href="/userAdmin/calendarioDia" class="btn btn-secondary">Vista diaria</a>
        </div>
    </form>

    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Trayecto</th>
                <th>Hotel</th>
                <th>Viajero</th>
                <th>Detalles</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($reservas as $reserva): ?>
                <tr>
                    <td><?= htmlspecialchars($reserva['fecha_entrada']) ?></td>
                    <td><?= htmlspecialchars($reserva['id_tipo_reserva']) ?></td>
                    <td><?= htmlspecialchars($reserva['id_hotel']) ?></td>
                    <td><?= htmlspecialchars($reserva['id_viajero']) ?></td>
                    <td>
                        <a href="/userAdmin/verReserva/<?= $reserva['id_reserva'] ?>" class="btn btn-sm btn-outline-primary">
                            Ver detalles
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php require __DIR__ . '/../components/footer.php'; ?>