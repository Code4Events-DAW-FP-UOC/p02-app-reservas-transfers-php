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

<form action="/register/process" method="POST">
    <label for="nombre">Nombre:</label>
    <input type="text" id="nombre" name="nombre" required style="width:100%; margin-top:0.25rem; padding:0.5rem;" />

    <label for="apellido1" style="margin-top:1rem;">Primer apellido:</label>
    <input type="text" id="apellido1" name="apellido1" required style="width:100%; margin-top:0.25rem; padding:0.5rem;" />

    <label for="apellido2" style="margin-top:1rem;">Segundo apellido:</label>
    <input type="text" id="apellido2" name="apellido2" style="width:100%; margin-top:0.25rem; padding:0.5rem;" />

    <label for="direccion" style="margin-top:1rem;">Dirección:</label>
    <input type="text" id="direccion" name="direccion" style="width:100%; margin-top:0.25rem; padding:0.5rem;" />

    <label for="codigoPostal" style="margin-top:1rem;">Código Postal:</label>
    <input type="text" id="codigoPostal" name="codigoPostal" style="width:100%; margin-top:0.25rem; padding:0.5rem;" />

    <label for="ciudad" style="margin-top:1rem;">Ciudad:</label>
    <input type="text" id="ciudad" name="ciudad" style="width:100%; margin-top:0.25rem; padding:0.5rem;" />

    <label for="pais" style="margin-top:1rem;">País:</label>
    <input type="text" id="pais" name="pais" style="width:100%; margin-top:0.25rem; padding:0.5rem;" />

    <label for="email" style="margin-top:1rem;">Correo electrónico:</label>
    <input type="email" id="email" name="email" required style="width:100%; margin-top:0.25rem; padding:0.5rem;" />

    <label for="password" style="margin-top:1rem;">Contraseña:</label>
    <input type="password" id="password" name="password" required style="width:100%; margin-top:0.25rem; padding:0.5rem;" autocomplete="new-password" />

    <label for="verify" style="margin-top:1rem;">Verificar contraseña:</label>
    <input type="password" id="verify" name="verify" required style="width:100%; margin-top:0.25rem; padding:0.5rem;" autocomplete="new-password" />

    <label for="rol" style="margin-top:1rem;">Rol:</label>
    <select id="rol" name="rol" required style="width:100%; margin-top:0.25rem; padding:0.5rem;">
        <option value="">Selecciona un rol</option>
        <option value="particular">Particular</option>
        <option value="corporativo">Corporativo</option>
        <option value="administrador">Administrador</option>
    </select>

    <button type="submit" style="width:100%; margin-top:1.5rem; padding:0.75rem; background:#007bff; color:#fff; border:none; border-radius:4px; cursor:pointer;">
        Registrarse
    </button>
</form>

<p style="text-align:center; margin-top:1rem;">
    ¿Ya tienes cuenta? <a href="/login">Inicia sesión aquí</a>
</p>

<?php require __DIR__ . '/layout/footer.php'; ?>