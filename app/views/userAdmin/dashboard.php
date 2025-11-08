<?php require __DIR__ . '/../components/header.php'; ?>
<?php require __DIR__ . '/../components/navbar.php'; ?>

<div class="container mt-5">
    <h2>Bienvenido, <?= htmlspecialchars($_SESSION['user_name'] ?? '') ?>!</h2>
    <p>Este es tu panel de adminstrador.</p>
</div>

<?php require __DIR__ . '/../components/footer.php'; ?>