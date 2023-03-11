<?php
require_once 'Reservacion.php';
require_once 'Sala.php';
//require_once 'Usuario.php';

// Si se envió el formulario de añadir reserva
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Obtenemos los datos del formulario
    $id_sala = $_POST["id_sala"];
    $nombre = $_POST["nombre"];
    $fecha = $_POST["fecha"];
    $hora_inicio = $_POST["hora_inicio"];
    $hora_fin = $_POST["hora_fin"];

    // Creamos una instancia de la reserva con los valores del formulario
    $reservacion = new Reservacion($id_reserva, $id_sala, $nombre, $fecha, $hora_inicio, $hora_fin);

    // Validamos que la reserva sea válida y esté disponible
    if (!$reservacion->disponible()) {
        header("Location: index.php");
        exit();
    }

    // Agregamos la reserva a la base de datos
    if ($reservacion->create()) {
        // Si la reserva se guardó correctamente, redireccionamos a la página de reservaciones
        header("Location: index.php");
        exit();
    } else {
        // Si hubo un error al guardar la reserva, redireccionamos a la página de inicio
        header("Location: index.php");
        exit();
    }
}


// Obtenemos todas las salas y usuarios para mostrar en el formulario
$salas = Sala::getAll();
//$usuarios = Usuario::getAll();

?>
<!DOCTYPE html>
<html>

<head>
    <title>Sala de juntas - Reservas</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>

<body>

    <nav class="navbar navbar-inverse">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="#">Sala de juntas</a>
            </div>
            <ul class="nav navbar-nav">
                <li><a href="index.php">Reservaciones</a></li>
                <li class="active"><a href="#">Crear Reserva</a></li>
            </ul>
        </div>
    </nav>

    <div class="container mt-5">
        <h1>Añadir reservación</h1>

        <form method="POST">
            <div class="form-group">
                <label for="id_sala">Sala:</label>
                <select id="id_sala" name="id_sala" class="form-control" required>
                    <?php foreach ($salas as $sala) { ?>
                        <option value="<?php echo $sala->getid_sala(); ?>"><?php echo $sala->getnombre_sala(); ?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" name="nombre" id="nombre" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="fecha">Fecha:</label>
                <input type="date" name="fecha" id="fecha" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="hora_inicio">Hora de inicio:</label>
                <input type="time" name="hora_inicio" id="hora_inicio" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="hora_fin">Hora de fin:</label>
                <input type="time" name="hora_fin" id="hora_fin" class="form-control" required>
            </div>

            <div class="form-group">
                <input type="submit" value="Guardar" class="btn btn-primary">
                <a href="index.php" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</body>

</html>