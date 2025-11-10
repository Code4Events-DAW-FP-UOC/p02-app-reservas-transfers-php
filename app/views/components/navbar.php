<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar navbar-brand" href="/">
            <img src="/img/logo.png" alt="Logo" height="40">
            Isla Transfers
        </a>
        <div class="d-flex align-items-center">
            <?php if (!empty($_SESSION['user_id'])): ?>
                <!-- Si usuario logueado es admin: -->
                <?php if ($_SESSION['user_rol'] === 'admin'): ?>
                    <a href="/userAdmin/dashboard" class="btn btn-warning me-2">Panel administración</a>
                <?php endif; ?>
                <div class="dropdown">
                    <a class="nav-link dropdown-toggle text-white d-flex align-items-center" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person-circle me-1"></i>
                        <?= htmlspecialchars($_SESSION['user_name'] ?? '') ?>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                        <li>
                            <a class="dropdown-item" href="/user/edit">Editar perfil</a>
                        </li>
                        <li><a class="dropdown-item" href="/user/misreservas">Ver mis reservas</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item text-danger" href="/auth/logout">
                                <i class="bi bi-box-arrow-right me-1"></i> Cerrar sesión
                            </a>
                        </li>
                    </ul>
                </div>

            <?php else: ?>
                <a href="/auth/login" class="btn btn-primary">Inicia sesión</a>
            <?php endif; ?>
        </div>

    </div>
</nav>