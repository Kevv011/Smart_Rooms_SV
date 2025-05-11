<?php
require_once "app/models/AlojamientoModel.php";
require_once "app/models/UserModel.php";

class UsuarioController 
{
    // Metodo para ver Todos los Usuarios (Permisos de administrador)
    public function usuarios()
    {
        $model2 = new UserModel();
        $usuarios = $model2->readEmpleado1();
        require_once 'app/views/employees.php';
    }
    public function getUsuario()
    {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            //Obtencion de los datos a partir del modelo
            $userModel = new UserModel(); // Modelo para la informacion del alojamiento
            $empleModel = new UserModel();               // Modelo para la informacion del anfitrion
            $usertotal = $userModel->getUserByID($id);
           // $userEmpleado = $empleModel->getEmpleado($id);

            if (!$usertotal) {
                echo "El usuario no existe.";
                return;
            }

            require_once 'app/views/employee_detail.php';
        } else {
            echo "ID no proporcionado.";
        }
    }
}