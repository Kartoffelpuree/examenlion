<?php
require_once 'conexion.php';
require_once 'reservacion.php';

if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit();
}

$id = $_GET['id'];

// Obtener reserva por ID
$reservacion = Reservacion::getById($id);

if (!$reservacion) {
    header('Location: index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener datos del formulario
	$id_sala = $_POST['id_sala'];
    $id_usuario = $_POST['id_usuario'];
	$nombre = $_POST['nombre'];
    $fecha = $_POST['fecha'];
    $hora_inicio = $_POST['hora_inicio'];
    $hora_fin = $_POST['hora_fin'];


    // Actualizar reserva en la base de datos
	$reservacion->id_sala=$id_sala;
	$reservacion->id_usuario=$id_usuario;
	$reservacion->nombre=$nombre;
	$reservacion->fecha=$fecha;
	$reservacion->hora_inicio=$hora_inicio;
	$reservacion->hora_fin=$hora_fin;

    if ($reservacion->update()) {
        header('Location: index.php');
        exit();
    } else {
        echo 'Error al actualizar la reserva';
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Editar Reserva</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <h1>Editar Reserva</h1>

    <form method="POST">
        <label for="fecha">Fecha:</label>
        <input type="date" id="fecha" name="fecha" value="<?php echo $reservacion->fecha ?>" required>

        <br><br>

        <label for="hora_inicio">Hora de inicio:</label>
        <input type="time" id="hora_inicio" name="hora_inicio" value="<?php echo $reservacion->hora_inicio ?>" required>

        <br><br>

        <label for="hora_fin">Hora de fin:</label>
        <input type="time" id="hora_fin" name="hora_fin" value="<?php echo $reservacion->hora_fin ?>" required>

        <br><br>

        <label for="id_sala">Sala:</label>
        <select id="id_sala" name="id_sala">
            <?php foreach (Sala::getAll() as $sala) { ?>
                <option value="<?php echo $sala->id ?>"<?php if ($sala->id === $reservacion->id_sala) echo ' selected' ?>><?php echo $sala->nombre ?></option>
            <?php } ?>
        </select>

        <br><br>

        <label for="id_usuario">Usuario:</label>
        <select id="id_usuario" name="id_usuario">
            <?php foreach (Usuario::getAll() as $usuario) { ?>
                <option value="<?php echo $usuario->id ?>"<?php if ($usuario->id === $reservacion->id_usuario) echo ' selected' ?>><?php echo $usuario->nombre ?></option>
            <?php } ?>
        </select>

        <br><br>

        <input type="submit" value="Guardar">
    </form>
</body>
</html>
