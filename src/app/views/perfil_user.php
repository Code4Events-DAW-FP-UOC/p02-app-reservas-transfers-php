<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['error'])) {
    echo '<p style="color: red; text-align: center; margin-top: 1rem;">' . htmlspecialchars($_SESSION['error']) . '</p>';
    unset($_SESSION['error']);
}
$isLoggedIn = isset($_SESSION['user_id']);
$nombre_session = $_SESSION['username'] ?? 'Visitante';
$email_session = $_SESSION['email'] ?? 'N/A';
$rol_session = $_SESSION['user_rol'] ?? 'usuario';

if (!$isLoggedIn) {

    header('Location: /login');
    exit(); 

}
?>

<?php require __DIR__ . '/layout/header.php'; ?>
<?php require __DIR__ . '/layout/navbar.php'; ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- Saludo -->
            <h1 class="mb-4">Hola, <?php echo $nombre_session; ?></h1>

            <!-- Card de Información General del Perfil -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    Tu Información de Perfil
                </div>
                <div class="card-body">
                    <p class="card-text"><strong>Email:</strong> <?php echo htmlspecialchars($email_session); ?></p>
                    <p class="card-text"><strong>Rol:</strong> <span class="badge bg-info text-dark"><?php echo htmlspecialchars($rol_session); ?></span></p>
                </div>
            </div>
            
            <!-- ACORDEÓN / COLLAPSE para Editar Perfil -->
            <div class="card">
                <div class="card-header p-0" id="headingEdit">
                    <h2 class="mb-0">
                        <!-- Botón que activa el colapsable -->
                            <button class="btn btn-link text-left collapsed d-flex justify-content-between align-items-center w-100 p-3 text-decoration-none" 
                                    type="button" 
                                    data-bs-toggle="collapse" 
                                    data-bs-target="#collapseEdit" 
                                    aria-expanded="false" 
                                    aria-controls="collapseEdit">
                                <span class="fs-5 text-dark">Editar Perfil</span>
                                <!-- Icono de Bootstrap para el desplegable -->
                            </button>
                    </h2>
                </div>

                <div id="collapseEdit" class="collapse" aria-labelledby="headingEdit">
                    <div class="card-body">
                        <h4>Actualizar Datos</h4>
                        <form action="/perfil/editar" method="POST">
                         <input type="hidden" id="email_original" name="email_original" value="<?php echo $email_session; ?>" required>
                            <div class="mb-3">
                                <label for="username" class="form-label">Nombre de Usuario</label>
                                <input type="text" class="form-control" id="username" name="nombre" 
                                       value="<?php echo $nombre_session; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Correo Electrónico</label>
                                <input type="text" class="form-control" id="email" name="email" 
                                       value="<?php echo $email_session; ?>" required>
                            </div>
                            
                            <button class="btn btn-primary rounded-2" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePassword" aria-expanded="false" aria-controls="collapsePassword">
                                Cambiar Contraseña
                            </button>
                            

                            <div class="collapse mt-3" id="collapsePassword">
                                <div class="card card-body p-3 bg-light">
                                    <div class="mb-3">
                                        <label for="password_nueva" class="form-label">Nueva Contraseña</label>
                                        <input type="password" class="form-control" id="password_nueva" name="password_nueva" placeholder="Dejar vacío para no cambiar">
                                    </div>
                                    <div class="mb-3">
                                        <label for="confirmar_password" class="form-label">Confirmar Contraseña</label>
                                        <input type="password" class="form-control" id="confirmar_password" name="confirmar_password" placeholder="Repetir nueva contraseña">
                                    </div>
                                    </div>
                            </div>

                            <div class="d-flex  mt-3"> 
                                <button type="submit" class="btn btn-success">Guardar Cambios</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>

<?php require __DIR__ . '/layout/footer.php'; ?>