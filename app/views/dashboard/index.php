
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

    <!-- Cards Section -->
    <div class="row g-4">
        <!-- Gestión de Habitaciones -->
        <div class="col-md-4">
            <a href="/rooms" class="text-decoration-none">
                <div class="card h-100 module-card rooms">
                    <div class="card-body text-center py-5">
                        <div class="mb-3">
                            <i class="bi bi-door-closed module-icon" aria-hidden="true"></i>
                        </div>
                        <h5 class="card-title fw-bold">Gestión de Habitaciones</h5>
                        <p class="card-text text-muted small">Administra las habitaciones disponibles</p>
                    </div>
                    <div class="card-footer py-3">
                        <small class="fw-semibold footer-link">Ir a Habitaciones <i class="bi bi-arrow-right ms-2"></i></small>
                    </div>
                </div>
            </a>
        </div>

        <!-- Gestión de Clientes -->
        <div class="col-md-4">
            <a href="/clients" class="text-decoration-none">
                <div class="card h-100 module-card clients">
                    <div class="card-body text-center py-5">
                        <div class="mb-3">
                            <i class="bi bi-people module-icon" aria-hidden="true"></i>
                        </div>
                        <h5 class="card-title fw-bold">Gestión de Clientes</h5>
                        <p class="card-text text-muted small">Administra la información de tus clientes</p>
                    </div>
                    <div class="card-footer py-3">
                        <small class="fw-semibold footer-link">Ir a Clientes <i class="bi bi-arrow-right ms-2"></i></small>
                    </div>
                </div>
            </a>
        </div>

        <!-- Registro de Estancias -->
        <div class="col-md-4">
            <a href="/stays" class="text-decoration-none">
                <div class="card h-100 module-card stays">
                    <div class="card-body text-center py-5">
                        <div class="mb-3">
                            <i class="bi bi-calendar-check module-icon" aria-hidden="true"></i>
                        </div>
                        <h5 class="card-title fw-bold">Registro de Estancias</h5>
                        <p class="card-text text-muted small">Gestiona los check-ins y estancias</p>
                    </div>
                    <div class="card-footer py-3">
                        <small class="fw-semibold footer-link">Ir a Estancias <i class="bi bi-arrow-right ms-2"></i></small>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>


<?php include "../app/views/layout/footer.php"; ?>