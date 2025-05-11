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

    // Metodo para hacer verificacion que un mismo cliente no genere reservacion en la misma fecha a un alojamiento. Asi mismo, un cliente no podra reservar en fechas seleccionadas por otros
    public function AlojamientoDisponible($id_alojamiento, $fecha_entrada, $fecha_salida)
    {
        // Verificar si el alojamiento existe
        $alojamientoExiste = $this->checkAlojamientoExistente($id_alojamiento);
        if (!$alojamientoExiste) {
            return false;
        }

        // Verificar disponibilidad de las fechas
        $query = "SELECT COUNT(*) 
              FROM reservaciones 
              WHERE id_alojamiento = :id_alojamiento 
              AND (
                    ( :fecha_entrada BETWEEN fecha_entrada AND fecha_salida ) 
                    OR
                    ( :fecha_salida BETWEEN fecha_entrada AND fecha_salida )
                    OR
                    ( fecha_entrada BETWEEN :fecha_entrada AND :fecha_salida )
                    OR
                    ( fecha_salida BETWEEN :fecha_entrada AND :fecha_salida )
                  )
              AND estado IN ('pendiente', 'confirmada')";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id_alojamiento', $id_alojamiento, PDO::PARAM_INT);
        $stmt->bindParam(':fecha_entrada', $fecha_entrada);
        $stmt->bindParam(':fecha_salida', $fecha_salida);

        $stmt->execute();
        return $stmt->fetchColumn() == 0;
    }

    // Método para verificar si el alojamiento existe
    public function checkAlojamientoExistente($id_alojamiento)
    {
        $query = "SELECT COUNT(*) FROM alojamientos WHERE id = :id_alojamiento";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id_alojamiento', $id_alojamiento, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }

    // Metodo para obtener reservaciones por usuario
    public function getReservationsByUser($id_usuario)
    {
        $query = "SELECT r.*, a.nombre AS nombre_alojamiento, a.direccion, a.imagen, a.precio
                FROM reservaciones r
                JOIN alojamientos a ON r.id_alojamiento = a.id
                WHERE r.id_usuario = :id_usuario
                ORDER BY r.fecha_reservacion DESC";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Método para obtener una reservación por ID, incluyendo los datos del usuario
    public function getReservationById($id_reservacion)
    {
        $query = "
        SELECT 
            r.*, 
            u.nombre AS nombre_user,
            u.apellido AS apellido_user,
            u.correo AS email_user,
            u.telefono AS telefono_user
        FROM reservaciones r
        INNER JOIN usuarios u ON r.id_usuario = u.id
        WHERE r.id = :id_reservacion
    ";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id_reservacion', $id_reservacion, PDO::PARAM_INT);
        $stmt->execute();
        $reservacion = $stmt->fetch(PDO::FETCH_ASSOC);
        return $reservacion ?: null;
    }

    // Metodo para verificar que una reservacion pertenece a un usuario y alojamiento especifico
    public function getReservationSecure($id_reservacion, $id_alojamiento, $id_usuario)
    {
        $query = "SELECT * FROM reservaciones 
              WHERE id = :id_reservacion 
              AND id_alojamiento = :id_alojamiento 
              AND id_usuario = :id_usuario";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id_reservacion', $id_reservacion, PDO::PARAM_INT);
        $stmt->bindParam(':id_alojamiento', $id_alojamiento, PDO::PARAM_INT);
        $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Metodo para verificar reservaciones validas (Permisos de administrador)
    public function getReservationByIdAndAlojamiento($id_reservacion, $id_alojamiento)
    {
        $sql = "SELECT * FROM reservaciones WHERE id = :id_reservacion AND id_alojamiento = :id_alojamiento";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_reservacion', $id_reservacion, PDO::PARAM_INT);
        $stmt->bindParam(':id_alojamiento', $id_alojamiento, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Metodo para obtener el rango de fechas para visualizacion de fechas reservadas por clientes
    public function getReservedDateRanges($id_alojamiento)
    {
        $sql = "SELECT fecha_entrada, fecha_salida FROM reservaciones
            WHERE id_alojamiento = :id_alojamiento
            AND estado IN ('pendiente','confirmada')";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_alojamiento', $id_alojamiento, PDO::PARAM_INT);
        $stmt->execute();
        $ranges = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $ranges[] = [
                'from' => $row['fecha_entrada'],
                'to'   => $row['fecha_salida']
            ];
        }
        return $ranges;
    }

    // Metodo para obtener reservaciones hechas por los usuario (Permiso de Administrador)
    public function getAllReservaciones()
    {
        $query = "SELECT 
                    r.id,
                    r.id_usuario,
                    r.id_alojamiento,
                    r.fecha_entrada,
                    r.fecha_salida,
                    r.estado,
                    r.fecha_reservacion,
                    u.nombre AS nombre_usuario,
                    a.nombre AS nombre_alojamiento,
                    a.imagen
                FROM reservaciones r
                INNER JOIN usuarios u ON r.id_usuario = u.id
                INNER JOIN alojamientos a ON r.id_alojamiento = a.id
                ORDER BY r.fecha_reservacion DESC";

        $stmt = $this->db->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
