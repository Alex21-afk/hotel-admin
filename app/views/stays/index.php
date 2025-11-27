
<?php require_once __DIR__ . '/../layout/header.php'; ?>

<div class="container-fluid mt-4 mb-5">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h2 mb-1">Estancias Activas</h1>
            <p class="text-muted">Gestiona los check-ins y estancias de tus huéspedes</p>
        </div>
        <a href="/stays/create" class="btn btn-primary btn-lg">
            <i class="bi bi-plus-circle"></i> Registrar Check-in
        </a>
    </div>

    <!-- Alerts -->
    <?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle"></i> <?= $_SESSION['success'] ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php unset($_SESSION['success']); endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-circle"></i> <?= $_SESSION['error'] ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php unset($_SESSION['error']); endif; ?>

    <!-- Stats Cards (opcional) -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="card-title text-muted">Estancias Activas</h6>
                    <h3 class="card-text"><?= count($active ?? []) ?></h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Table Section -->
    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th scope="col">Cliente</th>
                        <th scope="col">Habitación</th>
                        <th scope="col">Check-in</th>
                        <th scope="col">Tiempo</th>
                        <th scope="col">Precio Base</th>
                        <th scope="col">Notas</th>
                        <th scope="col" class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($active)): ?>
                        <?php foreach ($active as $stay): ?>
                            <?php
                                $checkIn = new DateTime($stay['check_in']);
                                $now = new DateTime();
                                $diff = $checkIn->diff($now);
                                $totalHours = ($diff->days * 24) + $diff->h + ($diff->i / 60);
                                $blocks = ceil($totalHours / 4);
                                if ($blocks < 1) $blocks = 1;
                            ?>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 36px; height: 36px;">
                                            <?= strtoupper(substr($stay['full_name'], 0, 1)) ?>
                                        </div>
                                        <span><?= htmlspecialchars($stay['full_name']) ?></span>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-info"><?= htmlspecialchars($stay['code']) ?></span>
                                </td>
                                <td>
                                    <small class="text-muted"><?= date('d/m/Y H:i', strtotime($stay['check_in'])) ?></small>
                                </td>
                                <td>
                                    <span class="badge bg-warning text-dark">
                                        <i class="bi bi-clock"></i> <?= number_format($totalHours, 1) ?>h
                                    </span>
                                    <br>
                                    <small class="text-muted"><?= $blocks ?> bloque(s)</small>
                                </td>
                                <td>
                                    <strong>S/ <?= number_format($stay['price'], 2) ?></strong>
                                    <br>
                                    <small class="text-muted">x 4 horas</small>
                                </td>
                                <td>
                                    <small><?= !empty($stay['note']) ? htmlspecialchars(substr($stay['note'], 0, 30)) . (strlen($stay['note']) > 30 ? '...' : '') : '-' ?></small>
                                </td>
                                <td class="text-center">
                                    <a href="/stays/checkout/<?= $stay['id'] ?>" class="btn btn-sm btn-success">
                                        <i class="bi bi-box-arrow-right"></i> Check-out
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center py-5">
                                <div class="text-muted">
                                    <i class="bi bi-inbox" style="font-size: 3rem;"></i>
                                    <p class="mt-3">No hay estancias activas</p>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>