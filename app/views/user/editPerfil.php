<?php require __DIR__ . '/../components/header.php'; ?>
<?php require __DIR__ . '/../components/navbar.php'; ?>

<div class="container mt-5" style="max-width: 1000px;">
    <div class="card shadow p-4">
        <h2 class="mb-4 text-center">Editar perfil</h2>
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <?php if (!empty($success)): ?>
            <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>
        <form method="post" action="/user/editarPerfil">
            <div class="row mb-3">
                <div class="col-md-4 mb-2 mb-md-0">
                    <label for="nombre" class="form-label">Nombre<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="nombre" id="nombre" required value="<?= htmlspecialchars($usuario['nombre']) ?>">
                </div>
                <div class="col-md-4 mb-2 mb-md-0">
                    <label for="apellido1" class="form-label">Primer apellido<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="apellido1" id="apellido1" required value="<?= htmlspecialchars($usuario['apellido1']) ?>">
                </div>
                <div class="col-md-4 mb-2 mb-md-0">
                    <label for="apellido2" class="form-label">Segundo apellido</label>
                    <input type="text" class="form-control" name="apellido2" id="apellido2" value="<?= htmlspecialchars($usuario['apellido2']) ?>">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-12 mb-2 mb-md-0">
                    <label for="direccion" class="form-label">Dirección</label>
                    <input type="text" class="form-control" name="direccion" id="direccion" value="<?= htmlspecialchars($usuario['direccion']) ?>">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4 mb-2 mb-md-0">
                    <label for="codigoPostal" class="form-label">Código postal</label>
                    <input type="text" class="form-control" name="codigoPostal" id="codigoPostal" value="<?= htmlspecialchars($usuario['codigoPostal']) ?>">
                </div>
                <div class="col-md-4 mb-2 mb-md-0">
                    <label for="ciudad" class="form-label">Ciudad</label>
                    <input type="text" class="form-control" name="ciudad" id="ciudad" value="<?= htmlspecialchars($usuario['ciudad']) ?>">
                </div>
                <div class="col-md-4 mb-2 mb-md-0">
                    <label for="pais" class="form-label">País</label>
                    <input type="text" class="form-control" name="pais" id="pais" value="<?= htmlspecialchars($usuario['pais']) ?>">
                </div>
            </div>
            <button type="submit" class="btn btn-primary w-100">Guardar cambios</button>
        </form>
    </div>

</div>

<?php require __DIR__ . '/../components/footer.php'; ?>