<?php
require_once __DIR__ . "/Model.php";

class Reservation extends Model {

    protected $table = "reservations";

    /** Obtener todas las reservaciones con filtro opcional por estado */
    public function getAll($status = null) {
        $sql = "SELECT reservations.*, clients.full_name, clients.dni, 
                       rooms.code, rooms.price 
                FROM reservations
                INNER JOIN clients ON reservations.client_id = clients.id
                INNER JOIN rooms ON reservations.room_id = rooms.id";
        
        if ($status) {
            $sql .= " WHERE reservations.status = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$status]);
            return $stmt->fetchAll();
        }
        
        $sql .= " ORDER BY reservations.reservation_date DESC";
        return $this->db->query($sql)->fetchAll();
    }

    /** Obtener reservaciones activas (pending o confirmed) */
    public function getActive() {
        $sql = "SELECT reservations.*, clients.full_name, clients.dni, 
                       rooms.code, rooms.price 
                FROM reservations
                INNER JOIN clients ON reservations.client_id = clients.id
                INNER JOIN rooms ON reservations.room_id = rooms.id
                WHERE reservations.status IN ('pending', 'confirmed')
                ORDER BY reservations.reservation_date ASC";
        return $this->db->query($sql)->fetchAll();
    }

    /** Obtener reservaciones próximas (próximas 7 días) */
    public function getUpcoming() {
        $sql = "SELECT reservations.*, clients.full_name, rooms.code 
                FROM reservations
                INNER JOIN clients ON reservations.client_id = clients.id
                INNER JOIN rooms ON reservations.room_id = rooms.id
                WHERE reservations.status IN ('pending', 'confirmed')
                  AND reservations.reservation_date BETWEEN NOW() AND DATE_ADD(NOW(), INTERVAL 7 DAY)
                ORDER BY reservations.reservation_date ASC";
        return $this->db->query($sql)->fetchAll();
    }

    /** Crear una nueva reservación */
    public function create($data) {
        // Calcular fecha de fin basada en bloques de 12 horas
        $blocks = $data['blocks'] ?? 1;
        $hours = $blocks * 12;
        
        $sql = "INSERT INTO reservations 
                (client_id, room_id, reservation_date, end_date, blocks, total_amount, status, note) 
                VALUES (?, ?, ?, DATE_ADD(?, INTERVAL ? HOUR), ?, ?, ?)";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $data['client_id'],
            $data['room_id'],
            $data['reservation_date'],
            $data['reservation_date'],
            $hours,
            $blocks,
            $data['total_amount'],
            $data['status'] ?? 'pending',
            $data['note'] ?? null
        ]);
    }

    /** Obtener una reservación específica */
    public function find($id) {
        $sql = "SELECT reservations.*, clients.full_name, clients.dni,
                       rooms.code, rooms.price, rooms.floor
                FROM reservations
                INNER JOIN clients ON reservations.client_id = clients.id
                INNER JOIN rooms ON reservations.room_id = rooms.id
                WHERE reservations.id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    /** Actualizar estado de la reservación */
    public function updateStatus($id, $status) {
        $sql = "UPDATE reservations SET status = ?, updated_at = NOW() WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$status, $id]);
    }

    /** Confirmar reservación */
    public function confirm($id) {
        return $this->updateStatus($id, 'confirmed');
    }

    /** Cancelar reservación */
    public function cancel($id) {
        return $this->updateStatus($id, 'cancelled');
    }

    /** Completar reservación */
    public function complete($id) {
        return $this->updateStatus($id, 'completed');
    }

    /** Calcular el total basado en bloques de 12 horas */
    public function calculateTotal($blocks, $pricePerBlock) {
        $totalHours = $blocks * 12;
        
        return [
            'blocks' => $blocks,
            'hours' => $totalHours,
            'total' => $blocks * $pricePerBlock
        ];
    }

    /** Verificar si un cuarto está disponible en un rango de fechas */
    public function isRoomAvailable($roomId, $startDate, $endDate, $excludeId = null) {
        $sql = "SELECT COUNT(*) as count FROM reservations 
                WHERE room_id = ? 
                AND status IN ('pending', 'confirmed')
                AND (
                    (reservation_date BETWEEN ? AND ?) OR
                    (end_date BETWEEN ? AND ?) OR
                    (reservation_date <= ? AND end_date >= ?)
                )";
        
        if ($excludeId) {
            $sql .= " AND id != ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$roomId, $startDate, $endDate, $startDate, $endDate, $startDate, $endDate, $excludeId]);
        } else {
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$roomId, $startDate, $endDate, $startDate, $endDate, $startDate, $endDate]);
        }
        
        $result = $stmt->fetch();
        return $result['count'] == 0;
    }

    /** Obtener cuartos disponibles para un rango de fechas específico */
    public function getAvailableRooms($startDate, $endDate) {
        $sql = "SELECT r.* FROM rooms r
                WHERE r.status = 'available'
                AND r.id NOT IN (
                    SELECT room_id FROM reservations
                    WHERE status IN ('pending', 'confirmed')
                    AND (
                        (reservation_date BETWEEN ? AND ?) OR
                        (end_date BETWEEN ? AND ?) OR
                        (reservation_date <= ? AND end_date >= ?)
                    )
                )
                AND r.id NOT IN (
                    SELECT room_id FROM stays
                    WHERE check_out IS NULL
                )
                ORDER BY r.code ASC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$startDate, $endDate, $startDate, $endDate, $startDate, $endDate]);
        return $stmt->fetchAll();
    }

    /** Obtener totales mensuales de reservaciones completadas */
    public function monthlyTotals($year) {
        $sql = "SELECT MONTH(reservation_date) as month, SUM(total_amount) as total
                FROM {$this->table}
                WHERE status = 'completed'
                  AND YEAR(reservation_date) = ?
                GROUP BY MONTH(reservation_date)
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

    /** Actualizar una reservación existente */
    public function update($id, $data) {
        $blocks = $data['blocks'] ?? 1;
        $hours = $blocks * 12;
        
        $sql = "UPDATE reservations 
                SET client_id = ?, 
                    room_id = ?, 
                    reservation_date = ?, 
                    end_date = DATE_ADD(?, INTERVAL ? HOUR),
                    blocks = ?,
                    total_amount = ?,
                    note = ?,
                    updated_at = NOW()
                WHERE id = ?";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $data['client_id'],
            $data['room_id'],
            $data['reservation_date'],
            $data['reservation_date'],
            $hours,
            $blocks,
            $data['total_amount'],
            $data['note'] ?? null,
            $id
        ]);
    }
}
