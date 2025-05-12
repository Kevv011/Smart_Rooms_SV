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
    public function createAlojamiento($id_anfitrion, $nombre, $descripcion, $direccion, $precio, $imagen, $minpersona, $maxpersona, $mascota, $departamento, $latitud, $longitud)
    {
        $query = "INSERT INTO alojamientos (id_anfitrion, nombre, descripcion, direccion, precio, imagen, minpersona, maxpersona, mascota, departamento, latitud, longitud) 
                  VALUES (:id_anfitrion, :nombre, :descripcion, :direccion, :precio, :imagen, :minpersona, :maxpersona, :mascota, :departamento, :latitud, :longitud)";
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
        $stmt->bindParam(":latitud", $latitud);
        $stmt->bindParam(":longitud", $longitud);
        $stmt->execute();

        return $this->db->lastInsertId(); // Obtiene el ultimo ID ingresado para el metodo "updateImageAlojamiento"
    }

    //Metodo para poder actualizar el nombre de la imagen una vez ingresado datos textuales de un alojamiento
    public function updateImageAlojamiento($id, $imagen)
    {
        $query = "UPDATE alojamientos SET imagen = :imagen WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->bindParam(":imagen", $imagen);
        return $stmt->execute();
    }

    // Leer todos los alojamientos y los devuelve
    public function readAlojamientos()
    {
        $query = "SELECT * FROM alojamientos";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener un alojamiento por su ID (si no está eliminado)
    public function getAlojamientoByID($id)
    {
        $query = "SELECT * FROM alojamientos WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Editar alojamiento
    public function editAlojamiento(
        $id,
        $id_anfitrion,
        $nombre,
        $descripcion,
        $direccion,
        $precio,
        $imagen,
        $minpersona,
        $maxpersona,
        $mascota,
        $departamento,
        $latitud,
        $longitud
    ) {
        $query = "UPDATE alojamientos 
              SET id_anfitrion = :id_anfitrion,
                  nombre = :nombre,
                  descripcion = :descripcion,
                  direccion = :direccion,
                  precio = :precio,
                  imagen = :imagen,
                  minpersona = :minpersona,
                  maxpersona = :maxpersona,
                  mascota = :mascota,
                  departamento = :departamento,
                  latitud = :latitud,
                  longitud = :longitud
              WHERE id = :id";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->bindParam(":id_anfitrion", $id_anfitrion, PDO::PARAM_INT);
        $stmt->bindParam(":nombre", $nombre);
        $stmt->bindParam(":descripcion", $descripcion);
        $stmt->bindParam(":direccion", $direccion);
        $stmt->bindParam(":precio", $precio);
        $stmt->bindParam(":imagen", $imagen);
        $stmt->bindParam(":minpersona", $minpersona);
        $stmt->bindParam(":maxpersona", $maxpersona);
        $stmt->bindParam(":mascota", $mascota, PDO::PARAM_BOOL);
        $stmt->bindParam(":departamento", $departamento);
        $stmt->bindParam(":latitud", $latitud);
        $stmt->bindParam(":longitud", $longitud);

        return $stmt->execute();
    }

    // "Eliminar" alojamiento con soft delete
    public function deleteAlojamiento($id)
    {
        $query = "UPDATE alojamientos SET eliminado = TRUE WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Método para restaurar un alojamiento (revertir soft delete)
    public function restoreAlojamiento($id)
    {
        $query = "UPDATE alojamientos SET eliminado = FALSE WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Metodo para comprobar si un alojamiento no esta eliminado
    public function alojamientoDisponible($id_alojamiento)
    {
        $sql = "SELECT id FROM alojamientos 
                WHERE id = :id AND eliminado = 0 
                LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id_alojamiento, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC) !== false;
    }
}
