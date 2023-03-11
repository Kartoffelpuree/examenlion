<?php
require_once "Reservacion.php";

// Verificamos si se ha enviado la id_reserva a través de la URL
if (isset($_POST["id_reserva"])) {
    // Obtenemos la id_reserva de la URL
    $id_reserva = $_POST["id_reserva"];

    // Creamos un nuevo objeto Reservacion y eliminamos la reserva con la id_reserva especificada
    $reservacion = new Reservacion($id_reserva, $id_sala, $nombre, $fecha, $hora_inicio, $hora_fin);
    if ($reservacion->delete($id_reserva)) {
        // Si la reserva se eliminó correctamente, redireccionamos a la página de reservaciones
        header("Location: index.php");
        exit();
    } else {
        // Si la reserva no se pudo eliminar, mostramos un mensaje de error
        echo "Error al eliminar la reserva.";
    }
} else {
    // Si no se ha enviado la id_reserva a través de la URL, mostramos un mensaje de error
    echo "Error: No se ha especificado la reserva a eliminar.";
}
?>
