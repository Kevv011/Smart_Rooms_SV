<?php
require_once "config/Database.php";

class ReservationModel
{
    private $db;

    public function __construct()
    {
        // Crear una instancia de la clase Database y obtener la conexión
        $database = new Database();
        $this->db = $database->getConnection();
    }

    // Metodo para hacer insercion de reservaciones
    public function create_reservation($id_user, $id_anfitrion, $id_alojamiento, $huespedes, $fecha_ingreso, $fecha_salida, $metodo_pago, $total_pago)
    {
        $query = "INSERT INTO reservaciones (id_usuario, id_anfitrion, id_alojamiento, huéspedes, fecha_entrada, fecha_salida, metodo_pago, total_pago, estado) 
                VALUES (:id_usuario, :id_anfitrion, :id_alojamiento, :huespedes, :fecha_entrada, :fecha_salida, :metodo_pago, :total_pago, :estado)";

        $stmt = $this->db->prepare($query);

        $stmt->bindParam(':id_usuario', $id_user, PDO::PARAM_INT);
        $stmt->bindParam(':id_anfitrion', $id_anfitrion, PDO::PARAM_INT);
        $stmt->bindParam(':id_alojamiento', $id_alojamiento, PDO::PARAM_INT);
        $stmt->bindParam(':huespedes', $huespedes, PDO::PARAM_INT);
        $stmt->bindParam(':fecha_entrada', $fecha_ingreso);
        $stmt->bindParam(':fecha_salida', $fecha_salida);
        $stmt->bindParam(':metodo_pago', $metodo_pago);
        $stmt->bindParam(':total_pago', $total_pago);

        $estado = 'pendiente';
        $stmt->bindParam(':estado', $estado);

        return $stmt->execute();
    }

    // Metodo para hacer verificacion que un cliente no genere reservacion en la misma fecha a un alojamiento
    public function verifyReservation($id_usuario, $id_alojamiento, $fecha_entrada, $fecha_salida)
    {
        $query = "SELECT COUNT(*) FROM reservaciones 
              WHERE id_usuario = :id_usuario 
              AND id_alojamiento = :id_alojamiento 
              AND (
                    :fecha_entrada < fecha_salida 
                    AND :fecha_salida > fecha_entrada
                  )
              AND estado IN ('pendiente', 'confirmada')";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
        $stmt->bindParam(':id_alojamiento', $id_alojamiento, PDO::PARAM_INT);
        $stmt->bindParam(':fecha_entrada', $fecha_entrada);
        $stmt->bindParam(':fecha_salida', $fecha_salida);

        $stmt->execute();
        $count = $stmt->fetchColumn();
        return $count > 0;
    }
}
