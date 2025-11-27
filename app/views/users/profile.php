<?php require_once __DIR__ . '/../layout/header.php'; ?>

<div class="container-fluid mt-4 mb-5">
    <div class="mb-4">
        <a href="/dashboard" class="btn btn-outline-secondary mb-3">
            <i class="bi bi-arrow-left"></i> Volver
        </a>
        <h1 class="h2 mb-1">Mi Perfil</h1>
        <p class="text-muted">Actualiza tus datos de usuario</p>
    </div>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>

    <?php if (isset($success)): ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
    <?php endif; ?>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <form method="POST" novalidate>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="name" class="form-label fw-semibold">Nombre</label>
                        <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($user['name'] ?? '') ?>" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="username" class="form-label fw-semibold">Usuario</label>
                        <input type="text" class="form-control" id="username" name="username" value="<?= htmlspecialchars($user['username'] ?? '') ?>" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="password" class="form-label fw-semibold">Nueva contraseña (dejar en blanco para mantener)</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="*****">
                    </div>
                </div>

                <div class="d-flex gap-2 justify-content-end mt-4">
                    <a href="/dashboard" class="btn btn-outline-secondary">
                        <i class="bi bi-x"></i> Cancelar
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle"></i> Guardar cambios
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>
