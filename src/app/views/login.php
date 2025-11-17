<?php require __DIR__ . '/layout/header.php'; ?>
<?php require __DIR__ . '/layout/navbar.php'; ?>

<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['error'])) {
    echo '<p style="color: red; text-align: center; margin-top: 1rem;">' . htmlspecialchars($_SESSION['error']) . '</p>';
    unset($_SESSION['error']);
}
?>
<div class="d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="card p-4 shadow" style="width: 100%; max-width: 400px;">
        <div class="card-body">
            <h2 class="card-title text-center mb-4">Iniciar Sesión</h2>
            <form action="/login/process" method="POST">
                <label for="email">Correo electrónico:</label>
                <input type="email" id="email" name="email" class="form-control"/>
            
                <label for="password" style="margin-top: 1rem;">Contraseña:</label>
                <input type="password" id="password" name="password"class="form-control"/>
            
                <button type="submit" class="btn btn-primary w-100 mt-3">Entrar</button>
            </form>
            
            <p class="text-center mt-3 mb-0">
                ¿No tienes cuenta? <a href="/register">Regístrate aquí</a>
            </p>
        </div>
    </div>
</div>

<?php require __DIR__ . '/layout/footer.php'; ?>