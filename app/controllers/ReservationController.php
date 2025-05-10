<?php
require_once "app/models/AlojamientoModel.php";
require_once "app/models/AnfitrionModel.php";
require_once "app/models/ReservationModel.php";

class ReservationController
{
    public function crear_reservacion()
    {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        } else {

            $alojamiento = new AlojamientoModel();
            $infoAlojamiento = $alojamiento->getAlojamientoByID(1);
            require_once 'app/views/reservationForm.php';
        }
    }
}
