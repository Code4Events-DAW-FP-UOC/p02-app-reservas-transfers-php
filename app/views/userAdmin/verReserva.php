<?php require __DIR__ . '/../components/header.php'; ?>
<?php require __DIR__ . '/../components/navbar.php'; ?>

<div class="container mt-4" style="max-width: 700px;">
    <div class="card shadow p-4">
        <h2 class="mb-4">Detalle de la Reserva</h2>
        <?php if ($reserva): ?>
            <dl class="row">
                <?php foreach ($reserva as $campo => $valor): ?>
                    <dt class="col-sm-4"><?= htmlspecialchars($campo) ?></dt>
                    <dd class="col-sm-8"><?= htmlspecialchars($valor) ?></dd>
                <?php endforeach; ?>
            </dl>
        <?php else: ?>
            <div class="alert alert-danger">No se encontró la reserva.</div>
        <?php endif; ?>
        <a href="/userAdmin/calendario" class="btn btn-secondary mt-3">Volver</a>
    </div>
</div>
<?php require __DIR__ . '/../components/footer.php'; ?>