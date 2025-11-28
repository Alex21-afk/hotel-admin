<?php require_once __DIR__ . '/../layout/header.php'; ?>

<div class="container-fluid mt-4 mb-5">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h2 mb-1">Reservaciones</h1>
            <p class="text-muted">Gestiona las reservaciones de cuartos (bloques de 12 horas)</p>
        </div>
        <a href="/reservations/create" class="btn btn-primary btn-lg">
            <i class="bi bi-plus-circle"></i> Nueva Reservación
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

    <!-- Filter Tabs -->
    <ul class="nav nav-pills mb-4">
        <li class="nav-item">
            <a class="nav-link <?= ($currentFilter ?? 'all') === 'all' ? 'active' : '' ?>" href="/reservations">
                Todas
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= ($currentFilter ?? '') === 'active' ? 'active' : '' ?>" href="/reservations?filter=active">
                Activas
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= ($currentFilter ?? '') === 'pending' ? 'active' : '' ?>" href="/reservations?filter=pending">
                Pendientes
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= ($currentFilter ?? '') === 'confirmed' ? 'active' : '' ?>" href="/reservations?filter=confirmed">
                Confirmadas
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= ($currentFilter ?? '') === 'completed' ? 'active' : '' ?>" href="/reservations?filter=completed">
                Completadas
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= ($currentFilter ?? '') === 'cancelled' ? 'active' : '' ?>" href="/reservations?filter=cancelled">
                Canceladas
            </a>
        </li>
    </ul>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="card-title text-muted">Total Reservaciones</h6>
                    <h3 class="card-text"><?= count($reservations ?? []) ?></h3>
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
                        <th scope="col">ID</th>
                        <th scope="col">Cliente</th>
                        <th scope="col">Cuarto</th>
                        <th scope="col">Fecha Inicio</th>
                        <th scope="col">Fecha Fin</th>
                        <th scope="col">Bloques (12h)</th>
                        <th scope="col">Total</th>
                        <th scope="col">Estado</th>
                        <th scope="col" class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($reservations)): ?>
                    <tr>
                        <td colspan="9" class="text-center text-muted py-5">
                            <i class="bi bi-calendar-x fs-1 d-block mb-2"></i>
                            No hay reservaciones para mostrar
                        </td>
                    </tr>
                    <?php else: ?>
                        <?php foreach ($reservations as $res): ?>
                        <tr>
                            <td><strong>#<?= htmlspecialchars($res['id']) ?></strong></td>
                            <td>
                                <div><?= htmlspecialchars($res['full_name']) ?></div>
                                <small class="text-muted">DNI: <?= htmlspecialchars($res['dni']) ?></small>
                            </td>
                            <td>
                                <span class="badge bg-info text-dark">
                                    <?= htmlspecialchars($res['code']) ?>
                                </span>
                            </td>
                            <td><?= date('d/m/Y H:i', strtotime($res['reservation_date'])) ?></td>
                            <td><?= date('d/m/Y H:i', strtotime($res['end_date'])) ?></td>
                            <td>
                                <span class="badge bg-secondary">
                                    <?= $res['blocks'] ?> × 12h
                                </span>
                            </td>
                            <td><strong>S/ <?= number_format($res['total_amount'], 2) ?></strong></td>
                            <td>
                                <?php
                                $statusClass = [
                                    'pending' => 'warning',
                                    'confirmed' => 'success',
                                    'cancelled' => 'danger',
                                    'completed' => 'info'
                                ];
                                $statusText = [
                                    'pending' => 'Pendiente',
                                    'confirmed' => 'Confirmada',
                                    'cancelled' => 'Cancelada',
                                    'completed' => 'Completada'
                                ];
                                ?>
                                <span class="badge bg-<?= $statusClass[$res['status']] ?? 'secondary' ?>">
                                    <?= $statusText[$res['status']] ?? $res['status'] ?>
                                </span>
                            </td>
                            <td class="text-end">
                                <a href="/reservations/show/<?= $res['id'] ?>" 
                                   class="btn btn-sm btn-outline-primary" 
                                   title="Ver detalles">
                                    <i class="bi bi-eye"></i>
                                </a>
                                
                                <?php if (in_array($res['status'], ['pending', 'confirmed'])): ?>
                                <a href="/reservations/edit/<?= $res['id'] ?>" 
                                   class="btn btn-sm btn-outline-secondary" 
                                   title="Editar">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>
