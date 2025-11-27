<?php

require_once "Model.php";

class User extends Model {

    public function findByUsername($username) {
        $query = $this->db->prepare("SELECT * FROM users WHERE username = ?");
        $query->execute([$username]);
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    public function findById($id) {
        $query = $this->db->prepare("SELECT * FROM users WHERE id = ?");
        $query->execute([$id]);
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    public function updateById($id, $data) {
        $fields = [];
        $params = [];

        if (isset($data['name'])) {
            $fields[] = 'name = ?';
            $params[] = $data['name'];
        }
        if (isset($data['username'])) {
            $fields[] = 'username = ?';
            $params[] = $data['username'];
        }
        if (isset($data['password'])) {
            $fields[] = 'password = ?';
            $params[] = $data['password'];
        }

        if (empty($fields)) {
            return false;
        }

        $params[] = $id;
        $sql = "UPDATE users SET " . implode(", ", $fields) . " WHERE id = ?";
        $query = $this->db->prepare($sql);
        return $query->execute($params);
    }
}
