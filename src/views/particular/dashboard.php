<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mi Área - Isla Transfers</title>
    <link rel="stylesheet" href="/public/css/style.css">
    <style>
        .dashboard-container { max-width: 800px; margin: 2rem auto; padding: 2rem; background: white; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
        .header { display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #28a745; padding-bottom: 1rem; margin-bottom: 2rem;}
        .role-badge { background: #28a745; color: white; padding: 5px 10px; border-radius: 5px; font-weight: bold; }
        .menu-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; }
        .menu-item { background: #f8f9fa; padding: 1.5rem; border: 1px solid #ddd; border-radius: 8px; text-align: center; text-decoration: none; color: #333; font-weight: bold; transition: 0.3s; }
        .menu-item:hover { background: #28a745; color: white; transform: translateY(-3px); }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <div class="header">
            <div>
                <h1>Área Cliente</h1>
                <span class="role-badge">PARTICULAR</span>
            </div>
            <div>
                Hola, <strong><?php echo htmlspecialchars($_SESSION['user_name']); ?></strong>
                <br><a href="/logout" style="color: red; font-size: 0.9rem;">Cerrar Sesión</a>
            </div>
        </div>

        <div class="menu-grid">
            <a href="/reservar" class="menu-item">🚕 Solicitar Transfer</a>
            <a href="/mis-reservas" class="menu-item">🧾 Mis Reservas</a>
            <a href="/perfil" class="menu-item">👤 Mis Datos</a>
        </div>
    </div>
</body>
</html>