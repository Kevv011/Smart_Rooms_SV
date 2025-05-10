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
            $metodo_pago = $_POST['metodo_pago'];
            $total_pago = $_POST['total_pago'];

            $reservacion = new ReservationModel();

            // Validar si ya existe una reserva para el mismo usuario y alojamiento
            if ($reservacion->verifyReservation($id_user, $id_alojamiento, $fecha_ingreso, $fecha_salida)) {
                header("Location: /" . $_SESSION['rootFolder'] . "/Alojamiento/getAlojamiento?id=$id_alojamiento&alert=error&message=" . urlencode("Ya tienes una reservación en este alojamiento para fechas que se cruzan. Elige otro rango de fechas."));
                return;
            }

            // Crear la reservación si no existe duplicado
            $createReservacion = $reservacion->create_reservation($id_user, $id_anfitrion, $id_alojamiento, $huespedes, $fecha_ingreso, $fecha_salida, $metodo_pago, $total_pago);

            if ($createReservacion) {
                header("Location: /" . $_SESSION['rootFolder'] . "/Alojamiento/getAlojamiento?id=$id_alojamiento&alert=success&message=" . urlencode("Reservación creada con éxito"));
            } else {
                header("Location: /" . $_SESSION['rootFolder'] . "/Alojamiento/getAlojamiento?id=$id_alojamiento&alert=error&message=" . urlencode("Ocurrió un error al crear la reservación. Inténtalo más tarde"));
            }
            return;
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

            require_once 'app/views/reservationForm.php';
        }
    }

    // Metodo para ver las reservaciones realizadas (Por usuario)
    public function mis_reservaciones()
    {

        $reservacion = new ReservationModel();
        $reservaciones = $reservacion->getReservationsByUser($_SESSION['id_user']);
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
                header("Location: /" . $_SESSION['rootFolder'] . "/Reservation/mis_reservaciones&alert=error&message=" . urlencode("Ocurrio un error al obtener la reservación."));
                return;
            }
        }
    }

    // Metodo para carga la vista de detalle de reservacion
    public function detalle_reservacion()
    {
        if (!isset($_GET['reservacion'], $_GET['alojamiento'])) {
            header("Location: /" . $_SESSION['rootFolder'] . "/Reservation/mis_reservaciones&alert=error&message=" . urlencode("Ocurrio un error al realizar la reservación o el alojamiento pudo haberse eliminado"));
            exit;
        }

        // Obteniendo el ID y la reservacion desde la URL
        $id_reservacion = $_GET['reservacion'];
        $id_alojamiento = $_GET['alojamiento'];

        $reservacion = new ReservationModel();
        $seguridadReservacion = $reservacion->getReservationSecure($id_reservacion, $id_alojamiento, $_SESSION['id_user']);

        if (!$seguridadReservacion) {
            header("Location: /" . $_SESSION['rootFolder'] . "/Reservation/mis_reservaciones&alert=error&message=" . urlencode("Reservacion no encontrada"));
            exit;
        }

        $alojamiento = new AlojamientoModel();
        $anfitrion = new AnfitrionModel();

        $reservacionById = $reservacion->getReservationById($id_reservacion);
        $alojamientoById = $alojamiento->getAlojamientoByID($id_alojamiento);
        $anfitrionById = $anfitrion->anfitrionByAlojamientoID($id_alojamiento);

        require_once 'app/views/reservation_detail.php';
    }
}
