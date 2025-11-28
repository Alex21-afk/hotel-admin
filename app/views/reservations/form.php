<?php require_once __DIR__ . '/../layout/header.php'; ?>

<div class="container mt-4 mb-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/reservations">Reservaciones</a></li>
            <li class="breadcrumb-item active">
                <?= isset($reservation) ? 'Editar Reservación' : 'Nueva Reservación' ?>
            </li>
        </ol>
    </nav>

    <!-- Header -->
    <div class="mb-4">
        <h1 class="h2">
            <?= isset($reservation) ? 'Editar Reservación #' . $reservation['id'] : 'Nueva Reservación' ?>
        </h1>
        <p class="text-muted">Bloques de 12 horas</p>
    </div>

    <!-- Alerts -->
    <?php if (isset($_SESSION['error'])): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-circle"></i> <?= $_SESSION['error'] ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php unset($_SESSION['error']); endif; ?>

    <!-- Form -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <form method="POST" id="reservationForm">
                <div class="row">
                    <!-- Cliente -->
                    <div class="col-md-6 mb-3">
                        <label for="client_id" class="form-label">
                            <i class="bi bi-person"></i> Cliente <span class="text-danger">*</span>
                        </label>
                        <select name="client_id" id="client_id" class="form-select" required>
                            <option value="">Seleccionar cliente...</option>
                            <?php foreach ($clients as $client): ?>
                            <option value="<?= $client['id'] ?>" 
                                    <?= isset($reservation) && $reservation['client_id'] == $client['id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($client['full_name']) ?> - 
                                DNI: <?= htmlspecialchars($client['dni']) ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="form-text">
                            <a href="/clients/create" target="_blank">+ Agregar nuevo cliente</a>
                        </div>
                    </div>

                    <!-- Cuarto -->
                    <div class="col-md-6 mb-3">
                        <label for="room_id" class="form-label">
                            <i class="bi bi-door-closed"></i> Cuarto <span class="text-danger">*</span>
                        </label>
                        <select name="room_id" id="room_id" class="form-select" required>
                            <option value="">Seleccionar cuarto...</option>
                            <?php foreach ($rooms as $room): ?>
                            <option value="<?= $room['id'] ?>" 
                                    data-price="<?= $room['price'] ?>"
                                    <?= isset($reservation) && $reservation['room_id'] == $room['id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($room['code']) ?> - 
                                Piso <?= $room['floor'] ?> - 
                                S/ <?= number_format($room['price'], 2) ?>/bloque
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Fecha y hora de inicio -->
                    <div class="col-md-6 mb-3">
                        <label for="reservation_date" class="form-label">
                            <i class="bi bi-calendar-event"></i> Fecha y Hora de Inicio <span class="text-danger">*</span>
                        </label>
                        <input type="datetime-local" 
                               name="reservation_date" 
                               id="reservation_date" 
                               class="form-control" 
                               value="<?= isset($reservation) ? date('Y-m-d\TH:i', strtotime($reservation['reservation_date'])) : '' ?>"
                               required>
                        <div class="form-text">Fecha y hora en que inicia la reservación</div>
                    </div>

                    <!-- Número de bloques -->
                    <div class="col-md-6 mb-3">
                        <label for="blocks" class="form-label">
                            <i class="bi bi-clock-history"></i> Número de Bloques (12h) <span class="text-danger">*</span>
                        </label>
                        <input type="number" 
                               name="blocks" 
                               id="blocks" 
                               class="form-control" 
                               min="1" 
                               max="10"
                               value="<?= isset($reservation) ? $reservation['blocks'] : 1 ?>" 
                               required>
                        <div class="form-text">Cada bloque equivale a 12 horas</div>
                    </div>

                    <!-- Fecha de fin (calculada automáticamente) -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">
                            <i class="bi bi-calendar-check"></i> Fecha y Hora de Fin
                        </label>
                        <input type="text" 
                               id="end_date_display" 
                               class="form-control" 
                               readonly 
                               value="<?= isset($reservation) ? date('d/m/Y H:i', strtotime($reservation['end_date'])) : 'Seleccione fecha de inicio' ?>">
                        <div class="form-text">Calculado automáticamente</div>
                    </div>

                    <!-- Total calculado -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">
                            <i class="bi bi-cash"></i> Total a Pagar
                        </label>
                        <input type="text" 
                               id="total_display" 
                               class="form-control-plaintext fs-4 fw-bold text-success" 
                               readonly 
                               value="S/ <?= isset($reservation) ? number_format($reservation['total_amount'], 2) : '0.00' ?>">
                    </div>

                    <!-- Notas -->
                    <div class="col-12 mb-3">
                        <label for="note" class="form-label">
                            <i class="bi bi-card-text"></i> Notas / Observaciones
                        </label>
                        <textarea name="note" 
                                  id="note" 
                                  class="form-control" 
                                  rows="3"
                                  placeholder="Detalles adicionales de la reservación..."><?= isset($reservation) ? htmlspecialchars($reservation['note']) : '' ?></textarea>
                    </div>
                </div>

                <!-- Availability Alert -->
                <div id="availabilityAlert" class="alert d-none mb-3"></div>

                <!-- Buttons -->
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle"></i>
                        <?= isset($reservation) ? 'Actualizar Reservación' : 'Crear Reservación' ?>
                    </button>
                    <a href="/reservations" class="btn btn-outline-secondary">
                        <i class="bi bi-x-circle"></i> Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const roomSelect = document.getElementById('room_id');
    const blocksInput = document.getElementById('blocks');
    const startDateInput = document.getElementById('reservation_date');
    const endDateDisplay = document.getElementById('end_date_display');
    const totalDisplay = document.getElementById('total_display');
    const availabilityAlert = document.getElementById('availabilityAlert');

    function calculateEndDate() {
        const startDate = startDateInput.value;
        const blocks = parseInt(blocksInput.value) || 1;
        
        if (startDate) {
            const start = new Date(startDate);
            const hours = blocks * 12;
            const end = new Date(start.getTime() + hours * 60 * 60 * 1000);
            
            const formatted = end.toLocaleString('es-PE', {
                year: 'numeric',
                month: '2-digit',
                day: '2-digit',
                hour: '2-digit',
                minute: '2-digit'
            });
            
            endDateDisplay.value = formatted;
        }
    }

    function calculateTotal() {
        const roomOption = roomSelect.options[roomSelect.selectedIndex];
        const price = parseFloat(roomOption.dataset.price) || 0;
        const blocks = parseInt(blocksInput.value) || 1;
        const total = price * blocks;
        
        totalDisplay.value = 'S/ ' + total.toFixed(2);
    }

    function checkAvailability() {
        const roomId = roomSelect.value;
        const startDate = startDateInput.value;
        const blocks = blocksInput.value;

        if (roomId && startDate && blocks) {
            fetch(`/reservations/checkAvailability?room_id=${roomId}&start_date=${startDate}&blocks=${blocks}`)
                .then(response => response.json())
                .then(data => {
                    availabilityAlert.classList.remove('d-none', 'alert-success', 'alert-danger');
                    
                    if (data.available) {
                        availabilityAlert.classList.add('alert-success');
                        availabilityAlert.innerHTML = '<i class="bi bi-check-circle"></i> ' + data.message;
                    } else {
                        availabilityAlert.classList.add('alert-danger');
                        availabilityAlert.innerHTML = '<i class="bi bi-exclamation-triangle"></i> ' + data.message;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }
    }

    // Event listeners
    roomSelect.addEventListener('change', function() {
        calculateTotal();
        checkAvailability();
    });
    
    blocksInput.addEventListener('input', function() {
        calculateEndDate();
        calculateTotal();
        checkAvailability();
    });
    
    startDateInput.addEventListener('change', function() {
        calculateEndDate();
        checkAvailability();
    });

    // Initial calculation
    calculateEndDate();
    calculateTotal();
});
</script>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>
