<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['error'])) {
    echo '<p style="color: red; text-align: center; margin-top: 1rem;">' . htmlspecialchars($_SESSION['error']) . '</p>';
    unset($_SESSION['error']);
}
$isLoggedIn = isset($_SESSION['user_id']);
$user_id = $isLoggedIn ? $_SESSION['user_id'] : null;
$user_email = $isLoggedIn ? $_SESSION['email'] : null;
$rol = $isLoggedIn ? $_SESSION['user_rol'] : null;
$rol_requerido = 'particular';
$rol_admin = 'administrador';

if (!$isLoggedIn || $rol !== $rol_requerido) {
    
    
    if (!$isLoggedIn) {
        header('Location: /login');
        exit(); 
    }

    if ($rol !== $rol_requerido) {
    
        if ($rol === $rol_admin) {
            header('Location: /adminpanel');
            exit();
        
        } else {
            header('Location: /corporatepanel');
            exit();
        }
    }
}



$tipo_reserva = $_POST['id_tipo_reserva'] ?? null;

$today = new DateTime();

$future_date_unformat = clone $today;

$future_date_unformat->modify('+48 hours');

 $future_date = $future_date_unformat->format('Y-m-d')

?>

<?php require __DIR__ . '/layout/header.php'; ?>
<?php require __DIR__ . '/layout/navbar.php'; ?>

<div class="container my-5">
    <div class="row">
        <div class="col-lg-10 col-xl-8 mx-auto">
                
            <h2 class="mb-4">Panel de Usuario Particular</h2>
                
            <form action="/userpanel/reservar" method="POST">
                <input type="hidden" name="creador_id" value="<?php echo $user_id; ?>">

                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <h4 class="mb-3">Crear nueva reserva</h4>
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
                            <input type="date" class="form-control" name="fecha_entrada" min="<?php echo $future_date; ?>" required>
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
                            <input type="date" class="form-control" name="fecha_vuelo_salida" min="<?php echo $future_date; ?>" required>
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
                            <input type="text" class="form-control" name="email_usuario" disabled value = <?php echo $_SESSION['email'] ?>>
                            <input type="hidden" name="id_usuario" value="<?php echo $_SESSION['user_id'] ?>">
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
                            <th scope="col">Creada por</th>
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
                                    $reserva_pasada = false;

                                    if (stripos($tipo, 'Ida') !== false || stripos($tipo, 'Ida y vuelta') !== false) {
                                        if ($reserva['fecha_entrada'] < $future_date) {
                                            $reserva_pasada = true;
                                        }
                                    }
                                    if (stripos($tipo, 'Vuelta') !== false || stripos($tipo, 'Ida y vuelta') !== false) {
                                        if ($reserva['fecha_vuelo_salida'] < $future_date) {
                                            $reserva_pasada = true;
                                        }
                                    }
            
                                    if (stripos($tipo, 'Ida y vuelta') !== false) {
                                        $clase_fila = 'table-info'; // Azul claro
                                    } elseif (stripos($tipo, 'Ida') !== false) {
                                        $clase_fila = 'table-success'; // Verde
                                    } else {
                                        $clase_fila = 'table-warning'; // Amarillo
                                    }

                                    if ($reserva_pasada) {
                                        $clase_fila = 'table-secondary'; 
                                    }

                                    $collapseId = 'editRow-' . $reserva['id_reserva'];

                                    if($_SESSION['email'] == $reserva['email_cliente']):
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
                                <?php 
                                    $creador;
                                    if($reserva['email_creador'] == $user_email){
                                        $creador = "Tu";
                                    }else{
                                        $creador = "Admin";
                                    }
                                ?>
                                <td><?= htmlspecialchars($creador) ?></td>
                                <td class="d-flex gap-2">
                                    <a href="#<?= $collapseId ?>" data-bs-toggle="collapse" data-bs-target="#<?= $collapseId ?>" class="btn btn-sm btn-warning **flex-grow-1**">
                                        Editar
                                    </a>
                                    <a href="/adminpanel/eliminar?id=<?= $reserva['id_reserva'] ?>" class="btn btn-sm btn-danger **flex-grow-1** <?php echo $reserva_pasada ? 'disabled' : ''; ?>" onclick="return confirm('¿Estás seguro de querer cancelar esta reserva?');">
                                        Cancelar Reserva
                                    </a>
                                </td>
                            </tr>

                            <tr class="collapse" id="<?= $collapseId ?>">
                                <td colspan="9" class="p-0 border-0">
                                    <div class="p-3 bg-light border-top border-bottom">
                                        <h6 class="mb-3">
                                            Editando Reserva: <?= htmlspecialchars($reserva['localizador']) ?>
                                            <?php if ($reserva_pasada): ?>
                                                <span class="badge bg-danger">NO SE PUEDE MODIFICAR UNA RESERVA CUANDO FALTAN MENOS DE 48 HORAS O YA HA PASADO  - SOLO LECTURA</span>
                                            <?php endif; ?>
                                        </h6>

                                        <form action="/userpanel/editar" method="POST">
                                            <input type="hidden" name="id_reserva" value="<?= $reserva['id_reserva'] ?>">

                                            <div class="row g-3">
                                                <?php $readonly_attr = $reserva_pasada ? 'readonly disabled' : ''; ?>
                                                <div class="col-md-3">
                                                    <label class="form-label small">Localizador</label>
                                                    <input type="text" name="localizador" class="form-control form-control-sm" value="<?= htmlspecialchars($reserva['localizador']) ?>" readonly>
                                                </div>
                                                <?php if (stripos($tipo, 'Ida y vuelta') !== false || stripos($tipo, 'Ida') !== false): ?>
                                                    <div class="mb-3">
                                                        <label class="form-label">Día de Llegada</label>
                                                        <input type="date" class="form-control" name="fecha_entrada" value="<?= htmlspecialchars($reserva['fecha_entrada'])?>" min="<?php echo $future_date; ?>" <?php echo $readonly_attr; ?> required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Hora de Llegada</label>
                                                        <input type="time" class="form-control" name="hora_entrada" value="<?= htmlspecialchars($reserva['hora_entrada'])?>" <?php echo $readonly_attr; ?> required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Numero de Vuelo de Ida</label>
                                                        <input type="text" class="form-control" name="numero_vuelo_entrada" value="<?= htmlspecialchars($reserva['numero_vuelo_entrada'])?>" <?php echo $readonly_attr; ?> required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Aeropuerto de Origen</label>
                                                        <input type="text" class="form-control" name="origen_vuelo_entrada" value="<?= htmlspecialchars($reserva['origen_vuelo_entrada'])?>" <?php echo $readonly_attr; ?> required>
                                                    </div>
                                                <?php endif; ?>
                                                <?php if (stripos($tipo, 'Ida y vuelta') !== false || stripos($tipo, 'Vuelta') !== false): ?>
                                                    <div class="mb-3">
                                                        <label class="form-label">Día del Vuelo (Salida)</label>
                                                        <input type="date" class="form-control" name="fecha_vuelo_salida" value="<?= htmlspecialchars($reserva['fecha_vuelo_salida'])?>" min="<?php echo $future_date; ?>" <?php echo $readonly_attr; ?>" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Hora de Salida</label>
                                                        <input type="time" class="form-control" name="hora_vuelo_salida" value="<?= htmlspecialchars(date('H:i', strtotime($reserva['hora_vuelo_salida'] ?? ''))) ?>" <?php echo $readonly_attr; ?> required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Numero de Vuelo de Vuelta</label>
                                                        <input type="text" class="form-control" name="numero_vuelo_salida" value="<?= htmlspecialchars($reserva['numero_vuelo_entrada'])?>" <?php echo $readonly_attr; ?> required>
                                                    </div>
                                                <?php endif; ?>
                                                <!--
                                                <div class="mb-3">
                                                    <label class="form-label">Hora de Recogida</label>
                                                    <input type="time" class="form-control" name="---" required>
                                                </div>
                                                No exister en la base de datos
                                                -->
                                                <div class="mb-3">
                                                    <label for="hotel" style="margin-top:1rem;">Hotel</label>
                                                    <select id="hotel" name="id_hotel" required style="width:100%; margin-top:0.25rem; padding:0.5rem;" <?php echo $readonly_attr; ?>>
                                                        <option value="">Selecciona un hotel</option>
                                                        <?php
                                                        $hotel_actual_nombre = $reserva['nombre_hotel'] ?? null; 
                                                        if (isset($lista_hoteles) && is_array($lista_hoteles)): 
                                                            foreach ($lista_hoteles as $hotel):
                                                                $selected = ($hotel['nombre_hotel'] == $hotel_actual_nombre) ? 'selected' : '';
                                                        ?>
                                                            <option value="<?= htmlspecialchars($hotel['id_hotel']) ?>" <?= $selected ?>>
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
                                                    <select id="user" name="email_usuario" required style="width:100%; margin-top:0.25rem; padding:0.5rem;" disabled>
                                                        <option value="">Selecciona un usuario</option>
                                                        <?php
                                                        $usuario_email_actual = $reserva['email_cliente'] ?? null; 
                                                        if (isset($lista_usuarios) && is_array($lista_usuarios)): 
                                                            foreach ($lista_usuarios as $user):
                                                                $selected = ($user['email'] == $usuario_email_actual) ? 'selected' : '';
                                                        ?>
                                                            <option value="<?= htmlspecialchars($user['id_viajero']) ?>" <?= $selected ?>>
                                                                <?= htmlspecialchars($user['email'])?>
                                                            </option>
                                                        <?php 
                                                            endforeach; 
                                                        endif; 
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Numero de Viajeros</label>
                                                    <input type="number" min="1" max="20" class="form-control" name="num_viajeros" value="<?= htmlspecialchars($reserva['num_viajeros'])?>" <?php echo $readonly_attr; ?> required>
                                                </div>
                                                 <div class="mb-3">
                                                    <label for="veh" style="margin-top:1rem;">Vehículo</label>
                                                    <select id="veh" name="id_vehiculo" required style="width:100%; margin-top:0.25rem; padding:0.5rem;" <?php echo $readonly_attr; ?>>
                                                        <option value="">Selecciona un vehículo</option>
                                                        <?php
                                                        $vehiculo_actual = $reserva['vehiculo_desc'] ?? null;
                                                        if (isset($lista_vehiculos) && is_array($lista_vehiculos)): 
                                                            foreach ($lista_vehiculos as $veh):
                                                                $selected = ($veh['Descripción'] == $vehiculo_actual) ? 'selected' : '';
                                                        ?>
                                                            <option value="<?= htmlspecialchars($veh['id_vehiculo']) ?>"  <?= $selected ?>>
                                                                <?= htmlspecialchars($veh['Descripción'])?>
                                                            </option>
                                                        <?php 
                                                            endforeach; 
                                                        endif; 
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="mt-3">
                                                <button type="submit" class="btn btn-primary btn-sm me-2 <?php echo $reserva_pasada ? 'disabled' : ''; ?>">Guardar Cambios</button>
                                                <a href="#<?= $collapseId ?>" 
                                                   data-bs-toggle="collapse" 
                                                   data-bs-target="#<?= $collapseId ?>"
                                                   class="btn btn-secondary btn-sm">
                                                    Cerrar
                                                </a>
                                            </div>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php 
                                    endif;
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
