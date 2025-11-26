<?php require_once __DIR__ . '/../layout/header.php'; ?>

<div class="container-fluid mt-4 mb-5">
    <!-- Header Section -->
    <div class="mb-4">
        <a href="/clients" class="btn btn-outline-secondary mb-3">
            <i class="bi bi-arrow-left"></i> Volver
        </a>
        <h1 class="h2 mb-1"><?= $title ?></h1>
        <p class="text-muted">Completa todos los campos del cliente</p>
    </div>

    <!-- Alerts -->
    <?php if (isset($_SESSION['error'])): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-circle"></i> <?= $_SESSION['error'] ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php unset($_SESSION['error']); endif; ?>

    <!-- Form Card -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <form method="POST" novalidate>
                <div class="row">
                    <!-- Nombre Completo -->
                    <div class="col-md-6 mb-3">
                        <label for="full_name" class="form-label fw-semibold">Nombre Completo</label>
                        <input 
                            type="text" 
                            class="form-control" 
                            id="full_name" 
                            name="full_name" 
                            placeholder="Ej: Juan Pérez" 
                            value="<?= htmlspecialchars($client['full_name'] ?? '') ?>"
                            required>
                    </div>

                    <!-- DNI -->
                    <div class="col-md-6 mb-3">
                        <label for="dni" class="form-label fw-semibold">DNI</label>
                        <input 
                            type="text" 
                            class="form-control" 
                            id="dni" 
                            name="dni" 
                            placeholder="Ej: 12345678" 
                            value="<?= htmlspecialchars($client['dni'] ?? '') ?>"
                            required>
                    </div>
                </div>

                <!-- Botones -->
                <div class="d-flex gap-2 justify-content-end mt-4">
                    <a href="/clients" class="btn btn-outline-secondary">
                        <i class="bi bi-x"></i> Cancelar
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle"></i> <?= isset($client) ? 'Actualizar' : 'Crear' ?>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>