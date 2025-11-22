<h1><?= isset($room) ? "Editar Habitación" : "Nueva Habitación" ?></h1>

<form method="POST">

    Código:
    <input type="text" name="code"
        value="<?= $room['code'] ?? '' ?>" required>
    <br>

    Piso:
    <input type="text" name="floor"
        value="<?= $room['floor'] ?? '' ?>">
    <br>

    Descripción:
    <textarea name="description"><?= $room['description'] ?? '' ?></textarea>
    <br>

    Precio:
    <input type="number" step="0.01" name="price"
        value="<?= $room['price'] ?? '0.00' ?>" required>
    <br>

    Estado:
    <select name="status">
        <option value="available" <?= (isset($room) && $room['status']=="available") ? "selected":"" ?>>Disponible</option>
        <option value="occupied" <?= (isset($room) && $room['status']=="occupied") ? "selected":"" ?>>Ocupada</option>
        <option value="maintenance" <?= (isset($room) && $room['status']=="maintenance") ? "selected":"" ?>>Mantenimiento</option>
    </select>
    <br><br>

    <button type="submit">Guardar</button>

</form>
