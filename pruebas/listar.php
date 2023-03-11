<h1>Listado de salas de juntas y reservaciones</h1>

<a href="index.php?accion=crear">Crear nueva reservación</a>

<table>
    <tr>
        <th>Sala</th>
        <th>Usuario</th>
        <th>Fecha inicio</th>
        <th>Fecha fin</th>
        <th>Acciones</th>
    </tr>
    <?php foreach ($salas as $sala) { ?>
        <tr>
            <td><?php echo $sala['nombre']; ?></td>
            <td></td>
            <td></td>
            <td></td>
            <td>
                <a href="index.php?accion=mostrar&id=<?php echo $sala['id']; ?>">Ver</a>
            </td>
        </tr>
        <?php foreach ($reservaciones as $reservacion) {
            if ($reservacion['sala_id'] == $sala['id']) { ?>
                <tr>
                    <td></td>
                    <td><?php echo $reservacion['usuario']; ?></td>
                    <td><?php echo $reservacion['fecha_inicio']; ?></td>
                    <td><?php echo $reservacion['fecha_fin']; ?></td>
                    <td>
                        <a href="index.php?accion=editar&id=<?php echo $reservacion['id']; ?>">Editar</a>
                        <a href="index.php?accion=eliminar&id=<?php echo $reservacion['id']; ?>">Eliminar</a>
                        <a href="index.php?accion=liberar&id=<?php echo $reservacion['id']; ?>">Liberar</a>
                    </td>
                </tr>
            <?php }
        } ?>
    <?php } ?>
</table>