<?php

require_once "Model.php";

class User extends Model {

    public function findByUsername($username) {
        $query = $this->db->prepare("SELECT * FROM users WHERE username = ?");
        $query->execute([$username]);
        return $query->fetch(PDO::FETCH_ASSOC);
    }
}
