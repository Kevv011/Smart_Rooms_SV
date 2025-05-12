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

    public function getUsuario()
    {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            $usuarioModel = new EmployeeModel();
            $usuario = $usuarioModel->UsuarioEmpleadoById($id);

            if (!$usuario) {
                echo "El usuario no existe.";
                return;
            }

            require_once 'app/views/employee_detail.php';
        } else {
            echo "ID no proporcionado.";
        }
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {

            // Instancia del modelo
            $usu = new EmployeeModel();

            // Datos del formulario
            $idUsuario = $_POST['id'];
            $nombre = trim($_POST['nombre']);
            $apellido = trim($_POST['apellido']);
            $correo = trim($_POST['correo']);
            $rol = trim($_POST['rol']);

            $usuario_id = $_GET['id']; // Obtener ID de alojamiento con GET para hacer redireccion efectiva

            $resultado = $usu->editUsuario($idUsuario, $nombre, $apellido, $correo, $rol);

            if ($resultado) {
                header("Location: /" . $_SESSION['rootFolder'] . "/Usuario/getUsuario?id=$idUsuario&alert=success&message=" . urlencode("Alojamiento actualizado exitosamente"));
                return;
            } else {
                header("Location: /" . $_SESSION['rootFolder'] . "/Usuario/getUsuario?id=$usuario_id&alert=error&message=" . urlencode("Hubo un error al guardar la imagen del alojamiento"));
                return;
            }
        } else {
            echo "Acceso no permitido.";
        }
    }
}
