<?php require __DIR__ . '/../components/header.php'; ?>
<?php require __DIR__ . '/../components/navbar.php'; ?>

<div class="d-flex" style="min-height: 100vh;">
    <?php require __DIR__ . '/../components/sidebar.php'; ?>
    <main class="flex-grow-1 p-5">
        <h2 class="mb-4">Listado de vehículos</h2>
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
                    <th>Email conductor</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($vehiculos)): ?>
                    <tr>
                        <td colspan="4" class="text-center">No hay vehículos registrados.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($vehiculos as $vehiculo): ?>
                        <tr>
                            <td><?= htmlspecialchars($vehiculo['id_vehiculo']) ?></td>
                            <td><?= htmlspecialchars($vehiculo['descripcion']) ?></td>
                            <td><?= htmlspecialchars($vehiculo['email_conductor']) ?></td>
                            <td>
                                <a href="/userAdmin/editarVehiculo/<?= $vehiculo['id_vehiculo'] ?>" class="btn btn-primary btn-sm me-1" title="Editar">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <a href="/userAdmin/eliminarVehiculo/<?= $vehiculo['id_vehiculo'] ?>"
                                    class="btn btn-outline-danger btn-sm ms-2"
                                    onclick="return confirm('¿Seguro que deseas eliminar este vehículo?');"
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