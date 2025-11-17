<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro - Isla Transfers</title>
    <link rel="stylesheet" href="/public/css/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>

    <div class="form-container">
        <h1>Registrarse</h1>

        <?php
        if (isset($_SESSION['error_message'])) {
            echo '<div class="error-message">' . $_SESSION['error_message'] . '</div>';
            unset($_SESSION['error_message']);
        }
        ?>

        <form action="/register" method="POST" autocomplete="off">
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" placeholder="Tu nombre" required>
            </div>
            
            <div class="form-group">
                <label for="apellido1">Primer Apellido:</label>
                <input type="text" id="apellido1" name="apellido1" placeholder="Primer apellido" required>
            </div>
            
            <div class="form-group">
                <label for="apellido2">Segundo Apellido:</label>
                <input type="text" id="apellido2" name="apellido2" placeholder="Segundo apellido">
            </div>

            <div class="form-group">
                <label for="email">Correo Electrónico:</label>
                <input type="email" id="email" name="email" placeholder="nombre@correo.com" required>
            </div>
            
            <div class="form-group">
                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <div class="form-group">
                <label for="direccion">Dirección:</label>
                <input type="text" id="direccion" name="direccion">
            </div>
            <div class="form-group">
                <label for="ciudad">Ciudad:</label>
                <input type="text" id="ciudad" name="ciudad">
            </div>
            <button type="submit">Registrarse</button>
        </form>
        <p>¿Ya tienes una cuenta? <a href="/login">Inicia sesión</a></p>
    </div>

</body>
</html>