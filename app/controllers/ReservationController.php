<?php
require_once "app/models/ReservationModel.php";
require_once "app/models/AlojamientoModel.php";
require_once "app/models/AnfitrionModel.php";

class ReservationController
{
    // Metodo para obtener vista de formulario de reservacion o generar insert de esta
    public function crear_reservacion()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $id_user = $_SESSION['id_user'];
            $id_anfitrion = $_POST['id_anfitrion'];
            $id_alojamiento = $_POST['id_alojamiento'];
            $huespedes = $_POST['huespedes'];
            $fecha_ingreso = $_POST['fecha_entrada'];
            $fecha_salida = $_POST['fecha_salida'];
            $fecha_salida_real = $_POST['fecha_salida'];
            $metodo_pago = $_POST['metodo_pago'];
            $total_pago = $_POST['total_pago'];

            $alojamiento = new AlojamientoModel();
            $reservacion = new ReservationModel();
            $reservacionDisponible = $reservacion->AlojamientoDisponible($id_alojamiento, $fecha_ingreso, $fecha_salida);
            $alojamientoDisponible = $alojamiento->alojamientoDisponible($id_alojamiento); // Verifica qye el alojamiento no este eliminado

            // Validar si ya existe una reserva para el alojamiento
            if ($reservacionDisponible && $alojamientoDisponible) {

                // Crear la reservación si no interfieren las fechas
                $createReservacion = $reservacion->create_reservation($id_user, $id_anfitrion, $id_alojamiento, $huespedes, $fecha_ingreso, $fecha_salida, $fecha_salida_real, $metodo_pago, $total_pago);

                if ($createReservacion) {
                    header("Location: /" . $_SESSION['rootFolder'] . "/Alojamiento/getAlojamiento?id=$id_alojamiento&alert=success&message=" . urlencode("Reservación creada con éxito"));
                } else {
                    header("Location: /" . $_SESSION['rootFolder'] . "/Alojamiento/getAlojamiento?id=$id_alojamiento&alert=error&message=" . urlencode("Ocurrió un error al crear la reservación. Inténtalo más tarde"));
                }
            } else {
                header("Location: /" . $_SESSION['rootFolder'] . "/Reservation/crear_reservacion?alojamiento=$id_alojamiento&alert=error&message=" . urlencode("Ya existe una reservación para las fechas seleccionadas o el alojamiento pudo haber sido eliminado"));
                return;
            }
        } else {

            // Llamando a la vista de formulario de reservacion. Se pasan datos del alojamiento para presentar en la vista
            if (!isset($_GET['alojamiento'])) {
                header("Location: /" . $_SESSION['rootFolder'] . "/Home/index&alert=error&message=" . urlencode("Ocurrio un error al realizar la reservación o el alojamiento pudo haberse eliminado"));
                exit;
            }

            // Obteniendo variable 'alojamiento' desde la URL
            $id_alojamiento = $_GET['alojamiento'];

            $alojamiento = new AlojamientoModel();
            $infoAlojamiento = $alojamiento->getAlojamientoByID($id_alojamiento);

            $resModel = new ReservationModel();
            $reservedRanges = $resModel->getReservedDateRanges($id_alojamiento);

            require_once 'app/views/reservationForm.php';
        }
    }

    // Metodo para ver las reservaciones realizadas (Por usuario) y ver todas las reservaciones al admin y empleados
    public function reservaciones()
    {

        $reservacion = new ReservationModel();
        $reservaciones = $reservacion->getReservationsByUser($_SESSION['id_user']); // Muestra reservaciones al propio usuario
        $reservacionesAdmin = $reservacion->getAllReservaciones();                  // Muestra todas las reservaciones al admin y empleados
        require_once 'app/views/reservations.php';
    }

    // Metodo procesar la visualizacion de la vista del detalle del alojamiento
    public function post_reservacion_alojamiento()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if (isset($_POST['id_reservacion']) && isset($_POST['id_alojamiento'])) {
                $id_reservacion = $_POST['id_reservacion'];
                $id_alojamiento = $_POST['id_alojamiento'];

                header("Location: /" . $_SESSION['rootFolder'] . "/Reservation/detalle_reservacion?alojamiento=$id_alojamiento&reservacion=$id_reservacion");
                return;
            } else {
                header("Location: /" . $_SESSION['rootFolder'] . "/Reservation/reservaciones&alert=error&message=" . urlencode("Ocurrio un error al obtener la reservación."));
                return;
            }
        }
    }

    // Método para cargar la vista de detalle de reservación (Cliente y Administrador)
    public function detalle_reservacion()
    {
        if (!isset($_GET['reservacion'], $_GET['alojamiento'])) {
            header("Location: /" . $_SESSION['rootFolder'] . "/Reservation/reservaciones?alert=error&message=" . urlencode("Ocurrió un error al cargar la reservación o el alojamiento pudo haberse eliminado"));
            exit;
        }

        $id_reservacion = $_GET['reservacion'];
        $id_alojamiento = $_GET['alojamiento'];
        $id_user = $_SESSION['id_user'];
        $role_user = $_SESSION['user_role'];

        $reservacion = new ReservationModel();

        // Si no es administrador, comprobar que la reservación le pertenece
        if ($_SESSION['user_role'] !== 'administrador') {
            $reservacionCliente = $reservacion->getReservationSecure($id_reservacion, $id_alojamiento, $_SESSION['id_user']);
            if (!$reservacionCliente) {
                header("Location: /" . $_SESSION['rootFolder'] . "/Reservation/reservaciones?alert=error&message=" . urlencode("Reservación no encontrada"));
                exit;
            }
        } else {
            // Verificar que la reservación exista y coincida con el alojamiento (Para el ADMINISTRADOR y EMPLEADOS)
            $reservaExiste = $reservacion->getReservationByIdAndAlojamiento($id_reservacion, $id_alojamiento);
            if (!$reservaExiste) {
                header("Location: /" . $_SESSION['rootFolder'] . "/Reservation/reservaciones?alert=error&message=" . urlencode("Reservación no encontrada o no coincide con el alojamiento"));
                exit;
            }
        }

        $reservacionById = $reservacion->getReservationById($id_reservacion);

        $alojamiento = new AlojamientoModel();
        $anfitrion = new AnfitrionModel();

        $alojamientoById = $alojamiento->getAlojamientoByID($id_alojamiento);    // Informacion del alojamiento
        $anfitrionById = $anfitrion->anfitrionByAlojamientoID($id_alojamiento);  // Informacion del anfitrion
        $logReservacion = $reservacion->logReservacion($id_reservacion);         // Log de actualizaciones hechas a la reservacion (Administrador)

        require_once 'app/views/reservation_detail.php';
    }

    // Metodo para asignar estado a la reservacion de un cliente y un comentario
    public function asignar_reservacion()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $estado_reservacion = $_POST['estado-select'];
            $id_reservacion = $_POST['id_reservacion'];
            $comentario_input = trim($_POST['comentario_reservacion'] ?? '');
            $id_alojamiento = $_POST['id_alojamiento'];
            $fecha_salida_real = $_POST['fecha_salida_real'];

            // Comentario por defecto según estado
            if (empty($comentario_input)) {
                if ($estado_reservacion === 'confirmada') {
                    $comentario_input = 'Su reservación ha sido aceptada.';
                } elseif ($estado_reservacion === 'cancelada') {
                    $comentario_input = 'Su reservación ha sido rechazada. Para mayor información, comunicarse a nuestros contactos disponibles.';
                } else {
                    $comentario_input = 'Su estadía en el alojamiento ha finalizado. Puede calificar su servicio a continuación.';
                }
            }

            $reservacion = new ReservationModel();

            if ($estado_reservacion === 'completada') {
                $fecha_salida_real = $reservacion->updateFechaSalidaReal($id_reservacion, $fecha_salida_real);
            }

            // Actualizacion del estado en la tabla reservaciones
            $estadoActualizado = $reservacion->updateEstadoReservacion($id_reservacion, $estado_reservacion);

            // Registrar el comentario y el estado asociado en la tabla de log
            $comentarioAgregado = $reservacion->comentario_reservacion($id_reservacion, $_SESSION['id_user'], $estado_reservacion, $comentario_input);

            if ($estadoActualizado && $comentarioAgregado) {
                header("Location: /" . $_SESSION['rootFolder'] . "/Reservation/detalle_reservacion?alojamiento=$id_alojamiento&reservacion=$id_reservacion&alert=success&message=" . urlencode("Estado asignado a la reservación: $estado_reservacion"));
                exit;
            } else {
                header("Location: /" . $_SESSION['rootFolder'] . "/Reservation/detalle_reservacion?alojamiento=$id_alojamiento&reservacion=$id_reservacion&alert=error&message=" . urlencode("Ocurrió un error al procesar la asignación de la reservación"));
                exit;
            }
        }
    }

    // Metodo para que el usuario califique un alojamiento
    public function calificacionUsuario()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $id_reservacion = $_POST['id_reservacion'];
            $id_alojamiento = $_POST['id_alojamiento'];
            $comentario = isset($_POST['comentario']) ? trim($_POST['comentario']) : '';
            $calificacion = isset($_POST['calificacion']) ? intval($_POST['calificacion']) : 0;

            // Validar datos básicos
            if ($id_reservacion && $id_alojamiento && $calificacion >= 1 && $calificacion <= 5) {
                $reservacion = new ReservationModel();
                $reservacion->calificacionReservacionUser($id_reservacion, $comentario, $calificacion);

                // Redirige sin incluir comentario en la URL
                header("Location: /" . $_SESSION['rootFolder'] . "/Reservation/detalle_reservacion?alojamiento=$id_alojamiento&reservacion=$id_reservacion&alert=success&message=" . urlencode("Calificación enviada correctamente"));
                exit;
            } else {
                // Calificación inválida o datos incompletos
                header("Location: /" . $_SESSION['rootFolder'] . "/Reservation/detalle_reservacion?alojamiento=$id_alojamiento&reservacion=$id_reservacion&alert=error&message=" . urlencode("La puntuación debe estar entre 1 y 5"));
                exit;
            }
        }
    }
}
