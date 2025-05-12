<?php
require_once "config/Database.php";

class EmployeeModel
{
    //Variable para almacenar la conexión PDO en cada metodo
    private $db;

    //Constructor que guarda una instancia de la clase Database y obtener la conexión
    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    // Metodo para ver a todos los empleados
    public function readEmpleados()
    {
        $query = "SELECT * FROM usuarios WHERE rol = 'empleado'";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Metodo para ver un usuario especifico
    public function getUserByID($id)
    {
        $query = "SELECT * FROM usuarios WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    public function UsuarioEmpleadoById($idEmpleado)
    {
        $query = "
        SELECT 
            u.id AS id_usuario,
            u.nombre,
            u.apellido,
            u.telefono,
            u.correo,
            u.rol,
            u.estado,
            u.fecha_registro AS usuario_registro,

            e.id AS id_empleado,
            e.cargo,
            e.actualizado_en
        FROM usuarios u
        INNER JOIN empleados e ON e.id_usuario = u.id
        WHERE u.id = :idEmpleado
    ";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':idEmpleado', $idEmpleado, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function editUsuario(
        $id,
        $nombre,
        $apellido,
        $telefono,
        $correo,
        $rol
    ) {
        $query = "UPDATE usuarios 
              SET 
                  nombre = :nombre,
                  apellido = :apellido,
                  telefono = :telefono,
                  precio = :precio,
                  rol = :rol
              WHERE id = :id";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->bindParam(":nombre", $nombre, PDO::PARAM_INT);
        $stmt->bindParam(":apellido", $apellido);
        $stmt->bindParam(":telefono", $telefono);
        $stmt->bindParam(":correo", $correo);
        $stmt->bindParam(":rol", $rol);
        return $stmt->execute();
    }
}
