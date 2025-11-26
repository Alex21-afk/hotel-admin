<?php require_once __DIR__ . '/../layout/header.php'; ?>

<div class="container-fluid mt-4 mb-5">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h2 mb-1">Gestión de Clientes</h1>
            <p class="text-muted">Administra la información de tus clientes</p>
        </div>
        <a href="/clients/create" class="btn btn-primary btn-lg">
            <i class="bi bi-plus-circle"></i> Nuevo Cliente
        </a>
    </div>

    <!-- Alerts -->
    <?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle"></i> <?= $_SESSION['success'] ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php unset($_SESSION['success']); endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-circle"></i> <?= $_SESSION['error'] ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php unset($_SESSION['error']); endif; ?>

    <!-- Search Bar -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <div class="input-group">
                <span class="input-group-text bg-light border-0">
                    <i class="bi bi-search"></i>
                </span>
                <input type="text" class="form-control border-0" id="searchClients" placeholder="Buscar por nombre o DNI..." autocomplete="off">
            </div>
            <div id="searchResults" class="list-group mt-2" style="display: none;"></div>
        </div>
    </div>

    <!-- Table Section -->
    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th scope="col">Nombre</th>
                        <th scope="col">DNI</th>
                        <th scope="col">Fecha Registro</th>
                        <th scope="col" class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($clients)): ?>
                        <?php foreach ($clients as $client): ?>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 36px; height: 36px;">
                                            <?= strtoupper(substr($client['full_name'], 0, 1)) ?>
                                        </div>
                                        <span><?= htmlspecialchars($client['full_name']) ?></span>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-info"><?= htmlspecialchars($client['dni']) ?></span>
                                </td>
                                <td>
                                    <small class="text-muted"><?= date('d/m/Y', strtotime($client['created_at'])) ?></small>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="/clients/edit/<?= $client['id'] ?>" class="btn btn-outline-secondary" title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <a href="/clients/delete/<?= $client['id'] ?>" class="btn btn-outline-danger" title="Eliminar" onclick="return confirm('¿Eliminar este cliente?')">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center py-5">
                                <div class="text-muted">
                                    <i class="bi bi-inbox" style="font-size: 3rem;"></i>
                                    <p class="mt-3">No hay clientes registrados</p>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
document.getElementById('searchClients').addEventListener('input', function(e) {
    const term = e.target.value.trim();
    const resultsDiv = document.getElementById('searchResults');

    if (term.length < 2) {
        resultsDiv.style.display = 'none';
        return;
    }

    fetch(`/clients/search?term=${encodeURIComponent(term)}`)
        .then(response => response.json())
        .then(data => {
            if (data.length > 0) {
                resultsDiv.innerHTML = data.map(client => `
                    <a href="/clients/edit/${client.id}" class="list-group-item list-group-item-action">
                        <i class="bi bi-person"></i> ${client.full_name}
                        <small class="text-muted ms-2">${client.dni}</small>
                    </a>
                `).join('');
                resultsDiv.style.display = 'block';
            } else {
                resultsDiv.innerHTML = '<div class="list-group-item text-muted">No hay resultados</div>';
                resultsDiv.style.display = 'block';
            }
        });
});
</script>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>