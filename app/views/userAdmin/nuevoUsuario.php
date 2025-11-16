<?php require __DIR__ . '/../components/header.php'; ?>
<?php require __DIR__ . '/../components/navbar.php'; ?>

<div class="container mt-4" style="max-width: 700px;">
    <div class="card shadow p-4">
        <h2 class="mb-4">Crear usuario</h2>
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <?php if (!empty($success)): ?>
            <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>
        <form method="post">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre<span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="nombre" id="nombre" required>
            </div>
            <div class="mb-3">
                <label for="apellido1" class="form-label">Primer apellido<span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="apellido1" id="apellido1" required>
            </div>
            <div class="mb-3">
                <label for="apellido2" class="form-label">Segundo apellido</label>
                <input type="text" class="form-control" name="apellido2" id="apellido2">
            </div>
            <div class="mb-3">
                <label for="direccion" class="form-label">Dirección</label>
                <input type="text" class="form-control" name="direccion" id="direccion">
            </div>
            <div class="mb-3">
                <label for="codigoPostal" class="form-label">Código Postal</label>
                <input type="text" class="form-control" name="codigoPostal" id="codigoPostal">
            </div>
            <div class="mb-3">
                <label for="ciudad" class="form-label">Ciudad</label>
                <input type="text" class="form-control" name="ciudad" id="ciudad">
            </div>
            <div class="mb-3">
                <label for="pais" class="form-label">País</label>
                <input type="text" class="form-control" name="pais" id="pais">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Correo electrónico<span class="text-danger">*</span></label>
                <input type="email" class="form-control" name="email" id="email" required>
            </div>
            <div class="mb-3">
                <label for="rol" class="form-label">Rol<span class="text-danger">*</span></label>
                <select class="form-select" name="rol" id="rol" required>
                    <option value="particular">Particular</option>
                    <option value="admin">Administrador</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Contraseña<span class="text-danger">*</span></label>
                <input type="password" class="form-control" name="password" id="password" required>
            </div>
            <div class="mb-3">
                <label for="confirm" class="form-label">Confirmar contraseña<span class="text-danger">*</span></label>
                <input type="password" class="form-control" name="confirm" id="confirm" required>
            </div>
            <button type="submit" class="btn btn-primary">Crear usuario</button>
            <a href="/userAdmin/listadoUsuarios" class="btn btn-secondary ms-2">Volver</a>
        </form>
    </div>
</div>
<?php require __DIR__ . '/../components/footer.php'; ?>