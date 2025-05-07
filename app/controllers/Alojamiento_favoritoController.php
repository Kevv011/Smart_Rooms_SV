<?php
require_once "app/models/clienteAlojamientoModel.php";
require_once "app/models/AlojamientoModel.php";

class Alojamiento_favoritoController
{
    // Metodo para ver o agregar alojamientos a favoritos
    public function favoritos()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id_user = $_SESSION['id_user'];
            $id_alojamiento = $_POST['id_alojamiento'];

            $clienteAlojamiento = new clienteAlojamientoModel();

            // Validación para evitar duplicados antes de agregar
            if ($clienteAlojamiento->favorite_exists($id_user, $id_alojamiento)) {
                header("Location: /" . $_SESSION['rootFolder'] . "/Alojamiento/getAlojamiento?id=$id_alojamiento&alert=error&message=" . urlencode("Ya tienes este alojamiento entre tus favoritos"));
                return;
            }

            // Agrega el alojamiento como favorito si no existe
            $resultado = $clienteAlojamiento->add_favorite($id_user, $id_alojamiento);

            if ($resultado) {
                header("Location: /" . $_SESSION['rootFolder'] . "/Alojamiento/getAlojamiento?id=$id_alojamiento&alert=success&message=" . urlencode("¡Alojamiento agregado a tus favoritos!"));
            } else {
                header("Location: /" . $_SESSION['rootFolder'] . "/Alojamiento/getAlojamiento?id=$id_alojamiento&alert=error&message=" . urlencode("Ocurrió un error al agregar el alojamiento a tus favoritos"));
            }
            return;
        } else {
            $clienteAlojamiento = new clienteAlojamientoModel();
            $favoritos = $clienteAlojamiento->get_favorite($_SESSION['id_user']);
            require_once 'app/views/favorite_alojamiento.php';
        }
    }

    // public function validarFavorito()
    // {
    //     $id_user = $_SESSION['id_user'];
    //     $id_alojamiento = $_GET['id'];

    //     if ($id_user && $id_alojamiento) {
    //         $clienteAlojamiento = new clienteAlojamientoModel();
    //         $alojamientoFavorito = $clienteAlojamiento->favorite_exists($id_user, $id_alojamiento);
    //     }

    //     require_once 'app/views/alojamiento_detail.php';
    // }
}
