<?php
require_once "app/models/AlojamientoModel.php";
require_once "app/models/clienteAlojamientoModel.php";

class HomeController
{
    public function index()
    {
        $model = new AlojamientoModel();
        $alojamientos = $model->readAlojamientos();
        require_once 'app/views/home.php';
    }
    public function aboutUs() {
        require_once 'app/views/partials/about-us.php';
    }
}
