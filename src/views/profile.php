<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mi Perfil - Isla Transfers</title>
    <link rel="stylesheet" href="/public/css/style.css">
    <style>
        .form-container { max-width: 500px; margin: 2rem auto; }
        .back-link { display: block; margin-bottom: 1rem; color: #666; text-decoration: none; }
    </style>
</head>
<body>

    <div class="form-container">
        <?php 
            $dashboard = ($_SESSION['user_role'] === 'admin') ? '/admin/dashboard' : '/particular/dashboard';
        ?>
        <a href="<?php echo $dashboard; ?>" class="back-link">← Volver al Panel</a>

        <h1>Mi Perfil</h1>

        <?php
        if (isset($_SESSION['success_message'])) {
            echo '<p style="color:green; background:#d4edda; padding:1rem;">' . $_SESSION['success_message'] . '</p>';
            unset($_SESSION['success_message']);
        }
        if (isset($_SESSION['error_message'])) {
            echo '<p style="color:red; background:#fee; padding:1rem;">' . $_SESSION['error_message'] . '</p>';
            unset($_SESSION['error_message']);
        }
        ?>

        <form action="/perfil/update" method="POST">
            <div class="form-group">
                <label>Nombre:</label>
                <input type="text" name="nombre" value="<?php echo htmlspecialchars($user['nombre']); ?>" required>
            </div>

            <div class="form-group">
                <label>Email:</label>
                <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            </div>

            <div class="form-group">
                <label>Nueva Contraseña (Opcional):</label>
                <input type="password" name="password" placeholder="Dejar en blanco para no cambiar">
            </div>

            <button type="submit">Guardar Cambios</button>
        </form>
    </div>

</body>
</html>