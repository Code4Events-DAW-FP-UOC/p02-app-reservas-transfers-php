<?php

/**
 * Controlador para la gestión del panel de administración.
 * Solo accesible para usuarios con rol 'admin'.
 * Permite gestionar reservas, usuarios y otras opciones administrativas.
 */
class UserAdminController extends Controller
{
    /**
     * Verifica que el usuario autenticado sea administrador.
     * Redirige a /auth/login si no es admin.
     *
     * @return void
     */
    protected function requireAdmin()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (empty($_SESSION['user_id']) || ($_SESSION['user_rol'] ?? '') !== 'admin') {
            header('Location: /auth/login');
            exit;
        }
    }

    /**
     * Muestra el dashboard principal del panel de administración.
     * Aquí puedes incluir estadísticas o accesos rápidos.
     *
     * @return void
     */
    public function dashboard()
    {
        $this->requireAdmin();
        $this->view('userAdmin/dashboard');
    }

    // ==============================================
    // ================== RESERVAS ==================
    // ==============================================

    /**
     * Muestra el listado de reservas registradas.
     *
     * @return void
     */
    public function listadoReservas()
    {
        $this->requireAdmin();
        try {
            $reservaModel = $this->model('Reserva');
            //$reservas = $reservaModel->getAll(); // SOLO esto, sin detalles
            $reservas = $reservaModel->getAllWithDetails();
            //var_dump($reservas);
            //die;
        } catch (Exception $e) {
            $reservas = [];
            $error = "Error cargando las reservas: " . $e->getMessage();
        }

        $this->view('userAdmin/listadoReservas', [
            'reservas' => $reservas,
            'error' => $error ?? null
        ]);
    }

    public function editarReserva($id)
    {
        $this->requireAdmin();

        $reservaModel = new Reserva();
        $hotelModel = new Hotel();
        $viajeroModel = new User(); // O Viajero
        $tipoReservaModel = new TipoReserva();
        $vehiculoModel = new Vehiculo();

        // Recupera la reserva actual
        $reserva = $reservaModel->getById($id);
        if (!$reserva) {
            // Si no existe, redirige al listado
            header('Location: /userAdmin/listadoReservas');
            exit;
        }

        $error = null;
        $success = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Recoge los datos del formulario
            $data = [
                'id_hotel'              => $_POST['id_hotel'] ?? null,
                'id_tipo_reserva'       => $_POST['id_tipo_reserva'] ?? null,
                'id_viajero'            => $_POST['id_viajero'] ?? null,
                'fecha_reserva'         => $_POST['fecha_reserva'] ?? null,
                'fecha_modificacion'    => date('Y-m-d H:i:s'),
                'id_destino'            => $_POST['id_destino'] ?? null,
                'fecha_entrada'         => $_POST['fecha_entrada'] ?? null,
                'hora_entrada'          => $_POST['hora_entrada'] ?? null,
                'numero_vuelo_entrada'  => $_POST['numero_vuelo_entrada'] ?? null,
                'origen_vuelo_entrada'  => $_POST['origen_vuelo_entrada'] ?? null,
                'hora_vuelo_salida'     => $_POST['hora_vuelo_salida'] ?? null,
                'fecha_vuelo_salida'    => $_POST['fecha_vuelo_salida'] ?? null,
                'num_viajeros'          => $_POST['num_viajeros'] ?? null,
                'id_vehiculo'           => $_POST['id_vehiculo'] ?? null,
            ];

            try {
                // Validación y actualización
                $ok = $reservaModel->update($id, $data);
                if ($ok) {
                    $success = "¡Reserva actualizada correctamente!";
                    // Refresca los datos (para mostrar en la vista los cambios)
                    $reserva = $reservaModel->getById($id);
                } else {
                    $error = "No se ha podido actualizar la reserva.";
                }
            } catch (Exception $e) {
                $error = $e->getMessage();
            }
        }

        $this->view('userAdmin/editarReserva', [
            'reserva'      => $reserva,
            'hoteles'      => $hotelModel->getAll(),
            'tiposReserva' => $tipoReservaModel->getAll(),
            'viajeros'     => $viajeroModel->getAll(),
            'vehiculos'    => $vehiculoModel->getAll(),
            'error'        => $error,
            'success'      => $success,
        ]);
    }

    public function eliminarReserva($id)
    {
        $this->requireAdmin();
        $reservaModel = $this->model('Reserva');
        $ok = $reservaModel->delete($id);
        header('Location: /userAdmin/listadoReservas');
        exit;
    }

    /**
     * Muestra el formulario y procesa la creación de una nueva reserva.
     */
    public function nuevaReserva()
    {
        $this->requireAdmin();
        $error = null;
        $success = null;

        // Carga datos necesarios para mostrar el formulario (en GET o si hay error en POST)
        $userModel      = $this->model('User');
        $hotelModel     = $this->model('Hotel');
        $vehiculoModel  = $this->model('Vehiculo');
        $tipoReservaModel = $this->model('TipoReserva');

        $viajeros   = $userModel->getAll();
        $hoteles    = $hotelModel->getAll();
        $vehiculos  = $vehiculoModel->getAll();
        $tiposReserva = $tipoReservaModel->getAll();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $id_tipo_reserva = $_POST['id_tipo_reserva'] ?? '';
                $id_hotel        = null;
                $num_viajeros    = $_POST['num_viajeros'] ?? 1;
                $id_vehiculo     = $_POST['id_vehiculo'] ?? '';
                $id_viajero      = $_POST['id_viajero'] ?? '';
                $id_destino      = $_POST['id_hotel'] ?? '';

                // === Datos según tipo de reserva ===
                // Aeropuerto->Hotel
                $fecha_entrada       = $_POST['fecha_entrada'] ?? null;
                $hora_entrada        = $_POST['hora_entrada'] ?? null;
                $numero_vuelo_entrada = $_POST['numero_vuelo_entrada'] ?? null;
                $origen_vuelo_entrada = $_POST['origen_vuelo_entrada'] ?? null;

                // Hotel->Aeropuerto
                $fecha_vuelo_salida  = $_POST['fecha_vuelo_salida'] ?? null;
                $hora_vuelo_salida   = $_POST['hora_vuelo_salida'] ?? null;
                $numero_vuelo_salida = $_POST['numero_vuelo_salida'] ?? null;
                $hora_entrada_salida = $_POST['hora_entrada_salida'] ?? null; // Recogida

                // === Crear nuevo viajero si no se selecciona uno existente ===
                if (empty($id_viajero)) {
                    $nombre      = trim($_POST['nombre'] ?? '');
                    $apellido1   = trim($_POST['apellido1'] ?? '');
                    $apellido2   = trim($_POST['apellido2'] ?? '');
                    $email       = trim($_POST['email'] ?? '');
                    // Puedes añadir aquí otros campos como teléfono, etc.

                    if (!$nombre || !$apellido1 || !$email) {
                        throw new Exception('Los datos del nuevo viajero son obligatorios.');
                    }

                    // ¿Ya existe ese email?
                    $existe = $userModel->getByEmail($email);
                    if ($existe) {
                        $id_viajero = $existe['id_viajero'];
                    } else {
                        // Inserta el viajero con datos básicos. Rol por defecto: particular.
                        $ok = $userModel->create([
                            'nombre'       => $nombre,
                            'apellido1'    => $apellido1,
                            'apellido2'    => $apellido2,
                            'direccion'    => '', // Opcional
                            'codigoPostal' => '',
                            'ciudad'       => '',
                            'pais'         => '',
                            'email'        => $email,
                            'password'     => password_hash(uniqid(), PASSWORD_DEFAULT), // Genera una contraseña aleatoria para que no pueda acceder
                            'rol'          => 'particular'
                        ]);
                        if (!$ok) throw new Exception("No se pudo crear el viajero.");
                        $nuevoViajero = $userModel->getByEmail($email);
                        $id_viajero = $nuevoViajero['id_viajero'];
                    }
                }

                // ==== Preparar datos para la reserva ====
                $reserva = [
                    'id_tipo_reserva'       => $id_tipo_reserva,
                    'id_hotel'              => $id_hotel,
                    'id_viajero'            => $id_viajero,
                    'num_viajeros'          => $num_viajeros,
                    'id_vehiculo'           => $id_vehiculo,
                    'fecha_reserva'         => date('Y-m-d H:i:s'),
                    'fecha_modificacion'    => date('Y-m-d H:i:s'),
                    // Aeropuerto->Hotel:
                    'fecha_entrada'         => $fecha_entrada,
                    'hora_entrada'          => $hora_entrada,
                    'numero_vuelo_entrada'  => $numero_vuelo_entrada,
                    'origen_vuelo_entrada'  => $origen_vuelo_entrada,
                    // Hotel->Aeropuerto:
                    'fecha_vuelo_salida'    => $fecha_vuelo_salida,
                    'hora_vuelo_salida'     => $hora_vuelo_salida,
                    'numero_vuelo_salida'   => $numero_vuelo_salida,
                    'hora_entrada_salida'   => $hora_entrada_salida,
                    // Destino: en la BD tu campo puede llamarse distinto, revisa.
                    'id_destino'            => $id_destino,
                ];

                // === Lógica según tipo de reserva para validar y ajustar campos ===
                if ($id_tipo_reserva == 1) { // Aeropuerto→Hotel
                    if (!$fecha_entrada || !$hora_entrada || !$numero_vuelo_entrada || !$origen_vuelo_entrada) {
                        throw new Exception('Faltan datos para la reserva Aeropuerto→Hotel');
                    }
                }
                if ($id_tipo_reserva == 2) { // Hotel→Aeropuerto
                    if (!$fecha_vuelo_salida || !$hora_vuelo_salida || !$numero_vuelo_salida || !$hora_entrada_salida) {
                        throw new Exception('Faltan datos para la reserva Hotel→Aeropuerto');
                    }
                }
                if ($id_tipo_reserva == 3) { // Ida y vuelta
                    if (
                        !$fecha_entrada || !$hora_entrada || !$numero_vuelo_entrada || !$origen_vuelo_entrada ||
                        !$fecha_vuelo_salida || !$hora_vuelo_salida || !$numero_vuelo_salida || !$hora_entrada_salida
                    ) {
                        throw new Exception('Faltan datos para la reserva de ida y vuelta.');
                    }
                }

                // === Crear la reserva ===
                $reservaModel = $this->model('Reserva');
                $ok = $reservaModel->create($reserva);

                if ($ok) {
                    $success = "Reserva creada correctamente.";
                } else {
                    $error = "No se pudo crear la reserva.";
                }
            } catch (Exception $e) {
                $error = $e->getMessage();
            }
        }

        // Carga la vista, siempre pasando los arrays para los select
        $this->view('userAdmin/nuevaReserva', [
            'error'        => $error,
            'success'      => $success,
            'viajeros'     => $viajeros,
            'hoteles'      => $hoteles,
            'vehiculos'    => $vehiculos,
            'tiposReserva' => $tiposReserva,
        ]);
    }

    /**
     * Vista mensual del calendario
     */
    public function calendario()
    {
        $this->requireAdmin();

        $year = isset($_GET['year']) ? intval($_GET['year']) : date('Y');
        $month = isset($_GET['month']) ? intval($_GET['month']) : date('m');

        $fechaInicio = date('Y-m-01', strtotime("$year-$month-01"));
        $fechaFin = date('Y-m-t', strtotime($fechaInicio));

        $reservaModel = $this->model('Reserva');
        $reservas = $reservaModel->getReservasByRangoFechas($fechaInicio, $fechaFin);

        $this->view('userAdmin/calendario', [
            'reservas' => $reservas,
            'year' => $year,
            'month' => $month
        ]);
    }

    /**
     * Vista semanal del calendario
     */
    public function calendarioSemana()
    {
        $this->requireAdmin();

        $date = isset($_GET['fecha']) ? $_GET['fecha'] : date('Y-m-d');
        $timestamp = strtotime($date);
        $diaSemana = date('N', $timestamp); // 1=Lunes, 7=Domingo
        $fechaInicio = date('Y-m-d', strtotime("-" . ($diaSemana - 1) . " days", $timestamp));
        $fechaFin = date('Y-m-d', strtotime("+" . (7 - $diaSemana) . " days", $timestamp));

        $reservaModel = $this->model('Reserva');
        $reservas = $reservaModel->getReservasByRangoFechas($fechaInicio, $fechaFin);

        $this->view('userAdmin/calendarioSemana', [
            'reservas' => $reservas,
            'fechaInicio' => $fechaInicio,
            'fechaFin' => $fechaFin
        ]);
    }

    /**
     * Vista diaria del calendario
     */
    public function calendarioDia()
    {
        $this->requireAdmin();

        $fecha = isset($_GET['fecha']) ? $_GET['fecha'] : date('Y-m-d');

        $reservaModel = $this->model('Reserva');
        $reservas = $reservaModel->getReservasByRangoFechas($fecha, $fecha);

        $this->view('userAdmin/calendarioDia', [
            'reservas' => $reservas,
            'fecha' => $fecha
        ]);
    }
    // /**
    //  * Vista mensual de reservas
    //  */
    // public function calendario()
    // {
    //     $this->requireAdmin();

    //     // Por defecto, mostramos el mes actual
    //     $year = isset($_GET['year']) ? intval($_GET['year']) : date('Y');
    //     $month = isset($_GET['month']) ? intval($_GET['month']) : date('m');

    //     $fechaInicio = date('Y-m-01', strtotime("$year-$month-01"));
    //     $fechaFin = date('Y-m-t', strtotime($fechaInicio));
    //     $reservaModel = $this->model('Reserva');
    //     $reservas = $reservaModel->getReservasByRangoFechas($fechaInicio, $fechaFin);

    //     $this->view('userAdmin/calendario', [
    //         'reservas' => $reservas,
    //         'year' => $year,
    //         'month' => $month
    //     ]);
    // }

    // /**
    //  * Vista semanal de reservas
    //  */
    // public function calendarioSemana()
    // {
    //     $this->requireAdmin();

    //     // Semana actual (lunes a domingo)
    //     $date = isset($_GET['fecha']) ? $_GET['fecha'] : date('Y-m-d');
    //     $timestamp = strtotime($date);
    //     $diaSemana = date('N', $timestamp); // 1 (lunes) - 7 (domingo)
    //     $fechaInicio = date('Y-m-d', strtotime("-" . ($diaSemana - 1) . " days", $timestamp));
    //     $fechaFin = date('Y-m-d', strtotime("+" . (7 - $diaSemana) . " days", $timestamp));

    //     $reservaModel = $this->model('Reserva');
    //     $reservas = $reservaModel->getReservasByRangoFechas($fechaInicio, $fechaFin);

    //     $this->view('userAdmin/calendarioSemana', [
    //         'reservas' => $reservas,
    //         'fechaInicio' => $fechaInicio,
    //         'fechaFin' => $fechaFin
    //     ]);
    // }

    // /**
    //  * Vista diaria de reservas
    //  */
    // public function calendarioDia()
    // {
    //     $this->requireAdmin();

    //     $fecha = isset($_GET['fecha']) ? $_GET['fecha'] : date('Y-m-d');

    //     $reservaModel = $this->model('Reserva');
    //     $reservas = $reservaModel->getReservasByRangoFechas($fecha, $fecha);

    //     $this->view('userAdmin/calendarioDia', [
    //         'reservas' => $reservas,
    //         'fecha' => $fecha
    //     ]);
    // }

    /**
     * Detalle de una reserva concreta
     */
    public function verReserva($id)
    {
        $this->requireAdmin();

        $reservaModel = $this->model('Reserva');
        $reserva = $reservaModel->getByIdWithDetails($id);

        if (!$reserva) {
            $error = "No se ha encontrado la reserva.";
            $this->view('userAdmin/verReserva', ['error' => $error]);
            return;
        }

        $this->view('userAdmin/verReserva', ['reserva' => $reserva]);
    }

    // ==============================================
    // ================== USUARIOS ==================
    // ==============================================

    /**
     * Muestra el listado de usuarios en el panel de administración.
     */
    public function listadoUsuarios()
    {
        $this->requireAdmin();
        $userModel = $this->model('User');
        $usuarios = $userModel->getAll();
        $this->view('userAdmin/listadoUsuarios', ['usuarios' => $usuarios]);
    }

    /**
     * Edita los datos de un usuario por su ID.
     * Muestra el formulario (GET) y procesa los cambios (POST).
     * @param int $id
     */
    public function editarUsuario($id)
    {
        $this->requireAdmin();
        $userModel = $this->model('User');
        $usuario = $userModel->getById($id);

        if (!$usuario) {
            // Si no existe, redirige o muestra error.
            header('Location: /userAdmin/listadoUsuarios');
            exit;
        }

        $error = null;
        $success = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Recoge datos del formulario
            $nombre = trim($_POST['nombre'] ?? '');
            $apellido1 = trim($_POST['apellido1'] ?? '');
            $apellido2 = trim($_POST['apellido2'] ?? '');
            $direccion = trim($_POST['direccion'] ?? '');
            $codigoPostal = trim($_POST['codigoPostal'] ?? '');
            $ciudad = trim($_POST['ciudad'] ?? '');
            $pais = trim($_POST['pais'] ?? '');
            $rol = $_POST['rol'] ?? 'particular';
            $password = $_POST['password'] ?? null;
            $confirm = $_POST['confirm'] ?? null;

            // Validación básica
            if (!$nombre || !$apellido1) {
                $error = "El nombre y primer apellido son obligatorios.";
            } elseif ($password && $password !== $confirm) {
                $error = "Las contraseñas no coinciden.";
            } else {
                // Construye el array para update
                $datosUpdate = [
                    'nombre' => $nombre,
                    'apellido1' => $apellido1,
                    'apellido2' => $apellido2,
                    'direccion' => $direccion,
                    'codigoPostal' => $codigoPostal,
                    'ciudad' => $ciudad,
                    'pais' => $pais,
                    'email' => $usuario['email'], // El email no se debe cambiar aquí por seguridad
                    'rol' => $rol,
                ];
                if ($password) {
                    $datosUpdate['password'] = $password;
                }
                try {
                    $ok = $userModel->update($id, $datosUpdate);
                    if ($ok) {
                        $success = "Usuario actualizado correctamente.";
                        $usuario = $userModel->getById($id); // Refresca datos
                    } else {
                        $error = "Error al actualizar el usuario.";
                    }
                } catch (Exception $e) {
                    $error = $e->getMessage();
                }
            }
        }

        $this->view('userAdmin/editarUsuario', [
            'usuario' => $usuario,
            'error' => $error,
            'success' => $success
        ]);
    }

    /**
     * Elimina un usuario por su ID.
     * @param int $id
     */
    public function eliminarUsuario($id)
    {
        $this->requireAdmin();
        $userModel = $this->model('User');

        try {
            $ok = $userModel->delete($id);
            if ($ok) {
                $_SESSION['success'] = "Usuario eliminado correctamente.";
            }
        } catch (Exception $e) {
            $_SESSION['error'] = $e->getMessage();
        }

        header('Location: /userAdmin/listadoUsuarios');
        exit;
    }

    /**
     * Muestra y procesa el formulario para crear un usuario (particular/admin).
     */
    public function nuevoUsuario()
    {
        $this->requireAdmin();
        $error = null;
        $success = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = trim($_POST['nombre'] ?? '');
            $apellido1 = trim($_POST['apellido1'] ?? '');
            $apellido2 = trim($_POST['apellido2'] ?? '');
            $direccion = trim($_POST['direccion'] ?? '');
            $codigoPostal = trim($_POST['codigoPostal'] ?? '');
            $ciudad = trim($_POST['ciudad'] ?? '');
            $pais = trim($_POST['pais'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $rol = $_POST['rol'] ?? 'particular';
            $password = $_POST['password'] ?? '';
            $confirm = $_POST['confirm'] ?? '';

            if (!$nombre || !$apellido1 || !$email || !$password || !$confirm) {
                $error = "Por favor, rellena todos los campos obligatorios.";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = "Correo electrónico inválido.";
            } elseif ($password !== $confirm) {
                $error = "Las contraseñas no coinciden.";
            } else {
                $userModel = $this->model('User');
                try {
                    $ok = $userModel->create([
                        'nombre' => $nombre,
                        'apellido1' => $apellido1,
                        'apellido2' => $apellido2,
                        'direccion' => $direccion,
                        'codigoPostal' => $codigoPostal,
                        'ciudad' => $ciudad,
                        'pais' => $pais,
                        'email' => $email,
                        'password' => $password,
                        'rol' => $rol,
                    ]);
                    if ($ok) {
                        $success = "Usuario creado correctamente.";
                    } else {
                        $error = "Error al crear el usuario.";
                    }
                } catch (Exception $e) {
                    $error = $e->getMessage();
                }
            }
        }

        $this->view('userAdmin/nuevoUsuario', ['error' => $error, 'success' => $success]);
    }

    // =============================================
    // ================== HOTELES ==================
    // =============================================

    /**
     * Muestra el listado de todos los hoteles.
     */
    public function listadoHoteles()
    {
        $this->requireAdmin();
        $hotelModel = $this->model('Hotel');
        $hoteles = $hotelModel->getAll();
        $this->view('userAdmin/listadoHoteles', ['hoteles' => $hoteles]);
    }

    /**
     * Edita un hotel por su ID.
     * @param int $id
     */
    public function editarHotel($id)
    {
        $this->requireAdmin();
        $hotelModel = $this->model('Hotel');
        $zonaModel = $this->model('Zona');

        $hotel = $hotelModel->getById($id);
        $zonas = $zonaModel->getAll();
        if (!$hotel) {
            header('Location: /userAdmin/listadoHoteles');
            exit;
        }
        $error = null;
        $success = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = trim($_POST['nombre'] ?? '');
            $id_zona = $_POST['id_zona'] ?? null;
            $comision = $_POST['comision'] ?? 0;
            $usuario = trim($_POST['usuario'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? null;
            $confirm = $_POST['confirm'] ?? null;

            if (!$nombre || !$id_zona || !$usuario || !$email) {
                $error = "Todos los campos obligatorios deben estar completos.";
            } elseif ($password && $password !== $confirm) {
                $error = "Las contraseñas no coinciden.";
            } else {
                $datosUpdate = [
                    'nombre' => $nombre,
                    'id_zona' => $id_zona,
                    'comision' => $comision,
                    'usuario' => $usuario,
                    'email' => $email
                ];
                if ($password) {
                    $datosUpdate['password'] = $password;
                }
                try {
                    $ok = $hotelModel->update($id, $datosUpdate);
                    if ($ok) {
                        $success = "Hotel actualizado correctamente.";
                        $hotel = $hotelModel->getById($id); // Refresca datos
                    } else {
                        $error = "Error al actualizar el hotel.";
                    }
                } catch (Exception $e) {
                    $error = $e->getMessage();
                }
            }
        }

        $this->view('userAdmin/editarHotel', [
            'hotel' => $hotel,
            'zonas' => $zonas,
            'error' => $error,
            'success' => $success
        ]);
    }

    /**
     * Elimina un hotel por su ID.
     * @param int $id
     */
    public function eliminarHotel($id)
    {
        $this->requireAdmin();
        $hotelModel = $this->model('Hotel');
        try {
            $ok = $hotelModel->delete($id);
            if ($ok) {
                $_SESSION['success'] = "Hotel eliminado correctamente.";
            }
        } catch (Exception $e) {
            // Guarda el mensaje en la sesión para mostrar en la vista de listado
            $_SESSION['error'] = $e->getMessage();
        }
        header('Location: /userAdmin/listadoHoteles');
        exit;
    }

    /**
     * Muestra y procesa el formulario para crear un hotel.
     */
    public function nuevoHotel()
    {
        $this->requireAdmin();
        $error = null;
        $success = null;
        $zonaModel = $this->model('Zona');
        $zonas = $zonaModel->getAll();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = trim($_POST['nombre'] ?? '');
            $id_zona = $_POST['id_zona'] ?? '';
            $usuario = trim($_POST['usuario'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $comision = $_POST['comision'] ?? 0;
            $password = $_POST['password'] ?? '';
            $confirm = $_POST['confirm'] ?? '';

            if (!$nombre || !$id_zona || !$usuario || !$email || !$password || !$confirm) {
                $error = "Todos los campos obligatorios deben completarse.";
            } elseif ($password !== $confirm) {
                $error = "Las contraseñas no coinciden.";
            } else {
                $hotelModel = $this->model('Hotel');
                try {
                    $ok = $hotelModel->create([
                        'nombre' => $nombre,
                        'id_zona' => $id_zona,
                        'comision' => $comision,
                        'usuario' => $usuario,
                        'email' => $email,
                        'password' => $password,
                    ]);
                    if ($ok) {
                        $success = "Hotel creado correctamente.";
                    } else {
                        $error = "Error al crear el hotel.";
                    }
                } catch (Exception $e) {
                    $error = $e->getMessage();
                }
            }
        }

        $this->view('userAdmin/nuevoHotel', ['error' => $error, 'success' => $success, 'zonas' => $zonas]);
    }

    // ===============================================
    // ================== VEHÍCULOS ==================
    // ===============================================

    /**
     * Muestra el listado de todos los hoteles.
     */
    public function listadoVehiculos()
    {
        $this->requireAdmin();
        $vehiculoModel = $this->model('Vehiculo');
        $vehiculos = $vehiculoModel->getAll();
        $this->view('userAdmin/listadoVehiculos', ['vehiculos' => $vehiculos]);
    }

    /**
     * Edita un vehñiculo por su ID.
     * @param int $id
     */
    public function editarVehiculo($id)
    {
        $this->requireAdmin();
        $vehiculoModel = $this->model('Vehiculo');
        $vehiculo = $vehiculoModel->getById($id);
        $error = null;
        $success = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $datos = [
                'descripcion' => trim($_POST['descripcion'] ?? ''),
                'email_conductor' => trim($_POST['email_conductor'] ?? ''),
                'password' => $_POST['password'] ?? ''
            ];
            try {
                $vehiculoModel->update($id, $datos);
                $success = "Vehículo actualizado correctamente.";
                $vehiculo = $vehiculoModel->getById($id);
            } catch (Exception $e) {
                $error = $e->getMessage();
            }
        }

        $this->view('userAdmin/editarVehiculo', ['vehiculo' => $vehiculo, 'error' => $error, 'success' => $success]);
    }

    /**
     * Elimina un vehiculo por su ID.
     * @param int $id
     */
    public function eliminarVehiculo($id)
    {
        $this->requireAdmin();
        $vehiculoModel = $this->model('Vehiculo');
        try {
            $vehiculoModel->delete($id);
            $_SESSION['success'] = "Vehículo eliminado correctamente.";
        } catch (Exception $e) {
            $_SESSION['error'] = $e->getMessage();
        }
        header('Location: /userAdmin/listadoVehiculos');
        exit;
    }

    /**
     * Muestra y procesa el formulario para crear un vehículo.
     */
    public function nuevoVehiculo()
    {
        $this->requireAdmin();
        $error = null;
        $success = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $descripcion = trim($_POST['descripcion'] ?? '');
            $email_conductor = trim($_POST['email_conductor'] ?? '');
            $password = $_POST['password'] ?? '';
            $confirm = $_POST['confirm'] ?? '';

            if (!$descripcion || !$email_conductor || !$password || !$confirm) {
                $error = "Completa todos los campos obligatorios.";
            } elseif ($password !== $confirm) {
                $error = "Las contraseñas no coinciden.";
            } else {
                $vehiculoModel = $this->model('Vehiculo');
                try {
                    $ok = $vehiculoModel->create([
                        'descripcion' => $descripcion,
                        'email_conductor' => $email_conductor,
                        'password' => $password,
                    ]);
                    if ($ok) {
                        $success = "Vehículo creado correctamente.";
                    } else {
                        $error = "Error al crear el vehículo.";
                    }
                } catch (Exception $e) {
                    $error = $e->getMessage();
                }
            }
        }

        $this->view('userAdmin/nuevoVehiculo', ['error' => $error, 'success' => $success]);
    }

    // ===================================================
    // ================== TIPOS RESERVA ==================
    // ===================================================

    /**
     * Muestra el listado de todos los tipos de reserva.
     */
    public function listadoTiposReservas()
    {
        $this->requireAdmin();
        $tipoReservaModel = $this->model('TipoReserva');
        $tipoReservas = $tipoReservaModel->getAll();
        $this->view('userAdmin/listadoTipoReservas', ['tipoReservas' => $tipoReservas]);
    }

    /**
     * Muestra y procesa el formulario para editar un tipo de reserva.
     * @param int $id ID del tipo de reserva a editar.
     * @return void
     */
    public function editarTipoReserva($id)
    {
        $this->requireAdmin();

        $tipoReservaModel = $this->model('TipoReserva');
        $error = null;
        $success = null;

        // Obtiene los datos actuales
        $tipoReserva = $tipoReservaModel->getById($id);

        if (!$tipoReserva) {
            $error = "Tipo de reserva no encontrado.";
            $this->view('userAdmin/editarTipoReserva', compact('error'));
            return;
        }

        // Si se envía el formulario
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $descripcion = trim($_POST['descripcion'] ?? '');

            if (empty($descripcion)) {
                $error = "La descripción es obligatoria.";
            } else {
                try {
                    $ok = $tipoReservaModel->update($id, ['descripcion' => $descripcion]);
                    if ($ok) {
                        $success = "Tipo de reserva actualizado correctamente.";
                        $tipoReserva = $tipoReservaModel->getById($id); // refresca datos
                    } else {
                        $error = "Error al actualizar tipo de reserva.";
                    }
                } catch (Exception $e) {
                    $error = $e->getMessage();
                }
            }
        }

        $this->view('userAdmin/editarTipoReserva', [
            'tipoReserva' => $tipoReserva,
            'error' => $error,
            'success' => $success
        ]);
    }

    /**
     * Elimina un tipo de reserva por su ID.
     * @param int $id
     */
    public function eliminarTipoReserva($id)
    {
        $this->requireAdmin();
        $tipoReservaModel = $this->model('Hotel');
        try {
            $ok = $tipoReservaModel->delete($id);
            if ($ok) {
                $_SESSION['success'] = "Tipo reserva eliminado correctamente.";
            }
        } catch (Exception $e) {
            // Guarda el mensaje en la sesión para mostrar en la vista de listado
            $_SESSION['error'] = $e->getMessage();
        }
        header('Location: /userAdmin/listadoTipoReserva');
        exit;
    }

    /**
     * Muestra y procesa el formulario para crear un tipo de reserva.
     */
    public function nuevoTipoReserva()
    {
        $this->requireAdmin();
        $error = null;
        $success = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $descripcion = trim($_POST['descripcion'] ?? '');

            if (!$descripcion) {
                $error = "La descripción es obligatoria.";
            } else {
                $tipoReservaModel = $this->model('TipoReserva');
                try {
                    $ok = $tipoReservaModel->create(['descripcion' => $descripcion]);
                    if ($ok) {
                        $success = "Tipo de reserva creado correctamente.";
                    } else {
                        $error = "Error al crear el tipo de reserva.";
                    }
                } catch (Exception $e) {
                    $error = $e->getMessage();
                }
            }
        }

        $this->view('userAdmin/nuevoTipoReserva', ['error' => $error, 'success' => $success]);
    }

    // ==========================================
    // ================== ZONA ==================
    // ==========================================

    /**
     * Muestra el listado de todas las zonas.
     */
    public function listadoZonas()
    {
        $this->requireAdmin();
        $zonaModel = $this->model('Zona');
        $zonas = $zonaModel->getAll();
        $this->view('userAdmin/listadoZonas', ['zonas' => $zonas]);
    }

    /**
     * Muestra y procesa el formulario para editar una zona.
     * @param int $id ID de la zona a editar.
     * @return void
     */
    public function editarZona($id)
    {
        $this->requireAdmin();

        $zonaModel = $this->model('Zona');
        $error = null;
        $success = null;

        $zona = $zonaModel->getById($id);

        if (!$zona) {
            $error = "Zona no encontrada.";
            $this->view('userAdmin/editarZona', compact('error'));
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $descripcion = trim($_POST['descripcion'] ?? '');

            if (empty($descripcion)) {
                $error = "La descripción es obligatoria.";
            } else {
                try {
                    $ok = $zonaModel->update($id, ['descripcion' => $descripcion]);
                    if ($ok) {
                        $success = "Zona actualizada correctamente.";
                        $zona = $zonaModel->getById($id);
                    } else {
                        $error = "Error al actualizar la zona.";
                    }
                } catch (Exception $e) {
                    $error = $e->getMessage();
                }
            }
        }

        $this->view('userAdmin/editarZona', [
            'zona' => $zona,
            'error' => $error,
            'success' => $success
        ]);
    }


    /**
     * Elimina una zona por su ID.
     * @param int $id
     */
    public function eliminarZona($id)
    {
        $this->requireAdmin();
        $zonalModel = $this->model('Zona');
        try {
            $ok = $zonalModel->delete($id);
            if ($ok) {
                $_SESSION['success'] = "Hzona eliminada correctamente.";
            }
        } catch (Exception $e) {
            // Guarda el mensaje en la sesión para mostrar en la vista de listado
            $_SESSION['error'] = $e->getMessage();
        }
        header('Location: /userAdmin/listadoZonas');
        exit;
    }

    /**
     * Muestra y procesa el formulario para crear una zona.
     */
    public function nuevaZona()
    {
        $error = null;
        $success = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $descripcion = trim($_POST['descripcion'] ?? '');

            if (!$descripcion) {
                $error = "La descripción es obligatoria.";
            } else {
                $zonaModel = $this->model('Zona');
                try {
                    $ok = $zonaModel->create(['descripcion' => $descripcion]);
                    if ($ok) {
                        $success = "Zona creada correctamente.";
                    } else {
                        $error = "Error al crear la zona.";
                    }
                } catch (Exception $e) {
                    $error = $e->getMessage();
                }
            }
        }

        $this->view('userAdmin/nuevaZona', ['error' => $error, 'success' => $success]);
    }

    // =============================================
    // ================== PRECIOS ==================
    // =============================================

    /**
     * Muestra el listado de todos los precios.
     */
    public function listadoPrecios()
    {
        $this->requireAdmin();
        $precioModel = $this->model('Precio');
        $precios = $precioModel->getAll();
        $this->view('userAdmin/listadoPrecios', ['precios' => $precios]);
    }

    /**
     * Muestra y procesa el formulario para editar un precio.
     * @param int $id ID del precio a editar.
     * @return void
     */
    public function editarPrecio($id)
    {
        $this->requireAdmin();

        $preciosModel = $this->model('Precios');
        $error = null;
        $success = null;

        $precio = $preciosModel->getById($id);

        if (!$precio) {
            $error = "Precio no encontrado.";
            $this->view('userAdmin/editarPrecio', compact('error'));
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_hotel = trim($_POST['id_hotel'] ?? '');
            $id_vehiculo = trim($_POST['id_vehiculo'] ?? '');
            $precioNuevo = trim($_POST['precio'] ?? '');

            if (empty($id_hotel) || empty($id_vehiculo) || empty($precioNuevo)) {
                $error = "Todos los campos son obligatorios.";
            } elseif (!is_numeric($precioNuevo) || $precioNuevo < 0) {
                $error = "El precio debe ser un número positivo.";
            } else {
                try {
                    $ok = $preciosModel->update($id, [
                        'id_hotel' => $id_hotel,
                        'id_vehiculo' => $id_vehiculo,
                        'precio' => $precioNuevo
                    ]);
                    if ($ok) {
                        $success = "Precio actualizado correctamente.";
                        $precio = $preciosModel->getById($id);
                    } else {
                        $error = "Error al actualizar el precio.";
                    }
                } catch (Exception $e) {
                    $error = $e->getMessage();
                }
            }
        }

        $this->view('userAdmin/editarPrecio', [
            'precio' => $precio,
            'error' => $error,
            'success' => $success
        ]);
    }

    /**
     * Elimina un precio por su ID.
     * @param int $id
     */
    public function eliminarPrecio($id)
    {
        $this->requireAdmin();
        $precioModel = $this->model('Hotel');
        try {
            $ok = $precioModel->delete($id);
            if ($ok) {
                $_SESSION['success'] = "Precio eliminado correctamente.";
            }
        } catch (Exception $e) {
            // Guarda el mensaje en la sesión para mostrar en la vista de listado
            $_SESSION['error'] = $e->getMessage();
        }
        header('Location: /userAdmin/listadoPrecio');
        exit;
    }

    /**
     * Muestra y procesa el formulario para crear un precio.
     */
    public function nuevoPrecio()
    {
        $this->requireAdmin();
        $error = null;
        $success = null;

        $vehiculoModel = $this->model('Vehiculo');
        $hotelModel = $this->model('Hotel');
        $vehiculos = $vehiculoModel->getAll();
        $hoteles = $hotelModel->getAll();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_vehiculo = $_POST['id_vehiculo'] ?? '';
            $id_hotel = $_POST['id_hotel'] ?? '';
            $precio = $_POST['precio'] ?? '';

            if (!$id_vehiculo || !$id_hotel || $precio === '') {
                $error = "Completa todos los campos obligatorios.";
            } else {
                $preciosModel = $this->model('Precios');
                try {
                    $ok = $preciosModel->create([
                        'id_vehiculo' => $id_vehiculo,
                        'id_hotel' => $id_hotel,
                        'precio' => $precio,
                    ]);
                    if ($ok) {
                        $success = "Precio creado correctamente.";
                    } else {
                        $error = "Error al crear el precio.";
                    }
                } catch (Exception $e) {
                    $error = $e->getMessage();
                }
            }
        }

        $this->view('userAdmin/nuevoPrecio', [
            'error' => $error,
            'success' => $success,
            'vehiculos' => $vehiculos,
            'hoteles' => $hoteles,
        ]);
    }
}
