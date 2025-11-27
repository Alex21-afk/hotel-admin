<?php require_once __DIR__ . '/../layout/header.php'; ?>

<div class="container-fluid mt-4 mb-5">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h2 mb-1">Gestión de Habitaciones</h1>
            <p class="text-muted">Administra las habitaciones del hotel</p>
        </div>
        <a href="/rooms/create" class="btn btn-primary btn-lg">
            <i class="bi bi-plus-circle"></i> Nueva Habitación
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

    <!-- Stats Cards -->
    <div class="row mb-4">
        <?php 
            $total = count($rooms);
            $available = count(array_filter($rooms, fn($r) => $r['status'] === 'available'));
            $occupied = count(array_filter($rooms, fn($r) => $r['status'] === 'occupied'));
            $maintenance = count(array_filter($rooms, fn($r) => $r['status'] === 'maintenance'));
        ?>
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1 small">Total Habitaciones</p>
                            <h3 class="mb-0"><?= $total ?></h3>
                        </div>
                        <div class="bg-primary bg-opacity-10 rounded p-3">
                            <i class="bi bi-door-closed fs-3 text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1 small">Disponibles</p>
                            <h3 class="mb-0 text-success"><?= $available ?></h3>
                        </div>
                        <div class="bg-success bg-opacity-10 rounded p-3">
                            <i class="bi bi-check-circle fs-3 text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1 small">Ocupadas</p>
                            <h3 class="mb-0 text-danger"><?= $occupied ?></h3>
                        </div>
                        <div class="bg-danger bg-opacity-10 rounded p-3">
                            <i class="bi bi-person-fill fs-3 text-danger"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1 small">Mantenimiento</p>
                            <h3 class="mb-0 text-warning"><?= $maintenance ?></h3>
                        </div>
                        <div class="bg-warning bg-opacity-10 rounded p-3">
                            <i class="bi bi-tools fs-3 text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Rooms Grid -->
    <?php if (!empty($rooms) && is_array($rooms)): ?>
        <div class="row">
            <?php foreach ($rooms as $room): ?>
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card border-0 shadow-sm h-100 room-card">
                        <div class="card-body">
                            <!-- Room Header -->
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <h4 class="mb-1">
                                        <i class="bi bi-door-closed-fill text-primary"></i>
                                        Habitación <?= htmlspecialchars($room['code']) ?>
                                    </h4>
                                    <p class="text-muted mb-0">
                                        <i class="bi bi-building"></i> Piso <?= htmlspecialchars($room['floor']) ?>
                                    </p>
                                </div>
                                <?php
                                    $statusConfig = [
                                        'available' => ['text' => 'Disponible', 'class' => 'success', 'icon' => 'check-circle'],
                                        'occupied' => ['text' => 'Ocupada', 'class' => 'danger', 'icon' => 'person-fill'],
                                        'maintenance' => ['text' => 'Mantenimiento', 'class' => 'warning', 'icon' => 'tools']
                                    ];
                                    $status = $statusConfig[$room['status']] ?? ['text' => 'Desconocido', 'class' => 'secondary', 'icon' => 'question'];
                                ?>
                                <span class="badge bg-<?= $status['class'] ?>">
                                    <i class="bi bi-<?= $status['icon'] ?>"></i> <?= $status['text'] ?>
                                </span>
                            </div>

                            <!-- Room Description -->
                            <div class="mb-3">
                                <p class="text-muted small mb-0">
                                    <?php if (!empty($room['description'])): ?>
                                        <i class="bi bi-chat-left-text"></i> <?= htmlspecialchars($room['description']) ?>
                                    <?php else: ?>
                                        <i class="bi bi-info-circle"></i> Sin descripción
                                    <?php endif; ?>
                                </p>
                            </div>

                            <!-- Room Price -->
                            <div class="mb-3">
                                <div class="d-flex align-items-center justify-content-between p-3 bg-light rounded">
                                    <span class="text-muted">Precio por noche</span>
                                    <h4 class="mb-0 text-primary">S/ <?= number_format($room['price'], 2) ?></h4>
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="d-flex gap-2">
                                <a href="/rooms/edit/<?= $room['id'] ?>" class="btn btn-outline-primary flex-fill" title="Editar">
                                    <i class="bi bi-pencil"></i> Editar
                                </a>
                                <a href="/rooms/delete/<?= $room['id'] ?>" class="btn btn-outline-danger" title="Eliminar" onclick="return confirm('¿Eliminar esta habitación?')">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </div>

                            <!-- Status Change -->
                            <div class="mt-2">
                                <div class="dropdown dropup">
                                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle w-100" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-arrow-left-right"></i> Cambiar Estado
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item" href="/rooms/status/<?= $room['id'] ?>/available">
                                                <i class="bi bi-check-circle text-success"></i> Disponible
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="/rooms/status/<?= $room['id'] ?>/occupied">
                                                <i class="bi bi-person-fill text-danger"></i> Ocupada
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="/rooms/status/<?= $room['id'] ?>/maintenance">
                                                <i class="bi bi-tools text-warning"></i> Mantenimiento
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-5">
                <i class="bi bi-inbox" style="font-size: 3rem; color: #ccc;"></i>
                <p class="text-muted mt-3">No hay habitaciones registradas</p>
                <a href="/rooms/create" class="btn btn-primary mt-2">
                    <i class="bi bi-plus-circle"></i> Crear Primera Habitación
                </a>
            </div>
        </div>
    <?php endif; ?>
</div>

<style>
.room-card {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.room-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.15) !important;
}
</style>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>
