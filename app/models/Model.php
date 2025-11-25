<?php

require_once __DIR__ . "/../../config/database.php";

class Model {

    protected $db;
    protected $table;

    public function __construct() {
        $this->db = Database::connect(); // retorna PDO
    }

    /** Ejecutar consultas directas */
    public function query($sql) {
        return $this->db->query($sql);
    }

    /** Buscar por ID */
    public function find($id) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    /** Obtener todo */
    public function getAll() {
        return $this->query("SELECT * FROM {$this->table}")->fetchAll();
    }
}
