<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login - Isla Transfers</title>
</head>
<body>
    <h1>Iniciar Sesión</h1>
    
    <?php
    // Si la sesión tiene un mensaje de error, lo mostramos
    if (isset($_SESSION['error_message'])) {
        echo '<p style="color:red;">' . $_SESSION['error_message'] . '</p>';
        unset($_SESSION['error_message']); // Lo limpiamos para no mostrarlo más
    }
    ?>

    <form action="/login" method="POST">
        <div>
            <label for="email">Correo Electrónico:</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div>
            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" required>
        </div>
        <button type="submit">Entrar</button>
    </form>
    <p>¿No tienes una cuenta? <a href="/register">Regístrate aquí</a></p>
</body>
</html>