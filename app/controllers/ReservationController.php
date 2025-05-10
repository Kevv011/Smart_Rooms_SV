<?php
require_once "app/models/ReservationModel.php";

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
            require_once 'app/views/reservationForm.php';
        }
    }

    // Metodo para ver las reservaciones realizadas (Por usuario)
    public function mis_reservaciones() {
        
    }
}
