<?php require __DIR__ . '/../components/header.php'; ?>
<?php require __DIR__ . '/../components/navbar.php'; ?>

<div class="container mt-5" style="max-width: 1000px;">
    <div class="card shadow p-4">
        <h2 class="mb-4 text-center">Crear cuenta</h2>
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <?php if (!empty($success)): ?>
            <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>
        <form method="post" action="/auth/registro">
            <div class="row mb-3">
                <div class="col-md-4 mb-2 mb-md-0">
                    <label for="nombre" class="form-label">Nombre<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="nombre" id="nombre" required>
                </div>
                <div class="col-md-4 mb-2 mb-md-0">
                    <label for="apellido1" class="form-label">Primer apellido<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="apellido1" id="apellido1" required>
                </div>
                <div class="col-md-4 mb-2 mb-md-03">
                    <label for="apellido2" class="form-label">Segundo apellido</label>
                    <input type="text" class="form-control" name="apellido2" id="apellido2">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4 mb-2 mb-md-03">
                    <label for="rol" class="form-label">Tipo de usuario<span class="text-danger">*</span></label>
                    <select class="form-select" name="rol" id="rol" required>
                        <option value="particular" selected>Particular</option>
                        <option value="corporativo">Corporativo</option>
                    </select>
                </div>
                <div class="col-md-8 mb-2 mb-md-03">
                    <label for="direccion" class="form-label">Direccion</label>
                    <input type="text" class="form-control" name="direccion" id="direccion">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4 mb-2 mb-md-03">
                    <label for="codigoPostal" class="form-label">Codigo postal</label>
                    <input type="text" class="form-control" name="codigoPostal" id="codigoPostal">
                </div>
                <div class="col-md-4 mb-2 mb-md-03">
                    <label for="ciudad" class="form-label">Ciudad</label>
                    <input type="text" class="form-control" name="ciudad" id="ciudad">
                </div>
                <div class="col-md-4 mb-2 mb-md-03">
                    <label for="pais" class="form-label">Pais</label>
                    <input type="text" class="form-control" name="pais" id="pais">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4 mb-2 mb-md-03">
                    <label for="email" class="form-label">Correo electrónico<span class="text-danger">*</span></label>
                    <input type="email" class="form-control" name="email" id="email" required>
                </div>
                <div class="col-md-4 mb-2 mb-md-03">
                    <label for="password" class="form-label">Contraseña<span class="text-danger">*</span></label>
                    <input type="password" class="form-control" name="password" id="password" required>
                </div>
                <div class="col-md-4 mb-2 mb-md-03">
                    <label for="confirm" class="form-label">Repite la contraseña<span class="text-danger">*</span></label>
                    <input type="password" class="form-control" name="confirm" id="confirm" required>
                </div>
            </div>
            <button type="submit" class="btn btn-primary w-100">Registrar</button>
        </form>
    </div>
</div>

<?php require __DIR__ . '/../components/footer.php'; ?>