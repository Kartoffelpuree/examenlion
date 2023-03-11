<?php
require_once 'reservacion.php';

$id_reserva = $_GET['id'];

$reservacion = Reservacion::getById($id_reserva);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Obtenemos los datos enviados por el usuario
  $fecha = $_POST['fecha'];
  $hora_inicio = $_POST['hora_inicio'];
  $hora_fin = $_POST['hora_fin'];

  // Actualizamos la reservación
  $reservacion->fecha = $fecha;
  $reservacion->hora_inicio = $hora_inicio;
  $reservacion->hora_fin = $hora_fin;

  if ($reservacion->update()) {
    // Redirigimos al index si la actualización fue exitosa
    header('Location: index.php');
  } else {
    echo 'Error al actualizar la reservación, revisa si es una fecha valida o si no superas las 2 horas maximas de reservación';
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Editar reservación</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container mt-5">
  <h1>Editar reservación</h1>

  <form method="POST">
    <div class="form-group">
      <label for="fecha">Fecha:</label>
      <input type="date" class="form-control" id="fecha" name="fecha" value="<?php echo $reservacion->fecha ?>">
    </div>
    <div class="form-group">
      <label for="hora_inicio">Hora de inicio:</label>
      <input type="time" class="form-control" id="hora_inicio" name="hora_inicio" value="<?php echo $reservacion->hora_inicio ?>">
    </div>
    <div class="form-group">
      <label for="hora_fin">Hora de fin:</label>
      <input type="time" class="form-control" id="hora_fin" name="hora_fin" value="<?php echo $reservacion->hora_fin ?>">
    </div>
    <button type="submit" class="btn btn-primary">Actualizar</button>
  </form>
</div>

</body>
</html>