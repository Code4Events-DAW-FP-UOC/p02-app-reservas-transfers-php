<?php require __DIR__ . '/../components/header.php'; ?>
<?php require __DIR__ . '/../components/navbar.php'; ?>

<div class="container mt-4" style="max-width: 700px;">
    <div class="card shadow p-4">
        <h2 class="mb-4">Editar precio</h2>
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <?php if (!empty($success)): ?>
            <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>
        <form method="post">
            <div class="mb-3">
                <label for="id_hotel" class="form-label">Hotel<span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="id_hotel" id="id_hotel" value="<?= htmlspecialchars($precio['id_hotel']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="id_vehiculo" class="form-label">Vehículo<span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="id_vehiculo" id="id_vehiculo" value="<?= htmlspecialchars($precio['id_vehiculo']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="precio" class="form-label">Precio<span class="text-danger">*</span></label>
                <input type="number" step="0.01" class="form-control" name="precio" id="precio" value="<?= htmlspecialchars($precio['precio']) ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Guardar cambios</button>
            <a href="/userAdmin/listadoPrecios" class="btn btn-secondary ms-2">Volver</a>
        </form>
    </div>
</div>

<?php require __DIR__ . '/../components/footer.php'; ?>