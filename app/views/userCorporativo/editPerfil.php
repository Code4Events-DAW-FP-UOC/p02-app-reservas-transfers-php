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
        <form method="post" action="/user/edit">
            <div class="row mb-3">
                <div class="col-md-9 mb-2 mb-md-03">
                    <label for="nombre_corporativo" class="form-label">Nombre del hotel o empresa<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="nombre_corporativo" id="nombre_corporativo" required>
                </div>
                <div class="col-md-3 mb-2 mb-md-03">
                    <label for="id_zona" class="form-label">Zona de la isla<span class="text-danger">*</span></label>
                    <select class="form-select" name="id_zona" id="id_zona" required>
                        <option value="" selected disabled>Selecciona una zona</option>
                        <?php foreach ($zonas as $zona): ?>
                            <option value="<?= htmlspecialchars($zona['id_zona']) ?>">
                                <?= htmlspecialchars($zona['descripcion']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6 mb-2 mb-md-03">
                    <label for="usuario_corporativo" class="form-label">Usuario<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="usuario_corporativo" id="usuario_corporativo" required>
                </div>
                <div class="col-md-6 mb-2 mb-md-03">
                    <label for="email_corporativo" class="form-label">Correo electrónico<span class="text-danger">*</span></label>
                    <input type="email" class="form-control" name="email_corporativo" id="email_corporativo" required>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6 mb-2 mb-md-03">
                    <label for="password_corporativo" class="form-label">Contraseña<span class="text-danger">*</span></label>
                    <input type="password" class="form-control" name="password_corporativo" id="password_corporativo" required>
                </div>
                <div class="col-md-6 mb-2 mb-md-03">
                    <label for="confirm_corporativo" class="form-label">Repite la contraseña<span class="text-danger">*</span></label>
                    <input type="password" class="form-control" name="confirm_corporativo" id="confirm_corporativo" required>
                </div>
            </div>
            <button type="submit" class="btn btn-primary w-100">Guardar cambios</button>
    </div>
    </form>
</div>
</div>

<?php require __DIR__ . '/../components/footer.php'; ?>