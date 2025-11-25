<?php
require_once __DIR__ . "/Model.php";

class Client extends Model {

    protected $table = "clients";

    /** Obtener todos los clientes */
    public function getAll() {
        $sql = "SELECT * FROM clients ORDER BY full_name";
        return $this->query($sql)->fetchAll();
    }

    /** Buscar cliente */
    public function find($id) {
        $sql = "SELECT * FROM clients WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    /** Crear cliente */
    public function create($data) {
        $sql = "INSERT INTO clients (full_name, document, phone) VALUES (?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            $data['full_name'],
            $data['document'],
            $data['phone']
        ]);
    }

    public function search($term) {
    $sql = "SELECT id, full_name, dni 
            FROM clients 
            WHERE full_name LIKE ? OR dni LIKE ?
            LIMIT 10";

    $stmt = $this->db->prepare($sql);

    $like = '%' . $term . '%';

    $stmt->execute([$like, $like]);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


}
