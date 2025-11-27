<?php require_once __DIR__ . '/../layout/header.php'; ?>

<div class="container-fluid mt-4 mb-5">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h2 mb-1">Detalle del Cliente</h1>
            <p class="text-muted">Información completa y historial de alquileres</p>
        </div>
        <a href="/clients" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Volver
        </a>
    </div>

    <!-- Client Information Card -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-2 text-center">
                    <div class="avatar bg-primary text-white rounded-circle d-flex align-items-center justify-content-center mx-auto" style="width: 80px; height: 80px; font-size: 2rem;">
                        <?= strtoupper(substr($client['full_name'], 0, 1)) ?>
                    </div>
                </div>
                <div class="col-md-10">
                    <h3 class="mb-3"><?= htmlspecialchars($client['full_name']) ?></h3>
                    <div class="row">
                        <div class="col-md-6">
                            <p class="mb-2">
                                <strong><i class="bi bi-credit-card-2-front"></i> DNI:</strong>
                                <span class="badge bg-info ms-2"><?= htmlspecialchars($client['dni']) ?></span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-2">
                                <strong><i class="bi bi-calendar-plus"></i> Fecha de Registro:</strong>
                                <span class="text-muted ms-2"><?= date('d/m/Y H:i', strtotime($client['created_at'])) ?></span>
                            </p>
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="/clients/edit/<?= $client['id'] ?>" class="btn btn-primary btn-sm">
                            <i class="bi bi-pencil"></i> Editar Cliente
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Rental History Section -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white">
            <h5 class="mb-0">
                <i class="bi bi-clock-history"></i> Historial de Alquileres
                <span class="badge bg-secondary ms-2"><?= count($stays) ?></span>
            </h5>
        </div>
        <div class="card-body">
            <?php if (!empty($stays) && is_array($stays)): ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th scope="col">Habitación</th>
                                <th scope="col">Piso</th>
                                <th scope="col">Check-in</th>
                                <th scope="col">Check-out</th>
                                <th scope="col">Duración</th>
                                <th scope="col">Precio/Día</th>
                                <th scope="col">Total</th>
                                <th scope="col">Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($stays as $stay): ?>
                                <?php 
                                    $checkIn = new DateTime($stay['check_in']);
                                    $checkOut = $stay['check_out'] ? new DateTime($stay['check_out']) : null;
                                    $now = new DateTime();
                                    
                                    if ($checkOut) {
                                        $endTime = $checkOut;
                                        $status = 'completado';
                                        $statusBadge = 'success';
                                    } else {
                                        $endTime = $now;
                                        $status = 'activo';
                                        $statusBadge = 'primary';
                                    }
                                    
                                    // Calcular horas totales
                                    $diff = $checkIn->diff($endTime);
                                    $totalHours = ($diff->days * 24) + $diff->h + ($diff->i / 60);
                                    
                                    // Calcular bloques de 4 horas
                                    $blocks = ceil($totalHours / 4);
                                    if ($blocks < 1) $blocks = 1;
                                    
                                    // Total registrado o calculado
                                    $total = $stay['total_amount'] > 0 ? $stay['total_amount'] : ($blocks * $stay['price']);
                                ?>
                                <tr>
                                    <td>
                                        <strong><?= htmlspecialchars($stay['room_code']) ?></strong>
                                    </td>
                                    <td>
                                        <span class="text-muted">Piso <?= htmlspecialchars($stay['floor']) ?></span>
                                    </td>
                                    <td>
                                        <small><?= $checkIn->format('d/m/Y H:i') ?></small>
                                    </td>
                                    <td>
                                        <?php if ($checkOut): ?>
                                            <small><?= $checkOut->format('d/m/Y H:i') ?></small>
                                        <?php else: ?>
                                            <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <span class="badge bg-info"><?= number_format($totalHours, 1) ?>h</span>
                                        <br>
                                        <small class="text-muted"><?= $blocks ?> bloque(s)</small>
                                    </td>
                                    <td>
                                        S/ <?= number_format($stay['price'], 2) ?>
                                        <br>
                                        <small class="text-muted">x 4h</small>
                                    </td>
                                    <td>
                                        <strong>S/ <?= number_format($total, 2) ?></strong>
                                    </td>
                                    <td>
                                        <span class="badge bg-<?= $statusBadge ?>">
                                            <?= ucfirst($status) ?>
                                        </span>
                                    </td>
                                </tr>
                                <?php if (!empty($stay['note'])): ?>
                                <tr>
                                    <td colspan="8" class="border-0 pt-0">
                                        <small class="text-muted">
                                            <i class="bi bi-chat-left-text"></i> Nota: <?= htmlspecialchars($stay['note']) ?>
                                        </small>
                                    </td>
                                </tr>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Summary -->
                <div class="mt-3 p-3 bg-light rounded">
                    <div class="row text-center">
                        <div class="col-md-4">
                            <h6 class="text-muted mb-1">Total de Estancias</h6>
                            <h4 class="mb-0"><?= count($stays) ?></h4>
                        </div>
                        <div class="col-md-4">
                            <h6 class="text-muted mb-1">Estancias Activas</h6>
                            <h4 class="mb-0 text-primary">
                                <?= count(array_filter($stays, function($s) { return $s['check_out'] === null; })) ?>
                            </h4>
                        </div>
                        <div class="col-md-4">
                            <h6 class="text-muted mb-1">Total Gastado</h6>
                            <h4 class="mb-0 text-success">
                                S/ <?php 
                                    $totalSpent = 0;
                                    foreach ($stays as $stay) {
                                        if ($stay['total_amount'] > 0) {
                                            $totalSpent += $stay['total_amount'];
                                        } else {
                                            $checkIn = new DateTime($stay['check_in']);
                                            $endTime = $stay['check_out'] ? new DateTime($stay['check_out']) : new DateTime();
                                            $diff = $checkIn->diff($endTime);
                                            $hours = ($diff->days * 24) + $diff->h + ($diff->i / 60);
                                            $blocks = ceil($hours / 4);
                                            if ($blocks < 1) $blocks = 1;
                                            $totalSpent += $blocks * $stay['price'];
                                        }
                                    }
                                    echo number_format($totalSpent, 2);
                                ?>
                            </h4>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <div class="text-center py-5">
                    <i class="bi bi-inbox" style="font-size: 3rem; color: #ccc;"></i>
                    <p class="text-muted mt-3">Este cliente aún no tiene alquileres registrados</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>
