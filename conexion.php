<?php
class Conexion {
    private static $conexion = null;

    private function __construct() {}

    public static function get() {
        $host = 'localhost';
        $dbname = 'examenlion';
        $username = 'root';
        $password = '';

        if (!self::$conexion) {
            try {
                self::$conexion = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            } catch(PDOException $e) {
                die("Error de conexión: " . $e->getMessage());
            }
        }

        return self::$conexion;
    }
}
?>