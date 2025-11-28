<?php

class Room extends Model {

    protected $table = "rooms";

    public function getAll() {
        $sql = "SELECT * FROM rooms ORDER BY code ASC";
        return $this->db->query($sql)->fetchAll();
    }

    public function getById($id) {
        $sql = "SELECT * FROM rooms WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function create($data) {
        $sql = "INSERT INTO rooms (code, floor, description, price, status) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $data['code'],
            $data['floor'],
            $data['description'] ?? '',
            $data['price'],
            $data['status'] ?? 'available'
        ]);
    }

    public function update($data) {
        $sql = "UPDATE rooms SET code=?, floor=?, description=?, price=?, status=? WHERE id=?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $data['code'],
            $data['floor'],
            $data['description'] ?? '',
            $data['price'],
            $data['status'] ?? 'available',
            $data['id']
        ]);
    }

    public function delete($id) {
        $sql = "DELETE FROM rooms WHERE id=?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id]);
    }

    public function changeStatus($id, $status) {
        $stmt = $this->db->prepare("UPDATE rooms SET status = ? WHERE id = ?");
        return $stmt->execute([$status, $id]);
    }

    public function getAvailable() {
        return $this->query("SELECT * FROM rooms WHERE status = 'available'")->fetchAll();
    }

    public function updateStatus($id, $status) {
        $stmt = $this->db->prepare("UPDATE rooms SET status = ? WHERE id = ?");
        $stmt->execute([$status, $id]);
    }

    /**
     * Obtener cuartos disponibles considerando estancias activas y reservaciones
     * Se excluyen cuartos ocupados y cuartos con reservaciones activas
     */
    public function getAvailableForCheckIn() {
        $sql = "SELECT * FROM rooms 
                WHERE status = 'available'
                AND id NOT IN (
                    SELECT room_id FROM stays WHERE check_out IS NULL
                )
                AND id NOT IN (
                    SELECT room_id FROM reservations 
                    WHERE status IN ('pending', 'confirmed')
                    AND NOW() BETWEEN reservation_date AND end_date
                )
                ORDER BY code ASC";
        return $this->db->query($sql)->fetchAll();
    }

    /**
     * Verificar si un cuarto está disponible en este momento
     * considerando estancias activas y reservaciones
     */
    public function isAvailableNow($roomId) {
        // Verificar si está ocupado
        $sql = "SELECT COUNT(*) as count FROM stays 
                WHERE room_id = ? AND check_out IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$roomId]);
        $result = $stmt->fetch();
        
        if ($result['count'] > 0) {
            return false;
        }

        // Verificar si tiene reservación activa en este momento
        $sql = "SELECT COUNT(*) as count FROM reservations 
                WHERE room_id = ? 
                AND status IN ('pending', 'confirmed')
                AND NOW() BETWEEN reservation_date AND end_date";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$roomId]);
        $result = $stmt->fetch();
        
        return $result['count'] == 0;
    }
}
