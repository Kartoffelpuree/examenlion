<?php

class Sala
{
    private $id_sala;
    private $nombre_sala;

    public function __construct($id_sala, $nombre_sala)
    {
        $this->id_sala = $id_sala;
        $this->nombre_sala = $nombre_sala;
    }

    public function getid_sala()
    {
        return $this->id_sala;
    }

    public function getnombre_sala()
    {
        return $this->nombre_sala;
    }

    public function setnombre_sala($nombre_sala)
    {
        $this->nombre_sala = $nombre_sala;
    }

    public function save()
    {
        $con = Conexion::get();
        if ($this->id_sala) {
            $stmt = $con->prepare('UPDATE salas SET nombre_sala = :nombre_sala WHERE id_sala = :id_sala');
            $stmt->bindParam(':nombre_sala', $this->nombre_sala);
            $stmt->bindParam(':id_sala', $this->id_sala);
            $stmt->execute();
        } else {
            $stmt = $con->prepare('INSERT INTO salas (nombre_sala) VALUES (:nombre_sala)');
            $stmt->bindParam(':nombre_sala', $this->nombre_sala);
            $stmt->execute();
            $this->id_sala = $con->lastInsertid_sala();
        }
    }

    public function delete()
    {
        $con = Conexion::get();
        $stmt = $con->prepare('DELETE FROM salas WHERE id_sala = :id_sala');
        $stmt->bindParam(':id_sala', $this->id_sala);
        $stmt->execute();
    }

    public static function getAll()
    {
        $con = Conexion::get();
        $stmt = $con->prepare('SELECT * FROM salas');
        $stmt->execute();
        $salas = array();
        while ($row = $stmt->fetch()) {
            $sala = new Sala($row['id_sala'], $row['nombre_sala']);
            $salas[] = $sala;
        }
        return $salas;
    }

    public static function getByid($id_sala)
    {
        $con = Conexion::get();
        $stmt = $con->prepare('SELECT * FROM salas WHERE id_sala = :id_sala');
        $stmt->bindParam(':id_sala', $id_sala);
        $stmt->execute();
        if ($row = $stmt->fetch()) {
            return new Sala($row['id_sala'], $row['nombre_sala']);
        }
        return null;
    }
}