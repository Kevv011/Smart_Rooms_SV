<?php
require_once "app/models/AlojamientoModel.php";

class AlojamientoController
{
    // Metodo para ver un alojamiento especifico por su ID
    public function getAlojamiento()
    {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            //Obtencion de los datos a partir del modelo
            $alojamientoModel = new AlojamientoModel();
            $alojamiento = $alojamientoModel->getAlojamientoByID($id);

            if (!$alojamiento) {
                echo "El alojamiento no existe.";
                return;
            }

            require_once 'app/views/alojamiento_detail.php';
        } else {
            echo "ID no proporcionado.";
        }
    }

    // Metodo para ver lista de alojamientos (Permisos de administrador)
    public function alojamientos()
    {
        $model = new AlojamientoModel();
        $alojamientos = $model->readAlojamientos();
        require_once 'app/views/alojamientos_panel.php';
    }

    // Metodo para hacer un SOFT DELETE de un alojamiento (Permiso de Administrador)
    public function softDelete()
    {
        // POST para obtener al alojamiento por su ID
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['idDelete'])) {
            $id = $_POST['idDelete'];

            // Validar que el ID sea un número entero positivo
            if (filter_var($id, FILTER_VALIDATE_INT)) {

                //Ejecucion de la funcion del modelo para eliminar alojamientos
                $alojamientoModel = new AlojamientoModel();
                $resultado = $alojamientoModel->deleteAlojamiento($id);

                if ($resultado) {
                    header("Location: /" . $_SESSION['rootFolder'] . "/Alojamiento/alojamientos?alert=success&message=" . urlencode("Alojamiento eliminado exitosamente"));
                    return;
                } else {
                    header("Location: /" . $_SESSION['rootFolder'] . "/Alojamiento/alojamientos?alert=error&message=" . urlencode("Hubo un error al eliminar el alojamiento"));
                    return;
                }
            } else {
                echo "ID inválido.";
            }
        } else {
            echo "Acceso no permitido.";
        }
    }

    // Metodo para restaurar un alojamiento (Permiso de administrador)
    public function restore()
    {
        // POST para obtener al alojamiento por su ID
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['idRestore'])) {
            $id = $_POST['idRestore'];

            // Validar que el ID sea un número entero positivo
            if (filter_var($id, FILTER_VALIDATE_INT)) {

                //Ejecucion de la funcion del modelo para eliminar alojamientos
                $alojamientoModel = new AlojamientoModel();
                $resultado = $alojamientoModel->restoreAlojamiento($id);

                if ($resultado) {
                    header("Location: /" . $_SESSION['rootFolder'] . "/Alojamiento/alojamientos?alert=success&message=" . urlencode("Alojamiento restaurado exitosamente"));
                    return;
                } else {
                    header("Location: /" . $_SESSION['rootFolder'] . "/Alojamiento/alojamientos?alert=error&message=" . urlencode("Hubo un error al restaurar el alojamiento"));
                    return;
                }
            } else {
                echo "ID inválido.";
            }
        } else {
            echo "Acceso no permitido.";
        }
    }

    // Metodo para actualizar informacion de un alojamiento (Permiso de administrador)
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {

            // Instancia del modelo
            $alojamiento = new AlojamientoModel();

            // Datos del formulario
            $idAlojamiento = $_POST['id'];
            $nombre = trim($_POST['nombre']);
            $descripcion = trim($_POST['descripcion']);
            $direccion = trim($_POST['direccion']);
            $precio = $_POST['precio'];
            $departamento = trim($_POST['departamento']);
            $minpersona = $_POST['minpersona'];
            $maxpersona = $_POST['maxpersona'];
            $mascota = $_POST['mascota'];

            $alojamiento_id = $_GET['id']; // Obtener ID de alojamiento con GET para hacer redireccion efectiva

            // Si el usuario marcó el checkbox de cambio de imagen
            if (!empty($_POST['checkImage']) && $_POST['checkImage'] == 1) {

                $imagen = $_FILES['imagen'] ?? null;
                $extension = "." . pathinfo($imagen['name'], PATHINFO_EXTENSION); // Se obtiene la extension de la imagen (.jpg, .avif, etc)

                // Validar que se subió una imagen sin errores
                if ($imagen && $imagen['error'] === 0) {

                    $nombreImagen = $idAlojamiento . "_" . str_replace(" ", "", $nombre) . "_updated_" . date("Y-m-d_H-i-s") . $extension;  // Nombre de imagen en formato id_nombre_extension_fechaHora
                    $rutaBase = $_SERVER['DOCUMENT_ROOT'] . '/' . $_SESSION['rootFolder'] . '/public/uploads/';                             // Ruta en la que se sube la imagen nueva
                    $rutaDestino = $rutaBase . $nombreImagen;
                    $rutaDestinoDB = '/public/uploads/' . $nombreImagen;    // Ruta que se insertara en la DB

                    // Mover el archivo al destino
                    if (move_uploaded_file($imagen['tmp_name'], $rutaDestino)) {
                        $resultado = $alojamiento->editAlojamiento($idAlojamiento, $nombre, $descripcion, $direccion, $precio, $rutaDestinoDB, $minpersona, $maxpersona, $mascota, $departamento);

                        if ($resultado) {
                            header("Location: /" . $_SESSION['rootFolder'] . "/Alojamiento/getAlojamiento?id=$alojamiento_id&alert=success&message=" . urlencode("Alojamiento actualizado exitosamente"));
                        } else {
                            header("Location: /" . $_SESSION['rootFolder'] . "/Alojamiento/getAlojamiento?id=$alojamiento_id&alert=error&message=" . urlencode("Hubo un error al actualizar el alojamiento"));
                            return;
                        }
                    } else {
                        echo "Error al mover el archivo de imagen.";
                    }
                } else {
                    echo "Error al subir la imagen. Verifica el archivo.";
                }
            } else {
                $imagen = $_POST['imgValue'];
                $resultado = $alojamiento->editAlojamiento($idAlojamiento, $nombre, $descripcion, $direccion, $precio, $imagen, $minpersona, $maxpersona, $mascota, $departamento);

                if ($resultado) {
                    header("Location: /" . $_SESSION['rootFolder'] . "/Alojamiento/getAlojamiento?id=$idAlojamiento&alert=success&message=" . urlencode("Alojamiento actualizado exitosamente"));
                    return;
                } else {
                    echo "Hubo un error al guardar el alojamiento.";
                }
            }
        } else {
            echo "Acceso no permitido.";
        }
    }
}
