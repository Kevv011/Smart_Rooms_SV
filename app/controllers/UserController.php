<?php
require_once "app/models/UserModel.php";

class UserController
{
    public function anfitrion()
    {
        if (!isset($_GET['id'])) {
            echo "ID no proporcionado.";
            return;
        }

        $idAlojamiento = $_GET['id']; // Id obtenido con GET

        $userModel = new UserModel();
        $userAnfitrion = $userModel->anfitrionByAlojamientoID($idAlojamiento); // Metodo para obtener al anfitrion por el id del alojamiento        

        if (!$userAnfitrion) {
            echo "El anfitrión no existe o el alojamiento fue eliminado.";
            return;
        }

        // Mostrar la vista con la informacion de anfitrion
        require_once 'app/views/alojamiento_detail.php';
    }
}
