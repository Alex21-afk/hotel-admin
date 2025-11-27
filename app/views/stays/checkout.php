<?php require_once __DIR__ . '/../layout/header.php'; ?>

<div class="container-fluid mt-4 mb-5">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h2 mb-1">Confirmar Check-out</h1>
            <p class="text-muted">Revisa los detalles y confirma la salida</p>
        </div>
        <a href="/stays" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Cancelar
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Customer & Room Info Card -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-info-circle"></i> Información de la Estancia
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Cliente</label>
                            <h5><?= htmlspecialchars($stay['full_name']) ?></h5>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Habitación</label>
                            <h5>
                                <span class="badge bg-info fs-6"><?= htmlspecialchars($stay['code']) ?></span>
                            </h5>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Check-in</label>
                            <h6><?= date('d/m/Y H:i', strtotime($stay['check_in'])) ?></h6>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Check-out</label>
                            <h6><?= date('d/m/Y H:i') ?></h6>
                        </div>
                        <?php if (!empty($stay['note'])): ?>
                        <div class="col-12">
                            <label class="text-muted small">Notas</label>
                            <p class="text-muted"><?= htmlspecialchars($stay['note']) ?></p>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Calculation Card -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-calculator"></i> Cálculo del Total
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row align-items-center mb-3">
                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <div class="bg-warning bg-opacity-10 rounded p-3 me-3">
                                    <i class="bi bi-clock-history fs-2 text-warning"></i>
                                </div>
                                <div>
                                    <label class="text-muted small mb-0">Tiempo Total</label>
                                    <h4 class="mb-0"><?= number_format($calculation['hours'], 1) ?> horas</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <div class="bg-info bg-opacity-10 rounded p-3 me-3">
                                    <i class="bi bi-grid-3x3-gap fs-2 text-info"></i>
                                </div>
                                <div>
                                    <label class="text-muted small mb-0">Bloques de 4 Horas</label>
                                    <h4 class="mb-0"><?= $calculation['blocks'] ?> bloque(s)</h4>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <!-- Price Breakdown -->
                    <div class="p-3 bg-light rounded mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-muted">Precio por bloque (4 horas):</span>
                            <strong>S/ <?= number_format($stay['price'], 2) ?></strong>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-muted">Cantidad de bloques:</span>
                            <strong>× <?= $calculation['blocks'] ?></strong>
                        </div>
                        <hr class="my-2">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 text-success">Total a Pagar:</h5>
                            <h3 class="mb-0 text-success">S/ <?= number_format($calculation['total'], 2) ?></h3>
                        </div>
                    </div>

                    <!-- Info Alert -->
                    <div class="alert alert-info mb-0">
                        <i class="bi bi-info-circle"></i>
                        <strong>Sistema de Cobro:</strong> Se cobra por bloques completos de 4 horas. 
                        Cualquier fracción de tiempo cuenta como un bloque adicional.
                    </div>
                </div>
            </div>

            <!-- Confirmation Form -->
            <form method="POST">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="alert alert-warning">
                            <i class="bi bi-exclamation-triangle"></i>
                            <strong>Atención:</strong> Al confirmar el check-out:
                            <ul class="mb-0 mt-2">
                                <li>Se registrará la salida con fecha y hora actual</li>
                                <li>Se cobrará el total de <strong>S/ <?= number_format($calculation['total'], 2) ?></strong></li>
                                <li>La habitación <?= htmlspecialchars($stay['code']) ?> quedará disponible</li>
                            </ul>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="/stays" class="btn btn-lg btn-outline-secondary">
                                <i class="bi bi-x-circle"></i> Cancelar
                            </a>
                            <button type="submit" class="btn btn-lg btn-success">
                                <i class="bi bi-check-circle"></i> Confirmar Check-out
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>
