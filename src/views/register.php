<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro - Isla Transfers</title>
</head>
<body>
    <h1>Registrarse</h1>

    <?php
    if (isset($_SESSION['error_message'])) {
        echo '<p style="color:red;">' . $_SESSION['error_message'] . '</p>';
        unset($_SESSION['error_message']);
    }
    ?>

    <form action="/register" method="POST">
        <div>
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" required>
        </div>
        <div>
            <label for="apellido1">Primer Apellido:</label>
            <input type="text" id="apellido1" name="apellido1" required>
        </div>
        <div>
            <label for="apellido2">Segundo Apellido:</label>
            <input type="text" id="apellido2" name="apellido2">
        </div>
        <div>
            <label for="email">Correo Electrónico:</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div>
            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" required>
        </div>
        
        <div>
            <label for="direccion">Dirección:</label>
            <input type="text" id="direccion" name="direccion">
        </div>
        <div>
            <label for="codigoPostal">Código Postal:</label>
            <input type="text" id="codigoPostal" name="codigoPostal">
        </div>
        <div>
            <label for="ciudad">Ciudad:</label>
            <input type="text" id="ciudad" name="ciudad">
        </div>
         <div>
            <label for="pais">País:</label>
            <input type="text" id="pais" name="pais">
        </div>

        <button type="submit">Registrarse</button>
    </form>
    <p>¿Ya tienes una cuenta? <a href="/login">Inicia sesión</a></p>
</body>
</html>