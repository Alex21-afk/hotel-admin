<?php
require_once __DIR__ . "/Model.php";

class Stay extends Model {

    protected $table = "stays";

    /** Obtener todas las estancias activas (sin checkout) */
    public function getActive() {
        $sql = "SELECT stays.*, clients.full_name, rooms.code, rooms.price 
                FROM stays
                INNER JOIN clients ON stays.client_id = clients.id
                INNER JOIN rooms ON stays.room_id = rooms.id
                WHERE check_out IS NULL
                ORDER BY stays.check_in DESC";
        return $this->db->query($sql)->fetchAll();
    }

    /** Registrar un check-in */
    public function createStay($data) {
        $sql = "INSERT INTO stays (client_id, room_id, check_in, note) 
                VALUES (?, ?, NOW(), ?)";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            $data['client_id'],
            $data['room_id'],
            $data['note'] ?? null
        ]);
    }

    /** Obtener un registro específico */
    public function find($id) {
        $sql = "SELECT stays.*, clients.full_name, rooms.code, rooms.price
                FROM stays
                INNER JOIN clients ON stays.client_id = clients.id
                INNER JOIN rooms ON stays.room_id = rooms.id
                WHERE stays.id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    /** Realizar check-out */
    public function checkout($id, $totalAmount) {
        $sql = "UPDATE stays SET check_out = NOW(), total_amount = ? WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$totalAmount, $id]);
    }

    /** Calcular el total basado en bloques de 4 horas */
    public function calculateTotal($checkIn, $pricePerBlock) {
        $checkInTime = new DateTime($checkIn);
        $now = new DateTime();
        $diff = $checkInTime->diff($now);
        
        // Calcular total de horas
        $totalHours = ($diff->days * 24) + $diff->h + ($diff->i / 60);
        
        // Calcular bloques de 4 horas (redondear hacia arriba)
        $blocks = ceil($totalHours / 4);
        
        // Mínimo 1 bloque
        if ($blocks < 1) $blocks = 1;
        
        return [
            'blocks' => $blocks,
            'hours' => $totalHours,
            'total' => $blocks * $pricePerBlock
        ];
    }

    /**
     * Devuelve totales por mes para un año dado basados en la fecha de check_out.
     * Resultado: [1 => 123.45, 2 => 0, ...]
     */
    public function monthlyTotals($year) {
        $sql = "SELECT MONTH(check_out) as month, SUM(total_amount) as total
                FROM {$this->table}
                WHERE check_out IS NOT NULL
                  AND YEAR(check_out) = ?
                GROUP BY MONTH(check_out)
                ORDER BY month";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$year]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $totals = array_fill(1, 12, 0.00);
        foreach ($rows as $r) {
            $m = (int)$r['month'];
            $totals[$m] = (float)$r['total'];
        }

        return $totals;
    }

    /**
     * Devuelve la cantidad de estancias finalizadas por mes para un año dado.
     * Resultado: [1 => 10, 2 => 0, ...]
     */
    public function monthlyCounts($year) {
        $sql = "SELECT MONTH(check_out) as month, COUNT(*) as cnt
                FROM {$this->table}
                WHERE check_out IS NOT NULL
                  AND YEAR(check_out) = ?
                GROUP BY MONTH(check_out)
                ORDER BY month";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$year]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $counts = array_fill(1, 12, 0);
        foreach ($rows as $r) {
            $m = (int)$r['month'];
            $counts[$m] = (int)$r['cnt'];
        }

        return $counts;
    }
}


