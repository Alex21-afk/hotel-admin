<?php require_once __DIR__ . '/../layout/header.php'; ?>

<div class="container mt-4">
    <h2>Detalles de la Habitación</h2>

    <a href="/hotel-admin/public/rooms" class="btn btn-secondary btn-sm mb-3">← Volver</a>

    <table class="table table-bordered">
        <tr>
            <th>Código</th>
            <td><?= htmlspecialchars($room['code']) ?></td>
        </tr>

        <tr>
            <th>Piso</th>
            <td><?= htmlspecialchars($room['floor']) ?></td>
        </tr>

        <tr>
            <th>Descripción</th>
            <td><?= nl2br(htmlspecialchars($room['description'])) ?></td>
        </tr>

        <tr>
            <th>Precio</th>
            <td>S/ <?= number_format($room['price'], 2) ?></td>
        </tr>

        <tr>
            <th>Estado</th>
            <td>
                <?php if ($room['status'] == 'available'): ?>
                    <span class="badge bg-success">Disponible</span>
                <?php elseif ($room['status'] == 'occupied'): ?>
                    <span class="badge bg-danger">Ocupado</span>
                <?php else: ?>
                    <span class="badge bg-warning text-dark">Mantenimiento</span>
                <?php endif; ?>
            </td>
        </tr>
    </table>

    <h5>Cambiar estado</h5>
    <div class="btn-group">
        <a href="/hotel-admin/public/rooms/status/<?= $room['id'] ?>/available" class="btn btn-success btn-sm">Disponible</a>
        <a href="/hotel-admin/public/rooms/status/<?= $room['id'] ?>/occupied" class="btn btn-danger btn-sm">Ocupado</a>
        <a href="/hotel-admin/public/rooms/status/<?= $room['id'] ?>/maintenance" class="btn btn-warning btn-sm">Mantenimiento</a>
    </div>

    <hr>

    <a href="/hotel-admin/public/rooms/edit/<?= $room['id'] ?>" class="btn btn-primary">Editar</a>

</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>
