<?php require_once __DIR__ . '/../layout/header.php'; ?>

<div class="container mt-4">
    <h2>Estancias Activas</h2>

    <a href="/stays/create" class="btn btn-primary mb-3">Registrar Check-in</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Cliente</th>
                <th>Habitación</th>
                <th>Ingreso</th>
                <th>Notas</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($active)): ?>
                <?php foreach ($active as $stay): ?>
                    <tr>
                        <td><?= htmlspecialchars($stay['full_name']) ?></td>
                        <td><?= htmlspecialchars($stay['code']) ?></td>
                        <td><?= htmlspecialchars($stay['check_in']) ?></td>
                        <td><?= htmlspecialchars($stay['note']) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" class="text-center">No hay estancias activas.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>
