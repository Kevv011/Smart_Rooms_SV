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

    // Crear nuevo alojamiento
    public function createAlojamiento($id_anfitrion, $nombre, $descripcion, $direccion, $precio, $imagen, $minpersona, $maxpersona, $mascota, $departamento)
    {
        $query = "INSERT INTO alojamientos (id_anfitrion, nombre, descripcion, direccion, precio, imagen, minpersona, maxpersona, mascota, departamento) 
                  VALUES (:id_anfitrion, :nombre, :descripcion, :direccion, :precio, :imagen, :minpersona, :maxpersona, :mascota, :departamento)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":id_anfitrion", $id_anfitrion);
        $stmt->bindParam(":nombre", $nombre);
        $stmt->bindParam(":descripcion", $descripcion);
        $stmt->bindParam(":direccion", $direccion);
        $stmt->bindParam(":precio", $precio);
        $stmt->bindParam(":imagen", $imagen);
        $stmt->bindParam(":minpersona", $minpersona);
        $stmt->bindParam(":maxpersona", $maxpersona);
        $stmt->bindParam(":mascota", $mascota, PDO::PARAM_BOOL);
        $stmt->bindParam(":departamento", $departamento);
        return $stmt->execute();
    }

    // Leer todos los alojamientos que NO estén eliminados
    public function readAlojamientos()
    {
        $query = "SELECT * FROM alojamientos WHERE eliminado = FALSE";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener un alojamiento por su ID (si no está eliminado)
    public function obtenerAlojamientoPorId($id)
    {
        $query = "SELECT * FROM alojamientos WHERE id = :id AND eliminado = FALSE";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Editar alojamiento
    public function editAlojamiento($id, $nombre, $descripcion, $direccion, $precio, $imagen, $minpersona, $maxpersona, $mascota, $departamento)
    {
        $query = "UPDATE alojamientos 
                  SET nombre = :nombre,
                      descripcion = :descripcion,
                      direccion = :direccion,
                      precio = :precio,
                      imagen = :imagen,
                      minpersona = :minpersona,
                      maxpersona = :maxpersona,
                      mascota = :mascota,
                      departamento = :departamento
                  WHERE id = :id AND eliminado = FALSE";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":nombre", $nombre);
        $stmt->bindParam(":descripcion", $descripcion);
        $stmt->bindParam(":direccion", $direccion);
        $stmt->bindParam(":precio", $precio);
        $stmt->bindParam(":imagen", $imagen);
        $stmt->bindParam(":minpersona", $minpersona);
        $stmt->bindParam(":maxpersona", $maxpersona);
        $stmt->bindParam(":mascota", $mascota, PDO::PARAM_BOOL);
        $stmt->bindParam(":departamento", $departamento);
        return $stmt->execute();
    }

    // "Eliminar" alojamiento con soft delete
    public function deleteAlojamiento($id)
    {
        $query = "UPDATE alojamientos SET eliminado = TRUE WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }

    // Método para restaurar un alojamiento (revertir soft delete)
    public function restoreAlojamiento($id)
    {
        $query = "UPDATE alojamientos SET eliminado = FALSE WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }
}
