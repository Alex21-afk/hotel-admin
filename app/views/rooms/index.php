<h1>Habitaciones</h1>

<a href="/hotel-admin/public/rooms/create">Nueva Habitación</a>

<table border="1" width="100%" cellpadding="10">
    <tr>
        <th>ID</th>
        <th>Código</th>
        <th>Piso</th>
        <th>Descripción</th>
        <th>Precio</th>
        <th>Estado</th>
        <th>Acciones</th>
    </tr>

    <?php foreach ($rooms as $room): ?>
    <tr>
        <td><?= $room['id'] ?></td>
        <td><?= $room['code'] ?></td>
        <td><?= $room['floor'] ?></td>
        <td><?= $room['description'] ?></td>
        <td><?= $room['price'] ?></td>
        <td><?= $room['status'] ?></td>
        <td>
            <a href="/hotel-admin/public/rooms/view/<?= $room['id'] ?>">Ver</a>
            |
            <a href="/hotel-admin/public/rooms/edit/<?= $room['id'] ?>">Editar</a>
            |
            <a href="/hotel-admin/public/rooms/delete/<?= $room['id'] ?>" onclick="return confirm('¿Eliminar?')">Eliminar</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
