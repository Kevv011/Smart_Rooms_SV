<?php
require_once "app/models/AlojamientoModel.php";
require_once "app/models/UserModel.php";

class AlojamientoController
{
    // Metodo para ver un alojamiento especifico por su ID
    public function getAlojamiento()
    {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            //Obtencion de los datos a partir del modelo
            $alojamientoModel = new AlojamientoModel(); // Modelo para la informacion del alojamiento
            $userModel = new UserModel();               // Modelo para la informacion del anfitrion
            $alojamiento = $alojamientoModel->getAlojamientoByID($id);
            $userAnfitrion = $userModel->anfitrionByAlojamientoID($id);

            if (!$alojamiento || !$userAnfitrion) {
                echo "El alojamiento no existe.";
                return;
            }

            $userModel = new UserModel();                    // Modelo para la informacion del anfitrion en caso de un update
            $anfitriones = $userModel->getAnfitriones();

            require_once 'app/views/alojamiento_detail.php';
        } else {
            echo "ID no proporcionado.";
        }
    }

    // Método para procesar el formulario y guardar el alojamiento
    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            // Datos del formulario
            $id_anfitrion = trim($_POST['id_anfitrion']);
            $nombre = trim($_POST['nombre']);
            $descripcion = trim($_POST['descripcion']);
            $direccion = trim($_POST['direccion']);
            $precio = $_POST['precio'];
            $imagen = $_FILES['imagen'] ?? null;
            $minpersona = $_POST['minpersona'];
            $maxpersona = $_POST['maxpersona'];
            $mascota = trim($_POST['mascota']);
            $departamento = trim($_POST['departamento']);
            $latitud = trim($_POST['latitud']);
            $longitud = trim($_POST['longitud']);

            // Llamada al modelo para guardar el alojamiento y obtener el ID para agregarlo al nombre de la imagen
            $alojamiento = new AlojamientoModel();
            $newAlojamiento = $alojamiento->createAlojamiento($id_anfitrion, $nombre, $descripcion, $direccion, $precio, NULL, $minpersona, $maxpersona, $mascota, $departamento, $latitud, $longitud);

            if ($newAlojamiento) { // Si el resultado fue exitoso, se empieza el proceso para guardar la imagen
                if ($imagen && $imagen['error'] === 0) {

                    $extension = "." . pathinfo($imagen['name'], PATHINFO_EXTENSION); // Se obtiene la extension de la imagen (.jpg, .avif, etc)

                    // Definir la carpeta de destino para las imágenes a "uploads"
                    $nombreImagen = $newAlojamiento . "_" . str_replace(" ", "", $nombre) . $extension;              // Nombre de imagen en formato id_nombreAlojamiento_extension
                    $rutaBase = $_SERVER['DOCUMENT_ROOT'] . '/' . $_SESSION['rootFolder'] . '/public/uploads/';      // Ruta en la que se sube la imagen nueva
                    $rutaDestino = $rutaBase . $nombreImagen;
                    $rutaDestinoDB = '/public/uploads/' . $nombreImagen;    // Ruta que se actualizara en la DB

                    // Mover el archivo a la carpeta "uploads"
                    if (move_uploaded_file($imagen['tmp_name'], $rutaDestino)) {

                        // Llamada al modelo para actualizar la ruta de la imagen
                        $resultadoImg = $alojamiento->updateImageAlojamiento($newAlojamiento, $rutaDestinoDB);

                        if ($resultadoImg) { // Si el resultado fue exitoso
                            header("Location: /" . $_SESSION['rootFolder'] . "/Alojamiento/alojamientos?alert=success&message=" . urlencode("Alojamiento creado exitosamente"));
                            exit();
                        } else {
                            header("Location: /" . $_SESSION['rootFolder'] . "/Alojamiento/alojamientos?alert=error&message=" . urlencode("Hubo un problema al crear un alojamiento. Intente mas tarde."));
                            exit();
                        }
                    } else {
                        header("Location: /" . $_SESSION['rootFolder'] . "/Alojamiento/alojamientos?alert=error&message=" . urlencode("Hubo un problema al cargar la imagen."));
                        exit();
                    }
                } else {
                    header("Location: /" . $_SESSION['rootFolder'] . "/Alojamiento/alojamientos?alert=error&message=" . urlencode("Ocurrio un error al subir un alojamiento."));
                    exit();
                }
            } else {
                header("Location: /" . $_SESSION['rootFolder'] . "/Alojamiento/alojamientos?alert=error&message=" . urlencode("Hubo un problema al crear un alojamiento."));
                exit();
            }
        } else {
            $userModel = new UserModel();                    // Modelo para la informacion del anfitrion
            $anfitriones = $userModel->getAnfitriones();

            require_once 'app/views/create_alojamiento.php'; // Acceso al formulario de crear un alojamiento con la solicitud reconocida (GET)
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
            $id_anfitrion = $_POST['id_anfitrion'];
            $nombre = trim($_POST['nombre']);
            $descripcion = trim($_POST['descripcion']);
            $direccion = trim($_POST['direccion']);
            $precio = $_POST['precio'];
            $departamento = trim($_POST['departamento']);
            $minpersona = $_POST['minpersona'];
            $maxpersona = $_POST['maxpersona'];
            $mascota = $_POST['mascota'];
            $latitud = trim($_POST['latitud']);
            $longitud = trim($_POST['longitud']);

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
                        $resultado = $alojamiento->editAlojamiento($idAlojamiento, $id_anfitrion, $nombre, $descripcion, $direccion, $precio, $rutaDestinoDB, $minpersona, $maxpersona, $mascota, $departamento, $latitud, $longitud);

                        if ($resultado) {
                            header("Location: /" . $_SESSION['rootFolder'] . "/Alojamiento/getAlojamiento?id=$alojamiento_id&alert=success&message=" . urlencode("Alojamiento actualizado exitosamente"));
                        } else {
                            header("Location: /" . $_SESSION['rootFolder'] . "/Alojamiento/getAlojamiento?id=$alojamiento_id&alert=error&message=" . urlencode("Hubo un error al actualizar el alojamiento"));
                            return;
                        }
                    } else {
                        header("Location: /" . $_SESSION['rootFolder'] . "/Alojamiento/getAlojamiento?id=$alojamiento_id&alert=error&message=" . urlencode("Hubo un error al mover la imagen del alojamiento"));
                        return;
                    }
                } else {
                    header("Location: /" . $_SESSION['rootFolder'] . "/Alojamiento/getAlojamiento?id=$alojamiento_id&alert=error&message=" . urlencode("Hubo un error al subir la nueva imagen del alojamiento"));
                    return;
                }
            } else {
                $imagen = $_POST['imgValue'];
                $resultado = $alojamiento->editAlojamiento($idAlojamiento, $id_anfitrion, $nombre, $descripcion, $direccion, $precio, $imagen, $minpersona, $maxpersona, $mascota, $departamento, $latitud, $longitud);

                if ($resultado) {
                    header("Location: /" . $_SESSION['rootFolder'] . "/Alojamiento/getAlojamiento?id=$idAlojamiento&alert=success&message=" . urlencode("Alojamiento actualizado exitosamente"));
                    return;
                } else {
                    header("Location: /" . $_SESSION['rootFolder'] . "/Alojamiento/getAlojamiento?id=$alojamiento_id&alert=error&message=" . urlencode("Hubo un error al guardar la imagen del alojamiento"));
                    return;
                }
            }
        } else {
            echo "Acceso no permitido.";
        }
    }
}
