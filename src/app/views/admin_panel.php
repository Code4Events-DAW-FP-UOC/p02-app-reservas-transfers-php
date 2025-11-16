<?php require __DIR__ . '/layout/header.php'; ?>
<?php require __DIR__ . '/layout/navbar.php'; ?>

<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['error'])) {
    echo '<p style="color: red; text-align: center; margin-top: 1rem;">' . htmlspecialchars($_SESSION['error']) . '</p>';
    unset($_SESSION['error']);
}

$tipo_reserva = $_POST['id_tipo_reserva'] ?? null;
?>

<div class="container my-5">
    <div class="row">
        <div class="col-lg-10 col-xl-8 mx-auto">
                
            <h2 class="mb-4">Panel de Administración</h2>
                
            <form action="/adminpanel/reservar" method="POST">

                <div class="card shadow-sm mb-4">
                    <div class="card-body">

                        <div class="d-flex gap-2">
                            <select class="form-select form-select-lg" name="id_tipo_reserva" required>
                                <option value="" disabled <?php echo $tipo_reserva ? '' : 'selected'; ?>>Elige un tipo...</option>

                                <option value="1" <?php echo ($tipo_reserva == '1') ? 'selected' : ''; ?>>
                                    1. Aeropuerto -> Hotel
                                </option>
                                <option value="2" <?php echo ($tipo_reserva == '2') ? 'selected' : ''; ?>>
                                    2. Hotel -> Aeropuerto
                                </option>
                                <option value="3" <?php echo ($tipo_reserva == '3') ? 'selected' : ''; ?>>
                                    3. Ida y Vuelta
                                </option>
                            </select>
                            <button type="submit" name="accion" value="seleccionar_tipo" class="btn btn-secondary">
                                Seleccionar
                            </button>
                        </div>
                    </div>
                </div>

                <?php if ($tipo_reserva == '1' || $tipo_reserva == '3'): ?>
                    <div id="bloque-llegada" class="border p-3 mb-3 bg-white">
                        <h5 class="mb-3">Datos de Llegada (Aeropuerto a Hotel)</h5>
                        <div class="mb-3">
                            <label class="form-label">Día de Llegada</label>
                            <input type="date" class="form-control" name="fecha_entrada" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Hora de Llegada</label>
                            <input type="time" class="form-control" name="hora_entrada" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Numero de Vuelo de Ida</label>
                            <input type="text" class="form-control" name="numero_vuelo_entrada" placeholder="VY1234" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Aeropuerto de Origen</label>
                            <input type="text" class="form-control" name="origen_vuelo_entrada" placeholder="Barcelona (BCN)" required>
                        </div>
                    </div>
                <?php endif; ?>


                <?php if ($tipo_reserva == '2' || $tipo_reserva == '3'): ?>
                    <div id="bloque-salida" class="border p-3 mb-3 bg-white">
                        <h5 class="mb-3">Datos de Salida (Hotel a Aeropuerto)</h5>
                        <div class="mb-3">
                            <label class="form-label">Día del Vuelo (Salida)</label>
                            <input type="date" class="form-control" name="fecha_vuelo_salida" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Hora de Llegada</label>
                            <input type="time" class="form-control" name="hora_vuelo_salida" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Numero de Vuelo de Vuelta</label>
                            <input type="text" class="form-control" name="numero_vuelo_entrada" placeholder="VY1234" required>
                        </div>
                        <!--
                        <div class="mb-3">
                            <label class="form-label">Hora de Recogida</label>
                            <input type="time" class="form-control" name="---" required>
                        </div>
                        No exister en la base de datos
                        -->
                    </div>
                <?php endif; ?>


                <?php if ($tipo_reserva): // Solo muestra esto si ya se ha seleccionado un tipo ?>
                    <div id="bloque-comun" class="border p-3 mb-3 bg-white">
                        <h5 class="mb-3">Datos del Cliente y Hotel</h5>
                        <div class="mb-3">
                            <label for="hotel" style="margin-top:1rem;">Hotel</label>
                            <select id="hotel" name="id_hotel" required style="width:100%; margin-top:0.25rem; padding:0.5rem;">
                                <option value="">Selecciona un hotel</option>
                                <?php 
                                if (isset($lista_hoteles) && is_array($lista_hoteles)): 
                                    foreach ($lista_hoteles as $hotel):
                                ?>
                                    <option value="<?= htmlspecialchars($hotel['id_hotel']) ?>">
                                        <?= htmlspecialchars($hotel['nombre_hotel']) ?>
                                    </option>
                                <?php 
                                    endforeach; 
                                endif; 
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="user" style="margin-top:1rem;">Usuario</label>
                            <select id="user" name="email_usuario" required style="width:100%; margin-top:0.25rem; padding:0.5rem;">
                                <option value="">Selecciona un usuario</option>
                                <?php 
                                if (isset($lista_usuarios) && is_array($lista_usuarios)): 
                                    foreach ($lista_usuarios as $user):
                                ?>
                                    <option value="<?= htmlspecialchars($user['id_viajero']) ?>">
                                        <?= htmlspecialchars($user['nombre'])?>  <?= htmlspecialchars($user['apellido1'])?> <?= htmlspecialchars($user['apellido2'])?>
                                    </option>
                                <?php 
                                    endforeach; 
                                endif; 
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Numero de Viajeros</label>
                            <input type="number" min="1" max="20" class="form-control" name="num_viajeros" required>
                        </div>
                         <div class="mb-3">
                            <label for="veh" style="margin-top:1rem;">Vehículo</label>
                            <select id="veh" name="id_vehiculo" required style="width:100%; margin-top:0.25rem; padding:0.5rem;">
                                <option value="">Selecciona un vehículo</option>
                                <?php 
                                if (isset($lista_vehiculos) && is_array($lista_vehiculos)): 
                                    foreach ($lista_vehiculos as $veh):
                                ?>
                                    <option value="<?= htmlspecialchars($veh['id_vehiculo']) ?>">
                                        <?= htmlspecialchars($veh['Descripción'])?>
                                    </option>
                                <?php 
                                    endforeach; 
                                endif; 
                                ?>
                            </select>
                        </div>
                    </div>
                    <button type="submit" name="accion" value="crear_reserva" class="btn btn-primary w-100 py-3 mt-4">
                        Crear Reserva
                    </button>
                <?php endif; ?>
            </form>
        </div>
    </div> 
</div>

<hr class="my-5"> 
<div class="container mb-5">
    <h3 class="mb-4">Listado Reservas</h3>
    <div class="card shadow-sm">
        <div class="card-body p-0">

            <div class="table-responsive">
                <table class="table table-hover mb-0">
        
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">Localizador</th>
                            <th scope="col">Últ. Modificación</th>
                            <th scope="col">Tipo</th>
                            <th scope="col">Hotel</th>
                            <th scope="col">Cliente</th>
                            <th scope="col">Vehículo</th>
                            <th scope="col">Viajeros</th>
                            <th scope="col">Vuelo</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
        
                    <tbody>
                        <?php 
                            // 1. Comprueba si la variable de reservas existe y no está vacía
                            if (isset($lista_reservas) && !empty($lista_reservas)):
                            
                                // 2. Itera sobre cada reserva y crea una fila
                                foreach ($lista_reservas as $reserva): 
                                    $tipo = $reserva['tipo_reserva_desc'];
                                    $clase_fila = '';
            
                                    if (stripos($tipo, 'Ida y vuelta') !== false) {
                                        $clase_fila = 'table-info'; // Azul claro
                                    } elseif (stripos($tipo, 'Ida') !== false) {
                                        $clase_fila = 'table-success'; // Verde
                                    } else {
                                        $clase_fila = 'table-warning'; // Amarillo
                                    }
                        ?>
            
                            <tr class = "<?= $clase_fila ?>">
                                <th scope="row">
                                    <?= htmlspecialchars($reserva['localizador']) ?>
                                </th>
                                <td>
                                    <?= date('d/m/Y H:i', strtotime($reserva['fecha_modificacion'])) ?>
                                </td>
                                <td><?= htmlspecialchars($reserva['tipo_reserva_desc']) ?></td>
                                <td><?= htmlspecialchars($reserva['nombre_hotel']) ?></td>
                                <td><?= htmlspecialchars($reserva['email_cliente']) ?></td>
                                <td><?= htmlspecialchars($reserva['vehiculo_desc']) ?></td>
                                <td><?= htmlspecialchars($reserva['num_viajeros']) ?></td>
                                <td><?= htmlspecialchars($reserva['numero_vuelo_entrada']) ?></td>
                                <td>
                                    <a href="/adminpanel/editar?id=<?= $reserva['id_reserva'] ?>" class="btn btn-sm btn-warning">
                                        Editar
                                    </a>
                                    <a href="/adminpanel/eliminar?id=<?= $reserva['id_reserva'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro?');">
                                        Eliminar
                                    </a>
                                </td>
                            </tr>
                        <?php 
                                endforeach; // Fin del bucle
                        
                            else:
                        ?>
                            <tr>
                                <td colspan="9" class="text-center p-4">
                                    No se encontraron reservas.
                                </td>
                            </tr>
                        <?php 
                        endif; // Fin del if
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>



<?php require __DIR__ . '/layout/footer.php'; ?>
