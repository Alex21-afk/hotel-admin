<?php include "../app/views/layout/header-login.php"; ?>

<div class="d-flex align-items-center justify-content-center min-vh-100 fondo-login">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card border-0 shadow-lg">
                    <div class="card-body p-5">
                        <!-- Header -->
                        <div class="text-center mb-4">
                        <h2 class="card-title fw-bold mb-2">Hotel Admin</h2>                            
                            <p class="text-muted">Ingresa tus credenciales</p>
                        </div>

                        <!-- Error Alert -->
                        <?php if (!empty($error)): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-circle"></i> <?= $error ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                        <?php endif; ?>

                        <!-- Form -->
                        <form method="POST" action="/auth/login" novalidate>
                            <div class="mb-3">
                                <label for="username" class="form-label fw-semibold">Usuario</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0">
                                        <i class="bi bi-person"></i>
                                    </span>
                                    <input type="text" class="form-control border-0" id="username" name="username" placeholder="Tu usuario" required autofocus>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="password" class="form-label fw-semibold">Contraseña</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0">
                                        <i class="bi bi-lock"></i>
                                    </span>
                                    <input type="password" class="form-control border-0" id="password" name="password" placeholder="Tu contraseña" required>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">
                                <i class="bi bi-box-arrow-in-right"></i> Entrar
                            </button>
                        </form>

                        <!-- Footer -->
                        <hr class="my-4">
                        <p class="text-center text-muted small">
                            © 2025 Hotel Admin. Todos los derechos reservados.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include "../app/views/layout/footer.php"; ?>