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
            $reservacionDisponible = $reservacion->AlojamientoDisponible($id_alojamiento, $fecha_ingreso, $fecha_salida);

            // Validar si ya existe una reserva para el alojamiento
            if ($reservacionDisponible) {

                // Crear la reservación si no interfieren las fechas
                $createReservacion = $reservacion->create_reservation($id_user, $id_anfitrion, $id_alojamiento, $huespedes, $fecha_ingreso, $fecha_salida, $metodo_pago, $total_pago);

                if ($createReservacion) {
                    header("Location: /" . $_SESSION['rootFolder'] . "/Alojamiento/getAlojamiento?id=$id_alojamiento&alert=success&message=" . urlencode("Reservación creada con éxito"));
                } else {
                    header("Location: /" . $_SESSION['rootFolder'] . "/Alojamiento/getAlojamiento?id=$id_alojamiento&alert=error&message=" . urlencode("Ocurrió un error al crear la reservación. Inténtalo más tarde"));
                }
            } else {
                header("Location: /" . $_SESSION['rootFolder'] . "/Reservation/crear_reservacion?alojamiento=$id_alojamiento&alert=error&message=" . urlencode("Ya existe una reservación para las fechas seleccionadas. Elige otro rango de fechas según disponibilidad del alojamiento."));
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
    public function mis_reservaciones()
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
                header("Location: /" . $_SESSION['rootFolder'] . "/Reservation/mis_reservaciones&alert=error&message=" . urlencode("Ocurrio un error al obtener la reservación."));
                return;
            }
        }
    }

    // Método para cargar la vista de detalle de reservación (Cliente y Administrador)
    public function detalle_reservacion()
    {
        if (!isset($_GET['reservacion'], $_GET['alojamiento'])) {
            header("Location: /" . $_SESSION['rootFolder'] . "/Reservation/mis_reservaciones?alert=error&message=" . urlencode("Ocurrió un error al cargar la reservación o el alojamiento pudo haberse eliminado"));
            exit;
        }

        $id_reservacion = $_GET['reservacion'];
        $id_alojamiento = $_GET['alojamiento'];

        $reservacion = new ReservationModel();

        // Si no es administrador, comprobar que la reservación le pertenece
        if ($_SESSION['user_role'] !== 'administrador') {
            $reservacionCliente = $reservacion->getReservationSecure($id_reservacion, $id_alojamiento, $_SESSION['id_user']);
            if (!$reservacionCliente) {
                header("Location: /" . $_SESSION['rootFolder'] . "/Reservation/mis_reservaciones?alert=error&message=" . urlencode("Reservación no encontrada"));
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

        $alojamientoById = $alojamiento->getAlojamientoByID($id_alojamiento);
        $anfitrionById = $anfitrion->anfitrionByAlojamientoID($id_alojamiento);

        require_once 'app/views/reservation_detail.php';
    }
}
