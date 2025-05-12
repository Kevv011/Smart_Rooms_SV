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

    // Metodo para ver un empleado especifico
    public function getEmpleadoByID($idEmpleado)
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

    // Metodo para actualizar informacion de un empleado
    public function editUsuario($id, $nombre, $apellido, $telefono, $correo, $rol, $cargo)
    {
        $this->db->beginTransaction();

        // Actualiza tabla usuarios
        $queryUsuario = "UPDATE usuarios 
                         SET nombre = :nombre,
                             apellido = :apellido,
                             telefono = :telefono,
                             correo = :correo,
                             rol = :rol
                         WHERE id = :id";

        $stmtUsuario = $this->db->prepare($queryUsuario);
        $stmtUsuario->bindParam(":id", $id, PDO::PARAM_INT);
        $stmtUsuario->bindParam(":nombre", $nombre);
        $stmtUsuario->bindParam(":apellido", $apellido);
        $stmtUsuario->bindParam(":telefono", $telefono);
        $stmtUsuario->bindParam(":correo", $correo);
        $stmtUsuario->bindParam(":rol", $rol);
        $stmtUsuario->execute();

        // Actualiza tabla empleados
        $queryEmpleado = "UPDATE empleados 
                          SET cargo = :cargo 
                          WHERE id_usuario = :id_usuario";

        $stmtEmpleado = $this->db->prepare($queryEmpleado);
        $stmtEmpleado->bindParam(":cargo", $cargo);
        $stmtEmpleado->bindParam(":id_usuario", $id, PDO::PARAM_INT);
        $stmtEmpleado->execute();

        // Confirmar cambios
        $this->db->commit();
        return true;
    }
}
