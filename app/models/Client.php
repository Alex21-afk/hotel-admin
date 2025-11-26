<?php

class Client extends Model {

    protected $table = 'clients';

    public function getAll() {
        $sql = "SELECT * FROM {$this->table} ORDER BY full_name ASC";
        return $this->db->query($sql)->fetchAll();
    }

    public function getById($id) {
        $sql = "SELECT * FROM {$this->table} WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function create($data) {
        $sql = "INSERT INTO {$this->table} (full_name, dni) VALUES (?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$data['full_name'], $data['dni']]);
    }

    public function update($data) {
        $sql = "UPDATE {$this->table} SET full_name = ?, dni = ? WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$data['full_name'], $data['dni'], $data['id']]);
    }

    public function delete($id) {
        $sql = "DELETE FROM {$this->table} WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id]);
    }

    public function search($term) {
        $sql = "SELECT id, full_name, dni FROM {$this->table} WHERE full_name LIKE ? OR dni LIKE ? LIMIT 10";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(["%$term%", "%$term%"]);
        return $stmt->fetchAll();
    }
}