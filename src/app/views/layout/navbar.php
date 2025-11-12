<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Saber si está logueado
$isLoggedIn = isset($_SESSION['user_id']);
$rol = $isLoggedIn ? $_SESSION['user_role'] : null;
?>

<nav>
    <div>
        <h3><a href="/">Isla Transfers</a></h3>

        <?php if ($isLoggedIn): ?>
            <div>
                <a href="
                    <?php
                        // Redirigir según rol
                        if ($rol === 'administrador') echo '/adminpanel';
                        elseif ($rol === 'corporativo') echo '/corporatepanel';
                        else echo '/userpanel';
                    ?>
                ">Panel de Gestión</a>
            </div>

            <ul class="menu-login">
                <li><a href="/logout">LOGOUT (<?php echo htmlspecialchars($_SESSION['username']); ?>)</a></li>
            </ul>

        <?php else: ?>
            <a href="/login">Panel de Gestión</a>
            <ul class="menu-login">
                <li><a href="/register">SIGN UP</a></li>
                <li><a href="/login">LOGIN</a></li>
            </ul>
        <?php endif; ?>
    </div>
</nav>