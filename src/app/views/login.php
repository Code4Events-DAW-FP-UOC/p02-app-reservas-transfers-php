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

 <form action="/login/process" method="POST">
    <label for="email">Correo electrónico:</label>
    <input type="email" id="email" name="email" style="width:100%; padding:0.5rem; margin-top:0.25rem;"/>

    <label for="password" style="margin-top: 1rem;">Contraseña:</label>
    <input type="password" id="password" name="password" style="width:100%; padding:0.5rem; margin-top:0.25rem;"/>

    <button type="submit" style="width:100%; margin-top:1.5rem; padding: 0.75rem; background:#007bff; color:white; border:none; border-radius:4px; cursor:pointer;">Entrar</button>
</form>

<p style="text-align:center; margin-top: 1rem;">
    ¿No tienes cuenta? <a href="/register">Regístrate aquí</a>
</p>

<?php require __DIR__ . '/layout/footer.php'; ?>