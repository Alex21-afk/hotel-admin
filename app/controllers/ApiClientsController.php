<?php

class ApiClientsController extends Controller {

    private $client;

    public function __construct() {
        parent::__construct();
        $this->client = new Client();
    }

    // Buscar clientes por nombre, apellido o DNI
    public function search() {

        // Asegurar petición GET o AJAX
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            http_response_code(405);
            echo json_encode(["error" => "Método no permitido"]);
            return;
        }

        // Recibir término de búsqueda
        $term = isset($_GET['term']) ? trim($_GET['term']) : '';

        if (empty($term)) {
            echo json_encode([]);
            return;
        }

        // Consultar modelo
        $results = $this->client->search($term);

        header('Content-Type: application/json');
        echo json_encode($results);
    }
}
