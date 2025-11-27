<?php

require_once "../core/Controller.php";

class ReportsController extends Controller {

    public function monthly($year = null) {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        if (!isset($_SESSION['user'])) {
            header('Location: /auth/login');
            exit;
        }

        // Preferir año en query string ?year=YYYY, luego parámetro de ruta, luego año actual
        if (isset($_GET['year']) && is_numeric($_GET['year'])) {
            $year = (int)$_GET['year'];
        } else {
            $year = $year ? (int)$year : (int)date('Y');
        }

        $stayModel = $this->model('Stay');
        $totals = $stayModel->monthlyTotals($year);
        $counts = $stayModel->monthlyCounts($year);

        // Generar lista de años para el selector (últimos 5 años)
        $current = (int)date('Y');
        $years = [];
        for ($i = 0; $i < 5; $i++) {
            $years[] = $current - $i;
        }

        View::render('reports/monthly', [
            'year' => $year,
            'totals' => $totals,
            'counts' => $counts,
            'years' => $years,
            'type' => 'ingresos'
        ]);
    }
}
