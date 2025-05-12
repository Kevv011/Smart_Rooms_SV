<?php
require_once "config/Database.php";

class clienteAlojamientoModel
{
    private $db;

    public function __construct()
    {
        // Crear una instancia de la clase Database y obtener la conexión
        $database = new Database();
        $this->db = $database->getConnection();
    }

    // Metodo para obtener un JOIN con los datos del alojamiento y su relacion con un usuario
    public function get_favorite($id_user)
    {
        $query = "SELECT a.*
            FROM clientes_alojamientos cl
            JOIN alojamientos a ON cl.id_alojamiento = a.id
            WHERE cl.id_usuario = :id_usuario
        ";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id_usuario', $id_user);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Metodo para agregar favoritos por un usuario
    public function add_favorite($id_user, $id_alojamiento)
    {
        $query = "INSERT INTO clientes_alojamientos (id_usuario, id_alojamiento) VALUES (:id_usuario, :id_alojamiento)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id_usuario', $id_user);
        $stmt->bindParam(':id_alojamiento', $id_alojamiento);
        return $stmt->execute();
    }

    // Metodo para eliminar un favorito de un usuario
    public function delete_favorite($id_usuario, $id_alojamiento)
    {
        $query = "DELETE FROM usuarios_alojamientos WHERE usuario_id = :usuario_id AND alojamiento_id = :alojamiento_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":usuario_id", $id_usuario);
        $stmt->bindParam(":alojamiento_id", $id_alojamiento);
        return $stmt->execute();
    }

    //Metodo para verificar si un registro ya se encuentra como favorito
    public function favorite_exists($id_user, $id_alojamiento)
    {
        $query = "SELECT 1 FROM clientes_alojamientos 
              WHERE id_usuario = :id_usuario AND id_alojamiento = :id_alojamiento 
              LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id_usuario', $id_user, PDO::PARAM_INT);
        $stmt->bindParam(':id_alojamiento', $id_alojamiento, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC) !== false;
    }
}
