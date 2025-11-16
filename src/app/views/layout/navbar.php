<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Saber si está logueado
$isLoggedIn = isset($_SESSION['user_id']);
$rol = $isLoggedIn ? $_SESSION['user_role'] : null;
?>

<nav class="navbar bg-light">
     <div class="container-fluid justify-content-between align-items-center">
        <div class="d-flex align-items-center px-3">
            <a class="navbar-brand" href="/">Isla Transfers</a>
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="
                        <?php if ($isLoggedIn){
                            // Redirigir según rol
                            if ($rol === 'administrador') echo '/adminpanel';
                            elseif ($rol === 'corporativo') echo '/corporatepanel';
                            else echo '/userpanel';
                        }else{
                            echo '/login';
                        }
                        ?>
                    ">Panel de Gestión</a>
                </li>
            </ul>
        </div>
                        
            <ul class="navbar-nav flex-row align-items-center px-5">
                <?php if ($isLoggedIn): ?>
                    <li class="nav-item">
                        <span class="navbar-text me-3">Hola, <?php echo htmlspecialchars($_SESSION['username']); ?></span>
                    </li>
                    <li class="nav-item">
                       <a class="btn btn-outline-light" href="/logout">LOGOUT</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="btn btn-outline-light" href="/register">SIGN UP</a>
                    </li>
                    <li class="nav-item ms-2">
                        <a class="btn btn-outline-light" href="/login">LOG IN</a>
                    </li>
                <?php endif; ?>
            </ul>
    </div>
</nav>
</header>

<main class="flex-grow-1">