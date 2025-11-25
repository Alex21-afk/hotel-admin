<?php
require_once __DIR__ . "/Model.php";

class Stay extends Model {

    protected $table = "stays";

    /** Obtener todas las estancias activas (sin checkout) */
    public function getActive() {
        $sql = "SELECT stays.*, clients.full_name, rooms.code 
                FROM stays
                INNER JOIN clients ON stays.client_id = clients.id
                INNER JOIN rooms ON stays.room_id = rooms.id
                WHERE check_out IS NULL";
        return $this->query($sql)->fetchAll();
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
}
