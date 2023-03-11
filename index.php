<?php
require_once "reservacion.php";

$reservaciones = Reservacion::getAll();

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
                <li class="active"><a href="#">Reservaciones</a></li>
                <li><a href="añadir.php">Crear Reserva</a></li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Sala de Juntas</h1>
                <hr>
                <h2>Reservaciones</h2>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID_Reserva</th>
                            <th>ID_Sala</th>
                            <th>Nombre</th>
                            <th>Fecha</th>
                            <th>Hora de inicio</th>
                            <th>Hora de fin</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($reservaciones as $reservacion) : ?>
                            <tr>
                                <td><?php echo $reservacion->id_reserva ?></td>
                                <td><?php echo $reservacion->id_sala ?></td>
                                <td><?php echo $reservacion->nombre ?></td>
                                <td><?php echo $reservacion->fecha ?></td>
                                <td><?php echo $reservacion->hora_inicio ?></td>
                                <td><?php echo $reservacion->hora_fin ?></td>
                                <td>
                                    <a href="editar.php?id=<?php echo $reservacion->id_reserva ?>" class="btn btn-sm btn-primary">Editar</a>
                                    <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#confirmarEliminar">Eliminar</button>
                                    <div class="modal fade" id="confirmarEliminar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Eliminar reserva</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    ¿Está seguro que desea eliminar la reserva seleccionada?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                                    <form action="eliminar.php" method="post">
                                                        <input type="hidden" name="id_reserva" value="<?php echo $reservacion->id_reserva ?>">
                                                        <button type="submit" class="btn btn-danger">Eliminar</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>