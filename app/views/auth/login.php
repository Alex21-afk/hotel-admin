<?php include "../app/views/layout/header.php"; ?>

<div class="container mt-5" style="max-width:400px;">
    <h3 class="text-center">Iniciar sesión</h3>

    <?php if (!empty($error)): ?>
    <div class="alert alert-danger">
        <?= $error ?>
    </div>
    <?php endif; ?>

    <form method="POST" action="/auth/login">
        <div class="mb-3">
            <label>Usuario</label>
            <input type="text" name="username" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Contraseña</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <button class="btn btn-primary w-100">Entrar</button>
    </form>
</div>

<?php include "../app/views/layout/footer.php"; ?>
