<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Saber si está logueado
$isLoggedIn = isset($_SESSION['user_id']);
$rol = $isLoggedIn ? $_SESSION['user_rol'] : null;
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
        <div class="dropdown ms-auto px-5">      
                <?php if ($isLoggedIn): ?> 
                        <a class="btn btn-outline-dark dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Hola, <?php echo htmlspecialchars($_SESSION['username']); ?>
                        </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="/perfil">
                                Perfil
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item text-danger" href="/logout">
                                Logout
                            </a>
                        </li>
                    </ul>
                <?php else: ?>
                <ul class="navbar-nav d-flex flex-row align-items-center">
                    <li class="nav-item">
                        <a class="btn btn-outline-light" href="/register">SIGN UP</a>
                    </li>
                    <li class="nav-item ms-2">
                        <a class="btn btn-outline-light" href="/login">LOG IN</a>
                    </li>
                </ul>
                <?php endif; ?>
        </div>
    </div>
</nav>
</header>

<main class="flex-grow-1">