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
<div class="d-flex justify-content-center align-items-center py-5">
    <div class="card p-4 shadow" style="width: 100%; max-width: 400px;">
        <div class="card-body">
            <h2 class="card-title text-center mb-4">Registro:</h2>
            <form action="/register/process" method="POST">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" required class="form-control" />

                <label for="apellido1" style="margin-top:1rem;">Primer apellido:</label>
                <input type="text" id="apellido1" name="apellido1" required class="form-control" />

                <label for="apellido2" style="margin-top:1rem;">Segundo apellido:</label>
                <input type="text" id="apellido2" name="apellido2" class="form-control" />

                <label for="direccion" style="margin-top:1rem;">Dirección:</label>
                <input type="text" id="direccion" name="direccion" class="form-control" />

                <label for="codigoPostal" style="margin-top:1rem;">Código Postal:</label>
                <input type="text" id="codigoPostal" name="codigoPostal" class="form-control" />

                <label for="ciudad" style="margin-top:1rem;">Ciudad:</label>
                <input type="text" id="ciudad" name="ciudad" class="form-control" />

                <label for="pais" style="margin-top:1rem;">País:</label>
                <input type="text" id="pais" name="pais" class="form-control" />

                <label for="email" style="margin-top:1rem;">Correo electrónico:</label>
                <input type="email" id="email" name="email" required class="form-control" />

                <label for="password" style="margin-top:1rem;">Contraseña:</label>
                <input type="password" id="password" name="password" required class="form-control" autocomplete="new-password" />

                <label for="verify" style="margin-top:1rem;">Verificar contraseña:</label>
                <input type="password" id="verify" name="verify" required class="form-control" autocomplete="new-password" />

                <label for="rol" style="margin-top:1rem;">Rol:</label>
                <select id="rol" name="rol" required class="form-select">
                    <option value="">Selecciona un rol</option>
                    <option value="particular">Particular</option>
                    <option value="corporativo">Corporativo</option>
                    <option value="administrador">Administrador</option>
                </select>

                <button type="submit" class="btn btn-primary w-100">
                    Registrarse
                </button>
            </form>

            <p sclass="text-center mt-3 mb-0">
                ¿Ya tienes cuenta? <a href="/login">Inicia sesión aquí</a>
            </p>
        </div>
    </div>
</div>

<?php require __DIR__ . '/layout/footer.php'; ?>