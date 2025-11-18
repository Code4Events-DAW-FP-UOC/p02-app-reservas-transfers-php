<?php

/**
 * Controlador para la gestión de perfil de usuario (particular y administrador).
 * Permite editar los datos personales y cambiar la contraseña desde la vista de perfil.
 */
class UserController extends Controller
{
    /**
     * Muestra el dashboard del usuario autenticado.
     * Redirige a login si no hay sesión activa.
     *
     * @return void
     */
    public function dashboard()
    {
        // Solo permite acceso si el usuario está logueado
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (empty($_SESSION['user_id'])) {
            header('Location: /auth/login');
            exit;
        }
        // Carga la vista del dashboard
        $this->view('user/dashboard');
    }

    /**
     * Muestra y procesa el formulario de edición de perfil para el usuario autenticado.
     * Permite modificar datos personales.
     *
     * @return void
     * @throws Exception Si hay errores de validación en el modelo.
     */
    public function editarPerfil()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (empty($_SESSION['user_id'])) {
            header('Location: /auth/login');
            exit;
        }
        $error = null;
        $success = null;

        $userModel = $this->model('User');
        $usuario = $userModel->getById($_SESSION['user_id']);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = trim($_POST['nombre'] ?? '');
            $apellido1 = trim($_POST['apellido1'] ?? '');
            $apellido2 = trim($_POST['apellido2'] ?? '');
            $direccion = trim($_POST['direccion'] ?? '');
            $codigoPostal = trim($_POST['codigoPostal'] ?? '');
            $ciudad = trim($_POST['ciudad'] ?? '');
            $pais = trim($_POST['pais'] ?? '');

            // Validación básica
            if (!$nombre || !$apellido1) {
                $error = "El nombre y primer apellido son obligatorios.";
            } else {
                $nuevosDatos = [
                    'nombre' => $nombre,
                    'apellido1' => $apellido1,
                    'apellido2' => $apellido2,
                    'direccion' => $direccion,
                    'codigoPostal' => $codigoPostal,
                    'ciudad' => $ciudad,
                    'pais' => $pais,
                ];
                $ok = $userModel->update($_SESSION['user_id'], $nuevosDatos);

                if ($ok) {
                    $success = "Perfil actualizado correctamente.";
                    // Actualiza el nombre en la sesión
                    $_SESSION['user_name'] = $nombre;
                    // Refresca los datos del usuario para mostrar los cambios en la vista
                    $usuario = $userModel->getById($_SESSION['user_id']);
                } else {
                    $error = "Error al actualizar el perfil.";
                }
            }
        }

        // Carga la vista, pasando el usuario actual y los mensajes de éxito/error
        $this->view('user/editPerfil', [
            'usuario' => $usuario,
            'error' => $error,
            'success' => $success
        ]);
    }

    /**
     * Muestra y procesa el formulario de edición de contraseña para el usuario autenticado.
     * Permite modificar la contraseña.
     *
     * @return void
     * @throws Exception Si hay errores de validación en el modelo.
     */
    public function cambiarPassword()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (empty($_SESSION['user_id'])) {
            header('Location: /auth/login');
            exit;
        }
        $error = null;
        $success = null;

        $userModel = $this->model('User');
        $usuario = $userModel->getById($_SESSION['user_id']);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $password = $_POST['password'] ?? '';
            $confirm = $_POST['confirm_password'] ?? '';

            // Validación básica
            if (!empty($password) || !empty($confirm)) {
                if ($password !== $confirm) {
                    $error = "Las contraseñas no coinciden.";
                } elseif (strlen($password) < 6) {
                    $error = "La nueva contraseña debe tener al menos 6 caracteres.";
                } else {
                    $ok = $userModel->updatePassword($_SESSION['user_id'], $password);

                    if ($ok) {
                        $success = "Contraseña actualizada correctamente.";
                    } else {
                        $error = "Error al actualizar la contraseña.";
                    }
                }
            } else {
                $error = "La contraseña es un campo obligatorio.";
            }
        }

        // Carga la vista, pasando el usuario actual y los mensajes de éxito/error
        $this->view('user/cambiarPassword', [
            'usuario' => $usuario,
            'error' => $error,
            'success' => $success
        ]);
    }

    /**
     * Permite a un usuario particular crear una nueva reserva.
     * Valida que sea con al menos 48h de antelación y asocia el registro al usuario logueado.
     */
    public function nuevaReserva()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (empty($_SESSION['user_id'])) {
            header('Location: /auth/login');
            exit;
        }

        $error = null;
        $success = null;

        $tipoReservaModel = $this->model('TipoReserva');
        $hotelModel = $this->model('Hotel');
        $vehiculoModel = $this->model('Vehiculo');
        $reservaModel = $this->model('Reserva');

        $tiposReserva = $tipoReservaModel->getAll();
        $hoteles = $hotelModel->getAll();
        $vehiculos = $vehiculoModel->getAll();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Recoge los datos del formulario
            $id_tipo_reserva = $_POST['id_tipo_reserva'] ?? '';
            $id_hotel = null;
            $num_viajeros = $_POST['num_viajeros'] ?? 1;
            $id_vehiculo = $_POST['id_vehiculo'] ?? '';
            $id_viajero = $_SESSION['user_id'];
            $fecha_reserva = date('Y-m-d H:i:s');
            $fecha_modificacion = date('Y-m-d H:i:s');
            $fecha_entrada = $_POST['fecha_entrada'] ?? null;
            $hora_entrada = $_POST['hora_entrada'] ?? null;
            $numero_vuelo_entrada = $_POST['numero_vuelo_entrada'] ?? null;
            $origen_vuelo_entrada = $_POST['origen_vuelo_entrada'] ?? null;
            $fecha_vuelo_salida = $_POST['fecha_vuelo_salida'] ?? null;
            $hora_vuelo_salida = $_POST['hora_vuelo_salida'] ?? null;
            $numero_vuelo_salida = $_POST['numero_vuelo_salida'] ?? null;
            $hora_entrada_salida = $_POST['hora_entrada_salida'] ?? null;
            $id_destino = $_POST['id_hotel'] ?? '';


            // Validación de la fecha mínima (48 horas)
            $minDate = (new DateTime('+48 hours'))->format('Y-m-d');
            if (($id_tipo_reserva == '1' || $id_tipo_reserva == '3') && $fecha_entrada && $fecha_entrada < $minDate) {
                $error = "La fecha de llegada debe ser al menos 48h después de hoy.";
            } elseif (($id_tipo_reserva == '2' || $id_tipo_reserva == '3') && $fecha_vuelo_salida && $fecha_vuelo_salida < $minDate) {
                $error = "La fecha de salida debe ser al menos 48h después de hoy.";
            } else if (!$id_destino) {
                $error = "Debes seleccionar un hotel de destino o recogida.";
            } else {
                try {
                    $ok = $reservaModel->create([
                        'id_tipo_reserva' => $id_tipo_reserva,
                        'id_hotel' => $id_hotel,
                        'id_viajero' => $id_viajero,
                        'id_creador' => $_SESSION['user_id'],
                        'fecha_reserva' => $fecha_reserva,
                        'fecha_modificacion' => $fecha_modificacion,
                        'fecha_entrada' => $fecha_entrada,
                        'hora_entrada' => $hora_entrada,
                        'numero_vuelo_entrada' => $numero_vuelo_entrada,
                        'origen_vuelo_entrada' => $origen_vuelo_entrada,
                        'fecha_vuelo_salida' => $fecha_vuelo_salida,
                        'hora_vuelo_salida' => $hora_vuelo_salida,
                        'numero_vuelo_salida' => $numero_vuelo_salida,
                        'hora_entrada_salida' => $hora_entrada_salida,
                        'num_viajeros' => $num_viajeros,
                        'id_vehiculo' => $id_vehiculo,
                        'id_destino' => $id_destino,
                    ]);
                    if ($ok) {
                        $success = "¡Reserva creada correctamente!";
                    } else {
                        $error = "Error al crear la reserva. Intenta de nuevo.";
                    }
                } catch (Exception $ex) {
                    $error = $ex->getMessage();
                }
            }
        }

        $this->view('user/nuevaReserva', [
            'error' => $error,
            'success' => $success,
            'tiposReserva' => $tiposReserva,
            'hoteles' => $hoteles,
            'vehiculos' => $vehiculos,
        ]);
    }

    /**
     * Muestra la lista de reservas del usuario logueado
     * @return void
     */
    public function misReservas()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (empty($_SESSION['user_id'])) {
            header('Location: /auth/login');
            exit;
        }

        $reservaModel = $this->model('Reserva');
        $misReservas = $reservaModel->getByViajeroIdWithDetails($_SESSION['user_id']);

        $this->view('user/misReservas', [
            'reservas' => $misReservas
        ]);
    }

    /**
     * Muestra el detalle de una reserva para el usuario logueado
     * @param int $id_reserva
     */
    public function verDetallesReserva($id_reserva)
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (empty($_SESSION['user_id'])) {
            header('Location: /auth/login');
            exit;
        }

        $reservaModel = $this->model('Reserva');
        $reserva = $reservaModel->getByIdWithDetails($id_reserva);

        // Seguridad: solo deja ver reservas propias
        if (!$reserva || $reserva['id_viajero'] != $_SESSION['user_id']) {
            $reserva = null;
        }

        $this->view('user/verDetallesReserva', [
            'reserva' => $reserva
        ]);
    }

    /**
     * Borra una reserva del usuario autenticado.
     * Solo debe llamarse si la reserva es suya y cumple las condiciones.
     *
     * @param int $id_reserva
     */
    public function eliminarReserva($id_reserva)
    {

        if (session_status() === PHP_SESSION_NONE) session_start();
        if (empty($_SESSION['user_id'])) {
            header('Location: /auth/login');
            exit;
        }

        $user_id = $_SESSION['user_id'];
        $reservaModel = $this->model('Reserva');
        $reserva = $reservaModel->getById($id_reserva);

        // Seguridad extra: verificar que la reserva es del usuario logueado
        if ($reserva && $reserva['id_viajero'] == $user_id) {
            $reservaModel->delete($id_reserva);
            header('Location: /user/misreservas?success=eliminada');
            exit;
        }

        // Si no es suya, redirige igual (o podrías mostrar error)
        header('Location: /user/misReservas');
        exit;
    }

    /**
     * Permite editar una reserva propia si falta más de 48 horas.
     * @param int $id_reserva
     */
    public function editarReserva($id_reserva)
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (empty($_SESSION['user_id'])) {
            header('Location: /auth/login');
            exit;
        }

        $reservaModel = $this->model('Reserva');
        $tipoReservaModel = $this->model('TipoReserva');
        $hotelModel = $this->model('Hotel');
        $vehiculoModel = $this->model('Vehiculo');

        $reserva = $reservaModel->getById($id_reserva);

        // Solo puede editar sus propias reservas
        if (!$reserva || $reserva['id_viajero'] != $_SESSION['user_id']) {
            header('Location: /user/misreservas');
            exit;
        }

        // Solo permite editar si la reserva está a más de 48h
        $editable = true;
        if (!empty($reserva['fecha_entrada'])) {
            $fechaTrayecto = new DateTime($reserva['fecha_entrada']);
            $ahora = new DateTime();
            $editable = $fechaTrayecto->getTimestamp() - $ahora->getTimestamp() > 48 * 3600;
        }
        if (!$editable) {
            header('Location: /user/misreservas?error=No puedes editar reservas con menos de 48h de antelación.');
            exit;
        }

        $tiposReserva = $tipoReservaModel->getAll();
        $hoteles = $hotelModel->getAll();
        $vehiculos = $vehiculoModel->getAll();

        $error = null;
        $success = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nuevaReserva = [
                'id_tipo_reserva'      => $_POST['id_tipo_reserva'] ?? $reserva['id_tipo_reserva'],
                'id_hotel'             => $_POST['id_hotel'] ?? $reserva['id_hotel'],
                'id_viajero'           => $_SESSION['user_id'],
                'fecha_entrada'        => $_POST['fecha_entrada'] ?? null,
                'hora_entrada'         => $_POST['hora_entrada'] ?? null,
                'numero_vuelo_entrada' => $_POST['numero_vuelo_entrada'] ?? null,
                'origen_vuelo_entrada' => $_POST['origen_vuelo_entrada'] ?? null,
                'fecha_vuelo_salida'   => $_POST['fecha_vuelo_salida'] ?? null,
                'hora_vuelo_salida'    => $_POST['hora_vuelo_salida'] ?? null,
                'numero_vuelo_salida'  => $_POST['numero_vuelo_salida'] ?? null,
                'hora_entrada_salida'  => $_POST['hora_entrada_salida'] ?? null,
                'num_viajeros'         => $_POST['num_viajeros'] ?? $reserva['num_viajeros'],
                'id_vehiculo'          => $_POST['id_vehiculo'] ?? $reserva['id_vehiculo'],
                'id_destino'           => $_POST['id_hotel'] ?? $reserva['id_destino'],
            ];

            try {
                $ok = $reservaModel->update($id_reserva, $nuevaReserva);
                if ($ok) {
                    $success = "¡Reserva actualizada correctamente!";
                    // Recarga datos
                    $reserva = $reservaModel->getByIdWithDetails($id_reserva);
                } else {
                    $error = "No se pudo actualizar la reserva.";
                }
            } catch (Exception $e) {
                $error = $e->getMessage();
            }
        } else {
            // Al cargar, obtenemos los detalles (join descriptivo)
            $reserva = $reservaModel->getByIdWithDetails($id_reserva);
        }

        $this->view('user/editarReserva', [
            'reserva'      => $reserva,
            'error'        => $error,
            'success'      => $success,
            'tiposReserva' => $tiposReserva,
            'hoteles'      => $hoteles,
            'vehiculos'    => $vehiculos,
        ]);
    }
}
