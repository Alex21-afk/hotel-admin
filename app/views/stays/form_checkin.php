<?php require_once __DIR__ . '/../layout/header.php'; ?>

<div class="container mt-4">
    <h2>Registrar Check-In</h2>


<form method="POST" action="/stays/create">

    <!-- Cliente -->
    <div class="mb-3">
        <label for="client_id" class="form-label">Cliente</label>
        <select name="client_id" id="client_id" class="form-select" required>
            <option value="">Seleccione un cliente...</option>
            <?php foreach ($clients as $c): ?>
                <option value="<?= $c['id'] ?>">
                    <?= $c['full_name'] ?> (<?= $c['dni'] ?>)
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <!-- Habitación -->
    <div class="mb-3">
        <label for="room_id" class="form-label">Habitación</label>
        <select name="room_id" id="room_id" class="form-select" required>
            <option value="">Seleccione...</option>
            <?php foreach ($rooms as $r): ?>
                <option value="<?= $r['id'] ?>">
                    <?= $r['code'] ?> — Piso <?= $r['floor'] ?> — S/<?= $r['price'] ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <!-- Nota -->
    <div class="mb-3">
        <label for="note" class="form-label">Nota (opcional)</label>
        <textarea name="note" id="note" class="form-control" rows="3"></textarea>
    </div>

    <!-- Botón Registrar -->
    <div class="d-grid mt-4">
        <button type="submit" class="btn btn-primary btn-lg">Registrar Estancia</button>
    </div>
</form>
```

</div>

<script>
// Ejemplo de script: alerta al seleccionar un cliente
document.getElementById("client_id").addEventListener("change", function() {
    const selectedText = this.options[this.selectedIndex].text;
    console.log("Cliente seleccionado:", selectedText);
});
</script>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>
