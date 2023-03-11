<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Liberar reserva - Sala de juntas</title>
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
      <li><a href="crear.php">Crear reserva</a></li>
      <li><a href="editar.php">Editar reserva</a></li>
      <li class="active"><a href="#">Liberar reserva</a></li>
    </ul>
  </div>
</nav>

<div class="container">
	<div class="row">
		<div class="col-md-6 col-md-offset-3">
			<h2>Liberar reserva</h2>
			<p>¿Estás seguro de que deseas liberar esta reserva?</p>
			<form action="liberar.php" method="POST">
				<input type="hidden" name="id" value="<?php echo $id ?>">
				<button type="submit" class="btn btn-danger">Sí, liberar</button>
				<a href="index.php" class="btn btn-default">Cancelar</a>
			</form>
		</div>
	</div>
</div>

</body>
</html>