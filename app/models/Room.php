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
}
