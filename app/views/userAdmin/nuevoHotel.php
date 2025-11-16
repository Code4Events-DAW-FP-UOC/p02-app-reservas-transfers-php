<?php require __DIR__ . '/../components/header.php'; ?>
<?php require __DIR__ . '/../components/navbar.php'; ?>

<div class="container mt-4" style="max-width: 700px;">
    <div class="card shadow p-4">
        <h2 class="mb-4">Crear hotel</h2>
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <?php if (!empty($success)): ?>
            <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>
        <form method="post">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre del hotel<span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="nombre" id="nombre" required>
            </div>
            <div class="mb-3">
                <label for="id_zona" class="form-label">Zona<span class="text-danger">*</span></label>
                <select class="form-select" name="id_zona" id="id_zona" required>
                    <option value="">Seleccione una zona</option>
                    <?php foreach ($zonas as $zona): ?>
                        <option value="<?= $zona['id_zona'] ?>"><?= htmlspecialchars($zona['descripcion']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="usuario" class="form-label">Usuario<span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="usuario" id="usuario" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Correo electrónico<span class="text-danger">*</span></label>
                <input type="email" class="form-control" name="email" id="email" required>
            </div>
            <div class="mb-3">
                <label for="comision" class="form-label">Comisión (%)</label>
                <input type="number" min="0" class="form-control" name="comision" id="comision">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Contraseña<span class="text-danger">*</span></label>
                <input type="password" class="form-control" name="password" id="password" required>
            </div>
            <div class="mb-3">
                <label for="confirm" class="form-label">Confirmar contraseña<span class="text-danger">*</span></label>
                <input type="password" class="form-control" name="confirm" id="confirm" required>
            </div>
            <button type="submit" class="btn btn-primary">Crear hotel</button>
            <a href="/userAdmin/listadoHoteles" class="btn btn-secondary ms-2">Volver</a>
        </form>
    </div>
</div>
<?php require __DIR__ . '/../components/footer.php'; ?>