<?php require __DIR__ . '/../components/header.php'; ?>
<?php require __DIR__ . '/../components/navbar.php'; ?>

<div class="container mt-5">
    <div class="row mb-4">
        <div class="col text-center">
            <h1 class="display-5 fw-bold">¡Bienvenido, <?= htmlspecialchars($_SESSION['user_name']) ?>!</h1>
            <p class="lead">Desde tu panel puedes consultar, crear y gestionar tus reservas fácilmente.</p>
        </div>
    </div>

    <div class="row g-4 justify-content-center">
        <!-- Tarjeta de resumen de reservas -->
        <div class="col-md-4">
            <div class="card text-white bg-primary h-100 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-calendar-check display-4 me-3"></i>
                        <div>
                            <h5 class="card-title mb-1">Reservas activas</h5>
                            <h2><?= (int)($numReservasActivas ?? 0) ?></h2>
                            <small class="text-white-50">Reservas próximas a realizarse</small>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-center bg-primary">
                    <a href="/user/misReservas" class="btn btn-outline-light w-100">Ver mis reservas</a>
                </div>
            </div>
        </div>
        <!-- Botón nueva reserva -->
        <div class="col-md-4">
            <div class="card border-0 h-100 shadow">
                <div class="card-body d-flex flex-column align-items-center justify-content-center">
                    <i class="bi bi-plus-circle display-4 text-success mb-3"></i>
                    <h5 class="card-title mb-2">¿Necesitas un transfer?</h5>
                    <a href="/user/nuevaReserva" class="btn btn-success btn-lg w-100">Crear nueva reserva</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Accesos rápidos -->
    <div class="row mt-5 g-3">
        <div class="col-12 col-md-6">
            <a href="/user/editarPerfil" class="btn btn-outline-secondary w-100 d-flex align-items-center justify-content-center">
                <i class="bi bi-person-lines-fill me-2"></i> Editar perfil
            </a>
        </div>
        <div class="col-12 col-md-6">
            <a href="/user/cambiarPassword" class="btn btn-outline-secondary w-100 d-flex align-items-center justify-content-center">
                <i class="bi bi-key me-2"></i> Cambiar contraseña
            </a>
        </div>
    </div>
</div>
<?php require __DIR__ . '/../components/footer.php'; ?>