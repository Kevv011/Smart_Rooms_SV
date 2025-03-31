<?php
require_once "config/Database.php";

class AlojamientoModel
{
    //Variable para almacenar la conexión PDO en cada metodo
    private $db; 

    //Constructor que guarda una instancia de la clase Database y obtener la conexión
    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
    }

}