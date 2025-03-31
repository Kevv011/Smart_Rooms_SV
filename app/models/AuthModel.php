<?php
require_once "config/Database.php";

class AuthModel
{
    //Variable para almacenar la conexión PDO en cada metodo
    private $db;

    //Constructor que guarda una instancia de la clase Database y obtener la conexión
    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    // Metodo para agregar un usuario
    public function createUser($nombre, $apellido, $telefono, $correo, $contrasenia, $rol)
    {
        $rol = 'cliente';

        $query = "INSERT INTO usuarios (nombre, apellido, telefono, correo, contrasenia, rol) 
                  VALUES (:nombre, :apellido, :telefono, :correo, :contrasenia, :rol)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":nombre", $nombre);
        $stmt->bindParam(":apellido", $apellido);
        $stmt->bindParam(":telefono", $telefono);
        $stmt->bindParam(":correo", $correo);
        $stmt->bindParam(":contrasenia", $contrasenia);
        $stmt->bindParam(":rol", $rol);
        return $stmt->execute();
    }

    // Metodo para obtener todos los usuarios
    public function showUser()
    {
        $query = "SELECT * FROM usuarios";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Metodo para obtener los detalles de un usuario específico
    public function showUserID($id)
    {
        $query = "SELECT * FROM usuarios WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC, PDO::PARAM_INT);
    }

    // Metodo para editar un usuario
    public function editUser($nombre, $apellido, $telefono, $correo, $contrasenia, $rol)
    {
        $query = "UPDATE usuarios 
                  SET nombre = :nombre, apellido = :apellido, telefono = :telefono, correo = :correo, contrasenia = :contrasenia, rol = :rol
                  WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":nombre", $nombre);
        $stmt->bindParam(":apellido", $apellido);
        $stmt->bindParam(":telefono", $telefono);
        $stmt->bindParam(":correo", $correo);
        $stmt->bindParam(":contrasenia", $contrasenia);
        $stmt->bindParam(":rol", $rol);
        return $stmt->execute();
    }

    //Metodo para hacer un soft delete de usuarios
    public function softDeleteUser($id)
    {
        $query = "UPDATE usuarios SET estado = 'inactivo' WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Metodo para realizar una eliminacion permanente de un usuario
    public function deleteUser($id)
    {
        $query = "DELETE FROM usuarios WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Metodo para obtener el correo de un usuario y validarlo en el registro
    public function getUserByEmail($correo)
    {
        $query = "SELECT * FROM usuarios WHERE correo = :correo";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':correo', $correo);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Metodo para obtener el numero de un usuario y validarlo en el registro
    public function getUserByPhoneNumber($correo)
    {
        $query = "SELECT * FROM usuarios WHERE telefono = :telefono";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':telefono', $correo);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Metodo para verificar credenciales para el login
    public function verifyCredentials($correo, $contrasenia)
    {
        $query = "SELECT * FROM usuarios WHERE correo = :correo";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":correo", $correo);
        $stmt->execute();

        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario && password_verify($contrasenia, $usuario['contrasenia'])) {
            return $usuario;
        }

        return false;
    }
}
