<?php require __DIR__ . '/../components/header.php'; ?>
<?php require __DIR__ . '/../components/navbar.php'; ?>

<div class="container mt-4" style="max-width: 700px;">
    <div class="card shadow p-4">
        <h2 class="mb-4">Crear vehículo</h2>
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <?php if (!empty($success)): ?>
            <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>
        <form method="post">
            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción<span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="descripcion" id="descripcion" required>
            </div>
            <div class="mb-3">
                <label for="email_conductor" class="form-label">Correo electrónico del conductor<span class="text-danger">*</span></label>
                <input type="email" class="form-control" name="email_conductor" id="email_conductor" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Contraseña<span class="text-danger">*</span></label>
                <input type="password" class="form-control" name="password" id="password" required>
            </div>
            <div class="mb-3">
                <label for="confirm" class="form-label">Confirmar contraseña<span class="text-danger">*</span></label>
                <input type="password" class="form-control" name="confirm" id="confirm" required>
            </div>
            <button type="submit" class="btn btn-primary">Crear vehículo</button>
            <a href="/userAdmin/listadoVehiculos" class="btn btn-secondary ms-2">Volver</a>
        </form>
    </div>
</div>
<?php require __DIR__ . '/../components/footer.php'; ?>