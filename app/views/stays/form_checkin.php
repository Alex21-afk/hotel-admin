<?php require_once __DIR__ . '/../layout/header.php'; ?>

<div class="container mt-4">
    <h2>Registrar Check-In</h2>

    <form method="POST">

        <!-- Cliente -->
        <label class="form-label">Cliente</label>
        <div class="mb-3">
    <label class="form-label">Buscar Cliente</label>
    <input type="text" id="client_search" class="form-control" placeholder="Ingresa DNI o nombre...">
    <input type="hidden" name="client_id" id="client_id">
    <div id="client_results" class="list-group"></div>
        </div>

        <!-- Habitación -->
        <label class="form-label mt-3">Habitación</label>
        <select name="room_id" class="form-select" required>
            <option value="">Seleccione...</option>
            <?php foreach ($rooms as $r): ?>
                <option value="<?= $r['id'] ?>">
                    <?= $r['code'] ?> — Piso <?= $r['floor'] ?> — S/<?= $r['price'] ?>
                </option>
            <?php endforeach; ?>
        </select>

        <!-- Nota -->
        <label class="form-label mt-3">Nota (opcional)</label>
        <textarea name="note" class="form-control"></textarea>

        <button class="btn btn-primary mt-3">Registrar</button>
    </form>
</div>

<script>
document.getElementById("client_search").addEventListener("input", function() {

    let term = this.value;
    if (term.length < 2) return;

    fetch(`/api/clients/search?term=${term}`)
        .then(res => res.json())
        .then(data => {
            let box = document.getElementById("client_results");
            box.innerHTML = "";

            data.forEach(item => {
                let div = document.createElement("a");
                div.href = "#";
                div.classList.add("list-group-item", "list-group-item-action");
                div.textContent = `${item.full_name} (${item.dni})`;

                // ← AQUÍ es donde va tu línea para guardar el ID
                div.addEventListener("click", function() {
                    document.getElementById("client_search").value = item.full_name;

                    // Esta línea debe asignar correctamente el ID al input hidden
                    document.getElementById("client_id").value = item.id; 
                    // o item.client_id si tu API devuelve "client_id"

                    box.innerHTML = "";
                });

                box.appendChild(div);
            });
        });
});
</script>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>
