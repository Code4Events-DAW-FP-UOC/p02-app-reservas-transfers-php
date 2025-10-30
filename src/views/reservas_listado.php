<!-- src/views/reservas_listado.php -->
 <!DOCTYPE html>
 <html lang="es">
 <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Reservas</title>
 </head>
 <body>
    <h1>Listado de Reservas</h1>
    <?php if (!empty($reservas)): ?>
        <table border="1">
            <tr>
                <?php foreach (array_keys($reservas[0]) as $col): ?>
                    <th><?= htmlspecialchars($col) ?></th>
                <?php endforeach; ?>
            </tr>
            <?php foreach ($reservas as $reserva): ?>
                <td> <?= htmlspecialchars($valor) ?></td>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p> No hay reservas registradas.</p>
    <?php endif; ?>
 </body>
 </html>