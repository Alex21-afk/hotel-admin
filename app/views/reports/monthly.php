<?php require_once __DIR__ . '/../layout/header.php'; ?>

<div class="container-fluid mt-4 mb-5">
    <div class="mb-4 d-flex flex-column flex-md-row justify-content-between align-items-start gap-3">
        <div>
            <a href="/dashboard" class="btn btn-outline-secondary mb-3">
                <i class="bi bi-arrow-left"></i> Volver
            </a>
            <h1 class="h2 mb-1">Reporte de Ingresos Mensuales - <?= htmlspecialchars($year) ?></h1>
            <p class="text-muted">Suma total por mes (basado en check-out)</p>
        </div>

        <form method="GET" action="/reports/monthly" class="d-flex align-items-center gap-2">
            <label for="year" class="form-label mb-0">Año:</label>
            <select id="year" name="year" class="form-select">
                <?php foreach (($years ?? []) as $y): ?>
                    <option value="<?= $y ?>" <?= $y == $year ? 'selected' : '' ?>><?= $y ?></option>
                <?php endforeach; ?>
            </select>
            <button class="btn btn-primary">Ver</button>
        </form>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <div class="row">
                <div class="col-lg-7">
                    <canvas id="incomeChart" height="120"></canvas>
                </div>
                <div class="col-lg-5">
                    <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Mes</th>
                        <th class="text-end">Total (S/)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $months = [1=>'Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];
                    $grand = 0;
                    foreach ($totals as $m => $amount):
                        $grand += $amount;
                    ?>
                    <tr>
                        <td><?= $months[$m] ?></td>
                        <td class="text-end"><?= number_format($amount,2) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th>Total anual</th>
                        <th class="text-end"><?= number_format($grand,2) ?></th>
                    </tr>
                </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>

<!-- Chart.js desde CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    (function(){
        const ctx = document.getElementById('incomeChart');
        if (!ctx) return;

        const months = ["Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic"];
        const totals = [<?php
            $arr = [];
            for ($i=1;$i<=12;$i++) $arr[] = number_format($totals[$i] ?? 0, 2, '.', '');
            echo implode(',', $arr);
        ?>];

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: months,
                datasets: [{
                    label: 'Ingresos (S/)',
                    data: totals,
                    backgroundColor: 'rgba(54, 162, 235, 0.6)'
                }]
            },
            options: {
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    })();
</script>
