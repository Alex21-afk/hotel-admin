<?php require_once __DIR__ . '/../layout/header.php'; ?>

<div class="container-fluid mt-4 mb-5">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h2 mb-1"><?= $title ?? 'Gestionar Habitación' ?></h1>
            <p class="text-muted">Complete los datos de la habitación</p>
        </div>
        <a href="/rooms" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Volver
        </a>
    </div>

    <!-- Alerts -->
    <?php if (isset($_SESSION['error'])): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-circle"></i> <?= $_SESSION['error'] ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php unset($_SESSION['error']); endif; ?>

    <!-- Form Card -->
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <form method="POST" data-validate>
                        <div class="row">
                            <!-- Room Code -->
                            <div class="col-md-6 mb-3">
                                <label for="code" class="form-label">
                                    <i class="bi bi-door-closed"></i> Código de Habitación
                                    <span class="text-danger">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    class="form-control form-control-lg" 
                                    id="code" 
                                    name="code" 
                                    placeholder="Ej: 101, 202, A1" 
                                    value="<?= htmlspecialchars($room['code'] ?? '') ?>" 
                                    required
                                    autocomplete="off">
                                <div class="form-text">Código único de la habitación</div>
                            </div>

                            <!-- Floor -->
                            <div class="col-md-6 mb-3">
                                <label for="floor" class="form-label">
                                    <i class="bi bi-building"></i> Piso
                                </label>
                                <input 
                                    type="text" 
                                    class="form-control form-control-lg" 
                                    id="floor" 
                                    name="floor" 
                                    placeholder="Ej: 1, 2, 3, PB" 
                                    value="<?= htmlspecialchars($room['floor'] ?? '') ?>"
                                    autocomplete="off">
                                <div class="form-text">Piso donde se encuentra</div>
                            </div>

                            <!-- Price -->
                            <div class="col-md-6 mb-3">
                                <label for="price" class="form-label">
                                    <i class="bi bi-cash-coin"></i> Precio por Noche
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text">S/</span>
                                    <input 
                                        type="number" 
                                        class="form-control" 
                                        id="price" 
                                        name="price" 
                                        placeholder="0.00" 
                                        step="0.01" 
                                        min="0" 
                                        value="<?= htmlspecialchars($room['price'] ?? '') ?>" 
                                        required
                                        autocomplete="off">
                                </div>
                                <div class="form-text">Precio de alquiler por noche</div>
                            </div>

                            <!-- Status -->
                            <div class="col-md-6 mb-3">
                                <label for="status" class="form-label">
                                    <i class="bi bi-toggle-on"></i> Estado
                                </label>
                                <select class="form-select form-select-lg" id="status" name="status">
                                    <option value="available" <?= (isset($room) && $room['status'] === 'available') ? 'selected' : '' ?>>
                                        Disponible
                                    </option>
                                    <option value="occupied" <?= (isset($room) && $room['status'] === 'occupied') ? 'selected' : '' ?>>
                                        Ocupada
                                    </option>
                                    <option value="maintenance" <?= (isset($room) && $room['status'] === 'maintenance') ? 'selected' : '' ?>>
                                        Mantenimiento
                                    </option>
                                </select>
                                <div class="form-text">Estado actual de la habitación</div>
                            </div>

                            <!-- Description -->
                            <div class="col-12 mb-4">
                                <label for="description" class="form-label">
                                    <i class="bi bi-chat-left-text"></i> Descripción
                                </label>
                                <textarea 
                                    class="form-control form-control-lg" 
                                    id="description" 
                                    name="description" 
                                    rows="4" 
                                    placeholder="Ej: Habitación simple con baño privado, aire acondicionado y TV..."><?= htmlspecialchars($room['description'] ?? '') ?></textarea>
                                <div class="form-text">Características y amenidades de la habitación</div>
                            </div>

                            <!-- Preview Card -->
                            <div class="col-12 mb-4">
                                <div class="alert alert-info">
                                    <h6 class="alert-heading">
                                        <i class="bi bi-eye"></i> Vista Previa
                                    </h6>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <strong>Habitación <span id="preview-code"><?= htmlspecialchars($room['code'] ?? '___') ?></span></strong>
                                            - Piso <span id="preview-floor"><?= htmlspecialchars($room['floor'] ?? '___') ?></span>
                                        </div>
                                        <div>
                                            <h5 class="mb-0">S/ <span id="preview-price"><?= number_format($room['price'] ?? 0, 2) ?></span></h5>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Buttons -->
                            <div class="col-12">
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <a href="/rooms" class="btn btn-lg btn-outline-secondary">
                                        <i class="bi bi-x-circle"></i> Cancelar
                                    </a>
                                    <button type="submit" class="btn btn-lg btn-primary">
                                        <i class="bi bi-save"></i> <?= isset($room) ? 'Actualizar' : 'Crear' ?> Habitación
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Live preview
document.getElementById('code').addEventListener('input', function(e) {
    document.getElementById('preview-code').textContent = e.target.value || '___';
});

document.getElementById('floor').addEventListener('input', function(e) {
    document.getElementById('preview-floor').textContent = e.target.value || '___';
});

document.getElementById('price').addEventListener('input', function(e) {
    const value = parseFloat(e.target.value) || 0;
    document.getElementById('preview-price').textContent = value.toFixed(2);
});
</script>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>
