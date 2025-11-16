<?php require __DIR__ . '/../components/header.php'; ?>
<?php require __DIR__ . '/../components/navbar.php'; ?>

<div class="container d-flex align-items-center justify-content-center" style="min-height: 80vh;">
    <div class="col-md-5 col-lg-4 p-4 shadow rounded-3 bg-white">
        <h2 class="text-center mb-4">Iniciar sesión</h2>
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <form method="post" action="/auth/login">
            <div class="mb-3">
                <label for="identificador" class="form-label">Correo electrónico o usuario</label>
                <input type="text" class="form-control" id="identificador" name="identificador" placeholder="Tu email o número de usuario" required autofocus>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Contraseña</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Tu contraseña" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Entrar</button>
            <p class="mt-3 text-center">
                ¿No tienes cuenta? <a href="/auth/registro">Regístrate</a>
            </p>
        </form>
    </div>
</div>

<?php require __DIR__ . '/../components/footer.php'; ?>