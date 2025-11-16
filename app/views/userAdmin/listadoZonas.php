<?php require __DIR__ . '/../components/header.php'; ?>
<?php require __DIR__ . '/../components/navbar.php'; ?>

<div class="d-flex" style="min-height: 100vh;">
    <?php require __DIR__ . '/../components/sidebar.php'; ?>
    <main class="flex-grow-1 p-5">
        <h2 class="mb-4">Listado de zonas</h2>

        <?php if (!empty($_SESSION['success'])): ?>
            <div class="alert alert-success"><?= htmlspecialchars($_SESSION['success']) ?></div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>
        <?php if (!empty($_SESSION['error'])): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($_SESSION['error']) ?></div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>
        <table class="table table-striped table-hover align-middle">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Descripción</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($zonas)): ?>
                    <tr>
                        <td colspan="3" class="text-center">No hay zonas registradas.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($zonas as $zona): ?>
                        <tr>
                            <td><?= htmlspecialchars($zona['id_zona']) ?></td>
                            <td><?= htmlspecialchars($zona['descripcion']) ?></td>
                            <td>
                                <a href="/userAdmin/editarZona/<?= $zona['id_zona'] ?>" class="btn btn-primary btn-sm me-1" title="Editar">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <a href="/userAdmin/eliminarZona/<?= $zona['id_zona'] ?>"
                                    class="btn btn-outline-danger btn-sm ms-2"
                                    onclick="return confirm('¿Seguro que deseas eliminar esta zona?');"
                                    title="Eliminar">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </main>
</div>

<?php require __DIR__ . '/../components/footer.php'; ?>