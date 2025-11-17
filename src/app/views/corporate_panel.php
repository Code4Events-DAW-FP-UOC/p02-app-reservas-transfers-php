<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['error'])) {
    echo '<p style="color: red; text-align: center; margin-top: 1rem;">' . htmlspecialchars($_SESSION['error']) . '</p>';
    unset($_SESSION['error']);
}
$isLoggedIn = isset($_SESSION['user_id']);
$rol = $isLoggedIn ? $_SESSION['user_rol'] : null;
$rol_requerido = 'corporativo';
$rol_admin = 'administrador';

if (!$isLoggedIn || $rol !== $rol_requerido) {
    
    
    if (!$isLoggedIn) {
        header('Location: /login');
        exit(); 
    }

    if ($rol !== $rol_requerido) {
    
        if ($rol === $rol_admin) {
            header('Location: /adminpanel');
            exit();
        
        } else {
            header('Location: /userpanel');
            exit();
        }
    }
}



$tipo_reserva = $_POST['id_tipo_reserva'] ?? null;

$today = date('Y-m-d');

?>

<?php require __DIR__ . '/layout/header.php'; ?>
<?php require __DIR__ . '/layout/navbar.php'; ?>

<div class="container my-5">
    <div class="row">
        <div class="col-12">
            <h1 class="mb-4 text-primary border-bottom pb-2">Panel Corporativo (Hoteles)</h1>
            
            <div class="alert alert-warning" role="alert">
                <h4 class="alert-heading">Funcionalidad no disponible</h4>
                <p class="lead">
                    Bienvenido al Panel Corporativo. Lamentamos informarle que en este producto 
                    no existe un panel de gestión específico para hoteles. Actualmente, esta sección 
                    sirve únicamente como punto de acceso.
                </p>
            </div>
            
            </div>
    </div>
</div>

<?php require __DIR__ . '/layout/footer.php'; ?>
