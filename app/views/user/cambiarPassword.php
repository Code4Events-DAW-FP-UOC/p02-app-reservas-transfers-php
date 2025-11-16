<?php require __DIR__ . '/../components/header.php'; ?>
<?php require __DIR__ . '/../components/navbar.php'; ?>

<div class="container mt-5" style="max-width: 1000px;">
    <div class="card shadow p-4">

        <h2 class="mb-4 text-center">Cambiar contraseña</h2>
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <?php if (!empty($success)): ?>
            <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>
        <form method="post" action="/user/cambiarPassword">
            <div class="row mb-3">
                <div class="col-md-6 mb-2 mb-md-0">
                    <label for="password" class="form-label">
                        Nueva contraseña
                    </label>
                    <input type="password" class="form-control" name="password" id="password" autocomplete="new-password">
                </div>
                <div class="col-md-6">
                    <label for="confirm_password" class="form-label">
                        Repite la nueva contraseña
                    </label>
                    <input type="password" class="form-control" name="confirm_password" id="confirm_password" autocomplete="new-password">
                </div>
            </div>
            <button type="submit" class="btn btn-primary w-100">Cambiar contraseña</button>
        </form>
    </div>
</div>

<?php require __DIR__ . '/../components/footer.php'; ?>