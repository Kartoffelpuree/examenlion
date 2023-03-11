<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Crear reserva - Sala de juntas</title>
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
      <li class="active"><a href="#">Crear reserva</a></li>
      <li><a href="editar.php">Editar reserva</a></li>
      <li><a href="liberar.php">Liberar reserva</a></li>
    </ul>
  </div>
</nav>

<div class="container">
	<div class="row">
		<div class="col-md-6 col-md-offset-3">
			<h2>Crear reserva</h2>
			<form action="reservacion.php" method="POST">
				<div class="form-group">
					<label for="sala">Sala</label>
					<select name="sala" id="sala" class="form-control">
						<option value="Sala 1">Sala 1</option>
						<option value="Sala 2">Sala 2</option>
						<option value="Sala 3">Sala 3</option>
					</select>
				</div>
				<div class="form-group">
					<label for="fecha">Fecha</label>
					<input type="date" name="fecha" id="fecha" class="form-control" required>
				</div>
				<div class="form-group">
					<label for="hora_inicio">Hora de inicio</label>
					<input type="time" name="hora_inicio" id="hora_inicio" class="form-control" required>
				</div>
				<div class="form-group">
					<label for="hora_fin">Hora de fin</label>
					<input type="time" name="hora_fin" id="hora_fin" class="form-control" required>
				</div>
				<button type="submit" class="btn btn-primary">Guardar</button>
				<a href="../index.php" class="btn btn-default">Cancelar</a>
			</form>
		</div>
	</div>
</div>

</body>
</html>