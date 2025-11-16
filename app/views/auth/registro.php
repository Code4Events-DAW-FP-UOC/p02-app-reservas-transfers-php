<?php require __DIR__ . '/../components/header.php'; ?>
<?php require __DIR__ . '/../components/navbar.php'; ?>

<div class="container mt-5" style="max-width: 1000px;">
    <div class="card shadow p-4">
        <form method="post" action="/auth/registro">
            <div class="row align-items-center mb-4">
                <div class="col-md-6 text-md-start text-center">
                    <h2 class="mb-0">Crear cuenta</h2>
                </div>
                <div class="col-md-6 text-md-end text-center">
                    <div class="form-check form-switch d-inline-flex align-items-center gap-2 justify-content-md-end justify-content-center">
                        <input class="form-check-input" type="checkbox" id="toggleCorporativo" name="es_corporativo">
                        <label class="form-check-label mb-0" for="toggleHotel"><strong>¿Registrar hotel o empresa?</strong></label>
                    </div>
                </div>
            </div>
            <?php if (!empty($error)): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            <?php if (!empty($success)): ?>
                <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
            <?php endif; ?>

            <div class="usuario-block">
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
                    <div class="col-md-12 mb-2 mb-md-03">
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
            </div>
            <div class="corporativo-block">
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
            </div>
            <button type="submit" class="btn btn-primary w-100">Registrar</button>
        </form>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggle = document.getElementById('toggleCorporativo');
        const usuarioBlock = document.querySelector('.usuario-block');
        const corporativoBlock = document.querySelector('.corporativo-block');
        // Por defecto, ocultamos el bloque de hotel
        if (corporativoBlock) corporativoBlock.style.display = 'none';

        // Quita required de todos los campos de hotel por defecto
        if (corporativoBlock) corporativoBlock.querySelectorAll('input, select').forEach(el => el.required = false);

        toggle.addEventListener('change', function() {
            if (toggle.checked) {
                // Muestra el bloque hotel, oculta el usuario
                if (corporativoBlock) corporativoBlock.style.display = '';
                // Opcional: deshabilita el usuarioBlock si quieres
                if (usuarioBlock) usuarioBlock.style.display = 'none';
                if (corporativoBlock) corporativoBlock.querySelectorAll('input, select').forEach(el => el.required = true);
                if (usuarioBlock) usuarioBlock.querySelectorAll('input, select').forEach(el => el.required = false);

            } else {
                // Oculta hotel, muestra usuario
                if (corporativoBlock) corporativoBlock.style.display = 'none';
                if (usuarioBlock) usuarioBlock.style.display = '';
                if (corporativoBlock) corporativoBlock.querySelectorAll('input, select').forEach(el => el.required = false);
                if (usuarioBlock) usuarioBlock.querySelectorAll('input, select').forEach(el => el.required = true);

            }
        });
    });
</script>
<?php require __DIR__ . '/../components/footer.php'; ?>