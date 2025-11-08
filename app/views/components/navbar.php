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
        <div class="d-flex">
            <?php if (!empty($_SESSION['user_id'])): ?>
                <span class="navbar-text me-3 text-white">
                    <i class="bi bi-person-circle me-1"></i>
                    <?= htmlspecialchars($_SESSION['user_name'] ?? '') ?>
                </span>
                <!-- Menú dinámico según rol -->
                <?php if ($_SESSION['user_rol'] === 'admin'): ?>
                    <a href="/admin/panel" class="btn btn-outline-light me-2">Panel Admin</a>
                <?php elseif ($_SESSION['user_rol'] === 'corporativo'): ?>
                    <a href="/corporativo/panel" class="btn btn-outline-light me-2">Panel Corporativo</a>
                <?php elseif ($_SESSION['user_rol'] === 'particular'): ?>
                    <a href="/particular/panel" class="btn btn-outline-light me-2">Panel Usuario</a>
                <?php endif; ?>
                <a href="/auth/logout" class="btn btn-primary">Desconectar</a>
            <?php else: ?>
                <a href="/auth/login" class="btn btn-primary">Inicia sesión</a>
                <?php endif; ?>/
        </div>
    </div>
</nav>