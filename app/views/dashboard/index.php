<?php include "../app/views/layout/header.php"; ?>

<div class="container mt-4">
    <h2 class="mb-4">Bienvenido al Panel del Hotel</h2>

    <div class="alert alert-primary">
        Usuario logueado: <strong><?= $user["name"] ?></strong>
    </div>

    <div class="row">
        <div class="col-md-4">
            <a href="/rooms" class="btn btn-outline-primary w-100 mb-3">Gestión de Habitaciones</a>
        </div>

        <div class="col-md-4">
            <a href="/clients" class="btn btn-outline-secondary w-100 mb-3">Gestión de Clientes</a>
        </div>

        <div class="col-md-4">
            <a href="/stays" class="btn btn-outline-success w-100 mb-3">Registro de Estancias</a>
        </div>
    </div>
</div>

<?php include "../app/views/layout/footer.php"; ?>
