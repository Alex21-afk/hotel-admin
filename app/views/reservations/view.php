<?php require_once __DIR__ . '/../layout/header.php'; ?>

<div class="container mt-4 mb-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/reservations">Reservaciones</a></li>
            <li class="breadcrumb-item active">Reservación #<?= $reservation['id'] ?></li>
        </ol>
    </nav>

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

    <!-- Header with Status Badge -->
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <h1 class="h2 mb-1">Reservación #<?= $reservation['id'] ?></h1>
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
            <span class="badge bg-<?= $statusClass[$reservation['status']] ?? 'secondary' ?> fs-6">
                <?= $statusText[$reservation['status']] ?? $reservation['status'] ?>
            </span>
        </div>
        
        <!-- Action Buttons -->
        <div class="btn-group">
            <?php if ($reservation['status'] === 'pending'): ?>
                <a href="/reservations/confirm/<?= $reservation['id'] ?>" 
                   class="btn btn-success"
                   onclick="return confirm('¿Confirmar esta reservación?')">
                    <i class="bi bi-check-circle"></i> Confirmar
                </a>
            <?php endif; ?>
            
            <?php if ($reservation['status'] === 'confirmed'): ?>
                <a href="/reservations/complete/<?= $reservation['id'] ?>" 
                   class="btn btn-info"
                   onclick="return confirm('¿Marcar como completada?')">
                    <i class="bi bi-check-all"></i> Completar
                </a>
            <?php endif; ?>
            
            <?php if (in_array($reservation['status'], ['pending', 'confirmed'])): ?>
                <a href="/reservations/edit/<?= $reservation['id'] ?>" class="btn btn-primary">
                    <i class="bi bi-pencil"></i> Editar
                </a>
                <a href="/reservations/cancel/<?= $reservation['id'] ?>" 
                   class="btn btn-danger"
                   onclick="return confirm('¿Cancelar esta reservación?')">
                    <i class="bi bi-x-circle"></i> Cancelar
                </a>
            <?php endif; ?>
        </div>
    </div>

    <div class="row">
        <!-- Main Information -->
        <div class="col-md-8">
            <!-- Client Information -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-person"></i> Información del Cliente</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Nombre Completo</label>
                            <div class="fw-bold"><?= htmlspecialchars($reservation['full_name']) ?></div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">DNI</label>
                            <div class="fw-bold"><?= htmlspecialchars($reservation['dni']) ?></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Room Information -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="bi bi-door-closed"></i> Información del Cuarto</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="text-muted small">Código de Cuarto</label>
                            <div class="fw-bold fs-5"><?= htmlspecialchars($reservation['code']) ?></div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="text-muted small">Piso</label>
                            <div class="fw-bold"><?= $reservation['floor'] ?></div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="text-muted small">Precio por Bloque</label>
                            <div class="fw-bold">S/ <?= number_format($reservation['price'], 2) ?></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Reservation Details -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="bi bi-calendar-check"></i> Detalles de la Reservación</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Fecha y Hora de Inicio</label>
                            <div class="fw-bold">
                                <?= date('d/m/Y H:i', strtotime($reservation['reservation_date'])) ?>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Fecha y Hora de Fin</label>
                            <div class="fw-bold">
                                <?= date('d/m/Y H:i', strtotime($reservation['end_date'])) ?>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="text-muted small">Bloques (12h cada uno)</label>
                            <div class="fw-bold fs-4">
                                <span class="badge bg-secondary"><?= $reservation['blocks'] ?> × 12h</span>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="text-muted small">Total de Horas</label>
                            <div class="fw-bold"><?= ($reservation['blocks'] * 12) ?> horas</div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="text-muted small">Duración</label>
                            <?php
                            $start = new DateTime($reservation['reservation_date']);
                            $end = new DateTime($reservation['end_date']);
                            $interval = $start->diff($end);
                            ?>
                            <div class="fw-bold">
                                <?php if ($interval->days > 0): ?>
                                    <?= $interval->days ?> día(s)
                                <?php endif; ?>
                                <?= $interval->h ?> hora(s)
                            </div>
                        </div>
                        
                        <?php if (!empty($reservation['note'])): ?>
                        <div class="col-12">
                            <label class="text-muted small">Notas / Observaciones</label>
                            <div class="alert alert-light">
                                <?= nl2br(htmlspecialchars($reservation['note'])) ?>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-md-4">
            <!-- Total Amount -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body text-center">
                    <h6 class="text-muted mb-2">Total a Pagar</h6>
                    <div class="display-4 text-success fw-bold mb-3">
                        S/ <?= number_format($reservation['total_amount'], 2) ?>
                    </div>
                    <div class="text-muted small">
                        <?= $reservation['blocks'] ?> bloque(s) × S/ <?= number_format($reservation['price'], 2) ?>
                    </div>
                </div>
            </div>

            <!-- Timeline -->
            <div class="card border-0 shadow-sm">
                <div class="card-header">
                    <h6 class="mb-0"><i class="bi bi-clock-history"></i> Información Adicional</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="text-muted small">Fecha de Creación</label>
                        <div><?= date('d/m/Y H:i', strtotime($reservation['created_at'])) ?></div>
                    </div>
                    <div class="mb-3">
                        <label class="text-muted small">Última Actualización</label>
                        <div><?= date('d/m/Y H:i', strtotime($reservation['updated_at'])) ?></div>
                    </div>
                    <hr>
                    <div class="d-grid gap-2">
                        <a href="/reservations" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left"></i> Volver a Reservaciones
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>
