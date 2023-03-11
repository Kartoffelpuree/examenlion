<?php
require_once 'conexion.php';

class Reservacion
{
    public $id_reserva;
    public $id_sala;
    public $id_usuario;
    public $nombre;
    public $fecha;
    public $hora_inicio;
    public $hora_fin;

    public function __construct($id_reserva, $id_sala, $nombre, $fecha, $hora_inicio, $hora_fin)
    {
        $this->id_reserva = $id_reserva;
        $this->id_sala = $id_sala;
        //$this->id_usuario = $id_usuario;
        $this->nombre = $nombre;
        $this->fecha = $fecha;
        $this->hora_inicio = $hora_inicio;
        $this->hora_fin = $hora_fin;
    }

    public static function getAll()
    {
        $con = Conexion::get();
        $stmt = $con->prepare("SELECT * FROM reservaciones");
        $stmt->execute();
        $reservaciones = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $reservacion = new Reservacion($row['id_reserva'], $row['id_sala'], $row['nombre'], $row['fecha'], $row['hora_inicio'], $row['hora_fin']);
            array_push($reservaciones, $reservacion);
        }
        return $reservaciones;
    }

    public static function getById($id_reserva)
    {
        $con = Conexion::get();
        $stmt = $con->prepare("SELECT * FROM reservaciones WHERE id_reserva=:id_reserva");
        $stmt->bindParam(':id_reserva', $id_reserva, PDO::PARAM_INT);
        $stmt->execute();
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $reservacion = new Reservacion($row['id_reserva'], $row['id_sala'], $row['nombre'], $row['fecha'], $row['hora_inicio'], $row['hora_fin']);
            return $reservacion;
        } else {
            return null;
        }
    }

    public static function getBySalaAndFecha($id_sala, $fecha_reserva, $hora_inicio, $hora_fin, $id_reserva = null)
    {
        // Obtenemos la conexión a la base de datos
        $con = Conexion::get();

        // Preparamos la consulta SQL
        $sql = "SELECT * FROM reservaciones WHERE id_sala = :id_sala AND fecha = :fecha AND ((hora_inicio >= :hora_inicio AND hora_inicio < :hora_fin) OR (hora_fin > :hora_inicio AND hora_fin <= :hora_fin) OR (hora_inicio <= :hora_inicio AND hora_fin >= :hora_fin))";
        if ($id_reserva !== null) {
            $sql .= " AND id_reserva <> :id_reserva";
        }
        $stmt = $con->prepare($sql);

        // Asignamos los parámetros y ejecutamos la consulta
        $stmt->bindParam(':id_sala', $id_sala);
        $stmt->bindParam(':fecha', $fecha_reserva);
        $stmt->bindParam(':hora_inicio', $hora_inicio);
        $stmt->bindParam(':hora_fin', $hora_fin);
        if ($id_reserva !== null) {
            $stmt->bindParam(':id_reserva', $id_reserva);
        }
        $stmt->execute();

        // Obtenemos los resultados de la consulta y los convertimos en objetos Reservacion
        $reservaciones = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $reservacion = new Reservacion($row['id_reserva'], $row['id_sala'], $row['nombre'], $row['fecha'], $row['hora_inicio'], $row['hora_fin']);
            array_push($reservaciones, $reservacion);
        }
        return $reservaciones;
    }

    public function duracion()
    {
        $hora_inicio = new DateTime($this->hora_inicio);
        $hora_fin = new DateTime($this->hora_fin);
        $duracion = $hora_inicio->diff($hora_fin);
        return $duracion->h + ($duracion->i / 60);
    }

    public function disponible()
    {
        // Obtenemos todas las reservaciones que se intersectan con la reserva actual
        $reservaciones = self::getBySalaAndFecha($this->id_sala, $this->fecha, $this->hora_inicio, $this->hora_fin, $this->id_reserva);

        // Si no hay reservaciones, entonces la sala está disponible
        if (count($reservaciones) == 0) {
            return true;
        }

        // Si hay reservaciones, verificamos que la duración de la reserva no exceda las 2 horas
        $duracion = 0;
        foreach ($reservaciones as $reservacion) {
            $duracion += $reservacion->duracion();
        }
        $duracion += $this->duracion();
        if ($duracion > 2) {
            return false;
        }

        // Si la duración no excede las 2 horas, entonces la sala está disponible
        return true;
    }


    public function create()
    {
        // Verificamos que la sala esté disponible para la hora de inicio y fin de la reserva
        if (!$this->disponible()) {
            return false;
        }

        // Verificamos que la reserva no dure más de 2 horas
        $duracion = strtotime($this->hora_fin) - strtotime($this->hora_inicio);
        if ($duracion > 7200) {
            return false;
        }

        // Preparamos la consulta SQL para insertar la reserva en la base de datos
        $sql = "INSERT INTO reservaciones (id_sala, nombre, fecha, hora_inicio, hora_fin) VALUES (:id_sala, :nombre, :fecha, :hora_inicio, :hora_fin)";
        // Preparamos los valores a insertar
        $values = [
            ':id_sala' => $this->id_sala,
            ':nombre' => $this->nombre,
            ':fecha' => $this->fecha,
            ':hora_inicio' => $this->hora_inicio,
            ':hora_fin' => $this->hora_fin,
        ];
        // Ejecutamos la consulta SQL
        $stmt = Conexion::get()->prepare($sql);
        $result = $stmt->execute($values);

        // Obtenemos el ID de la reserva insertada
        $id_reserva = Conexion::get()->lastInsertId();
        // Si la consulta se ejecutó correctamente y se obtuvo un ID válido, retornamos el objeto Reservacion
        if ($result && $id_reserva) {
            $this->id_reserva = $id_reserva;
            return $this;
        } else {
            return null;
        }
    }

    public function update()
    {
        // Verificamos que la sala esté disponible para la hora de inicio y fin de la reserva
        if (!$this->disponible()) {
            return false;
        }

        // Verificamos que la reserva no dure más de 2 horas
        $duracion = strtotime($this->hora_fin) - strtotime($this->hora_inicio);
        if ($duracion > 7200) {
            return false;
        }

        // Preparamos la consulta SQL para actualizar la reservación
        $sql = "UPDATE reservaciones SET id_sala = :id_sala, id_usuario = :id_usuario, fecha = :fecha, hora_inicio = :hora_inicio, hora_fin = :hora_fin WHERE id_reserva = :id_reserva";

        // Creamos un objeto PDOStatement para ejecutar la consulta
        $stmt = Conexion::get()->prepare($sql);

        // Asignamos los valores de los parámetros
        $stmt->bindParam(':id_reserva', $this->id_reserva, PDO::PARAM_INT);
        $stmt->bindParam(':id_sala', $this->id_sala, PDO::PARAM_INT);
        $stmt->bindParam(':id_usuario', $this->id_usuario, PDO::PARAM_INT);
        $stmt->bindParam(':fecha', $this->fecha, PDO::PARAM_STR);
        $stmt->bindParam(':hora_inicio', $this->hora_inicio, PDO::PARAM_STR);
        $stmt->bindParam(':hora_fin', $this->hora_fin, PDO::PARAM_STR);

        // Ejecutamos la consulta
        return $stmt->execute();
    }
    public function delete($id_reserva)
    {
        $sql = "DELETE FROM reservaciones WHERE id_reserva=$this->id_reserva";
        $stmt = Conexion::get()->prepare($sql);

        // Asignamos los valores a los parámetros de la sentencia SQL
        $stmt->bindValue(":id_reserva", $id_reserva, PDO::PARAM_INT);

        // Ejecutamos la sentencia SQL y devolvemos true si se eliminó correctamente la reserva
        return $stmt->execute();
    }
}
