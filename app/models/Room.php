<?php

class Room extends Model {

    protected $table = "rooms";

    public function getAll() {
        $sql = "SELECT * FROM rooms ORDER BY id DESC";
        return $this->query($sql);
    }

    public function find($id) {
        $sql = "SELECT * FROM rooms WHERE id = ?";
        return $this->query($sql, [$id], true);
    }

    public function create($data) {
        $sql = "INSERT INTO rooms (code, floor, description, price, status) VALUES (?, ?, ?, ?, ?)";
        return $this->query($sql, [
            $data['code'],
            $data['floor'],
            $data['description'],
            $data['price'],
            $data['status']
        ]);
    }

    public function updateRoom($id, $data) {
        $sql = "UPDATE rooms SET code=?, floor=?, description=?, price=?, status=? WHERE id=?";
        return $this->query($sql, [
            $data['code'],
            $data['floor'],
            $data['description'],
            $data['price'],
            $data['status'],
            $id
        ]);
    }

    public function deleteRoom($id) {
        $sql = "DELETE FROM rooms WHERE id=?";
        return $this->query($sql, [$id]);
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
}
