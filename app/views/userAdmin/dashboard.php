<?php require __DIR__ . '/../components/header.php'; ?>
<?php require __DIR__ . '/../components/navbar.php'; ?>

<div class="d-flex" style="min-height: 100vh;">
    <?php require __DIR__ . '/../components/sidebar.php'; ?>
    <main class="flex-grow-1 p-5">
        <div class="row mb-4">
            <div class="col text-center">
                <h1 class="display-5 fw-bold">Panel de Administración</h1>
                <p class="lead">Gestiona reservas, usuarios, hoteles y más desde tu panel centralizado.</p>
            </div>
        </div>
        <!-- Resumen rápido -->
        <div class="row g-4 mb-4">
            <div class="col-md-3">
                <div class="card text-white bg-primary h-100 shadow-sm">
                    <div class="card-body text-center">
                        <i class="bi bi-calendar-check display-5 mb-2"></i>
                        <h5 class="card-title">Reservas</h5>
                        <h2><?= (int)($numReservas ?? 0) ?></h2>
                        <a href="/userAdmin/listadoReservas" class="btn btn-outline-light btn-sm w-100 mt-2">Ver reservas</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-success h-100 shadow-sm">
                    <div class="card-body text-center">
                        <i class="bi bi-person-badge display-5 mb-2"></i>
                        <h5 class="card-title">Usuarios</h5>
                        <h2><?= (int)($numUsuarios ?? 0) ?></h2>
                        <a href="/userAdmin/gestionUsuarios" class="btn btn-outline-light btn-sm w-100 mt-2">Ver usuarios</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-info h-100 shadow-sm">
                    <div class="card-body text-center">
                        <i class="bi bi-building display-5 mb-2"></i>
                        <h5 class="card-title">Hoteles</h5>
                        <h2><?= (int)($numHoteles ?? 0) ?></h2>
                        <a href="/userAdmin/gestionHoteles" class="btn btn-outline-light btn-sm w-100 mt-2">Ver hoteles</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-warning h-100 shadow-sm">
                    <div class="card-body text-center">
                        <i class="bi bi-truck-front display-5 mb-2"></i>
                        <h5 class="card-title">Vehículos</h5>
                        <h2><?= (int)($numVehiculos ?? 0) ?></h2>
                        <a href="/userAdmin/gestionVehiculos" class="btn btn-outline-light btn-sm w-100 mt-2">Ver vehículos</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Accesos rápidos -->
        <div class="row mt-4 g-3 justify-content-center">
            <div class="col-12 col-md-4">
                <a href="/userAdmin/nuevaReserva" class="btn btn-success btn-lg w-100 d-flex align-items-center justify-content-center">
                    <i class="bi bi-plus-circle me-2"></i> Crear nueva reserva
                </a>
            </div>
            <div class="col-12 col-md-4">
                <a href="/userAdmin/calendario" class="btn btn-outline-primary btn-lg w-100 d-flex align-items-center justify-content-center">
                    <i class="bi bi-calendar3 me-2"></i> Ver calendario
                </a>
            </div>
        </div>
    </main>
</div>

<?php require __DIR__ . '/../components/footer.php'; ?>