<?php
require_once "config/Database.php";

class UserModel
{
    //Variable para almacenar la conexión PDO en cada metodo
    private $db;

    //Constructor que guarda una instancia de la clase Database y obtener la conexión
    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    // Metodo para obtener un anfitrion por su ID de alojamiento
    public function anfitrionByAlojamientoID($idAlojamiento)
    {
        $query = "
        SELECT 
            u.id AS id_usuario,
            u.nombre AS nombre_usuario,
            u.apellido,
            u.telefono,
            u.correo,
            u.rol,
            u.estado,
            u.fecha_registro AS usuario_registro,

            a.id AS id_anfitrion,
            a.biografia,
            a.actualizado_en AS anfitrion_actualizado,

            al.id AS id_alojamiento,
            al.nombre AS nombre_alojamiento,
            al.descripcion,
            al.direccion,
            al.precio,
            al.imagen,
            al.minpersona,
            al.maxpersona,
            al.mascota,
            al.departamento,
            al.eliminado,
            al.fecha_registro AS alojamiento_registro,
            al.actualizado_en AS alojamiento_actualizado

        FROM alojamientos al
        JOIN anfitriones a ON al.id_anfitrion = a.id
        JOIN usuarios u ON a.id_usuario = u.id
        WHERE al.id = :idAlojamiento
    ";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':idAlojamiento', $idAlojamiento, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Metodo para obtener a todos los anfitriones
    public function getAnfitriones()
    {
        try {
            $query = "SELECT 
                        u.id AS id_usuario,
                        u.nombre,
                        u.apellido,
                        u.telefono,
                        u.correo,
                        u.rol,
                        u.estado,
                        u.fecha_registro,
                        a.id AS id_anfitrion,
                        a.biografia,
                        a.actualizado_en AS actualizado_anfitrion
                    FROM anfitriones a
                    INNER JOIN usuarios u ON a.id_usuario = u.id
                    WHERE u.rol = :rol";

            $stmt = $this->db->prepare($query);
            $rol = 'anfitrion';
            $stmt->bindParam(':rol', $rol, PDO::PARAM_STR);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error al obtener anfitriones: " . $e->getMessage());
            return [];
        }
    }
    public function readEmpleado1()
    {
        $query = "SELECT * FROM usuarios";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
     public function getUserByID($id)
    {
        $query = "SELECT * FROM usuarios WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    
}
