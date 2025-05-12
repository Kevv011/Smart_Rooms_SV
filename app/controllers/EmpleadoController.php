<?php
require_once "app/models/EmployeeModel.php";

class EmpleadoController
{
    // Metodo para ver Todos los empleados (Permisos de administrador)
    public function empleados()
    {
        $empleado = new EmployeeModel();
        $empleados = $empleado->readEmpleados('empleado');
        require_once 'app/views/employees.php';
    }

    // Metodo para procesar la obtencion del ID del empleado y ver su informacion
    public function post_detalle_empleado()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if (isset($_POST['id_usuario'])) {

                $id_empleado = $_POST['id_usuario'];

                // Si se encontro un empleado, redirigir al detalle del empleado con su ID
                header("Location: /" . $_SESSION['rootFolder'] . "/Empleado/detalle_empleado?id=$id_empleado");
                return;
            } else {
                header("Location: /" . $_SESSION['rootFolder'] . "/Empleado/empleados&alert=error&message=" . urlencode("Ocurrio un error al obtener la información de este empleado."));
                return;
            }
        }
    }

    // Metodo para ver la informacion de un empleado (Metodo post_detalle_empleado procesa la info principal)
    public function detalle_empleado()
    {
        if (!isset($_GET['id'])) {
            header("Location: /" . $_SESSION['rootFolder'] . "/Empleado/empleados?alert=error&message=" . urlencode("Error al obtener la información de este empleado."));
            exit;
        }

        $id_empleado = $_GET['id'];

        $empleado = new EmployeeModel();
        $empleadoById = $empleado->getEmpleadoByID($id_empleado);

        if (!$empleadoById) {
            header("Location: /" . $_SESSION['rootFolder'] . "/Empleado/empleados?alert=error&message=" . urlencode("El empleado no existe o fue eliminado."));
            exit;
        }

        require_once 'app/views/employee_detail.php';
    }

    public function update_empleado()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $empleado = new EmployeeModel();

            // Datos del formulario
            $id_usuario = $_POST['id_usuario'];
            $nombre = trim($_POST['nombre']);
            $apellido = trim($_POST['apellido']);
            $cod_telefono = trim($_POST['phone-code']);
            $num_telefono = trim($_POST['phone']);
            $telefono = $cod_telefono . ' ' . $num_telefono;
            $correo = trim($_POST['correo']);
            $rol = trim($_POST['rol']);
            $cargo = $_POST['cargo'];

            $resultado = $empleado->editUsuario($id_usuario, $nombre, $apellido, $telefono, $correo, $rol, $cargo);

            if ($resultado) {
                header("Location: /" . $_SESSION['rootFolder'] . "/Empleado/detalle_empleado?id=$id_usuario&alert=success&message=" . urlencode("Información de empleado actualizada"));
                return;
            } else {
                header("Location: /" . $_SESSION['rootFolder'] . "/Empleado/detalle_empleado?id=$id_usuario&alert=error&message=" . urlencode("Error al actualizar la información del empleado. Intente nuevamente"));
                return;
            }
        } else {
            echo "Acceso no permitido.";
        }
    }
}
