
<?php include "../app/views/layout/header.php"; ?>

<div class="container-fluid mt-5 mb-5 dashboard-bg">
    <!-- Welcome Header -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h2 fw-bold mb-2">Bienvenido al Panel del Hotel</h1>
                    <p class="text-muted">Gestiona todos los aspectos de tu hotel desde aquí</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Habitaciones</h6>
                            <h3 class="mb-0"><?= $stats['availableRooms'] ?? 0 ?>/<?= $stats['totalRooms'] ?? 0 ?></h3>
                            <small class="text-muted">Disponibles</small>
                        </div>
                        <div class="text-primary">
                            <i class="bi bi-door-closed" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Estancias Activas</h6>
                            <h3 class="mb-0"><?= $stats['activeStays'] ?? 0 ?></h3>
                            <small class="text-muted">Check-ins (4h)</small>
                        </div>
                        <div class="text-success">
                            <i class="bi bi-calendar-check" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Reservaciones</h6>
                            <h3 class="mb-0"><?= $stats['activeReservations'] ?? 0 ?></h3>
                            <small class="text-muted">Activas (12h)</small>
                        </div>
                        <div class="text-info">
                            <i class="bi bi-calendar-event" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Próximas (7 días)</h6>
                            <h3 class="mb-0"><?= $stats['upcomingReservations'] ?? 0 ?></h3>
                            <small class="text-muted">
                                <?= $stats['pendingReservations'] ?? 0 ?> pendientes
                            </small>
                        </div>
                        <div class="text-warning">
                            <i class="bi bi-clock-history" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Cards Section -->
    <div class="row g-4">
        <!-- Gestión de Habitaciones -->
        <div class="col-md-3">
            <a href="/rooms" class="text-decoration-none">
                <div class="card h-100 module-card rooms">
                    <div class="card-body text-center py-4">
                        <div class="mb-3">
                            <i class="bi bi-door-closed module-icon" aria-hidden="true"></i>
                        </div>
                        <h5 class="card-title fw-bold">Habitaciones</h5>
                        <p class="card-text text-muted small">Gestiona tus cuartos</p>
                    </div>
                    <div class="card-footer py-3">
                        <small class="fw-semibold footer-link">Gestionar <i class="bi bi-arrow-right ms-2"></i></small>
                    </div>
                </div>
            </a>
        </div>

        <!-- Gestión de Clientes -->
        <div class="col-md-3">
            <a href="/clients" class="text-decoration-none">
                <div class="card h-100 module-card clients">
                    <div class="card-body text-center py-4">
                        <div class="mb-3">
                            <i class="bi bi-people module-icon" aria-hidden="true"></i>
                        </div>
                        <h5 class="card-title fw-bold">Clientes</h5>
                        <p class="card-text text-muted small">Base de datos</p>
                    </div>
                    <div class="card-footer py-3">
                        <small class="fw-semibold footer-link">Ver Clientes <i class="bi bi-arrow-right ms-2"></i></small>
                    </div>
                </div>
            </a>
        </div>

        <!-- Registro de Estancias -->
        <div class="col-md-3">
            <a href="/stays" class="text-decoration-none">
                <div class="card h-100 module-card stays">
                    <div class="card-body text-center py-4">
                        <div class="mb-3">
                            <i class="bi bi-calendar-check module-icon" aria-hidden="true"></i>
                        </div>
                        <h5 class="card-title fw-bold">Estancias</h5>
                        <p class="card-text text-muted small">Check-in (4h)</p>
                    </div>
                    <div class="card-footer py-3">
                        <small class="fw-semibold footer-link">Check-ins <i class="bi bi-arrow-right ms-2"></i></small>
                    </div>
                </div>
            </a>
        </div>
        
        <!-- Reservaciones (NUEVO) -->
        <div class="col-md-3">
            <a href="/reservations" class="text-decoration-none">
                <div class="card h-100 module-card" style="border-left: 4px solid #0dcaf0;">
                    <div class="card-body text-center py-4">
                        <div class="mb-3">
                            <i class="bi bi-calendar-event module-icon text-info" aria-hidden="true"></i>
                        </div>
                        <h5 class="card-title fw-bold">Reservaciones</h5>
                        <p class="card-text text-muted small">Reservas (12h)</p>
                    </div>
                    <div class="card-footer py-3">
                        <small class="fw-semibold footer-link">Gestionar <i class="bi bi-arrow-right ms-2"></i></small>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>


<?php include "../app/views/layout/footer.php"; ?>