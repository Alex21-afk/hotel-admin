<?php

class ClientsController extends Controller {

    private $client;

    public function __construct() {
        $this->client = new Client();
    }

    // Listar todos los clientes
    public function index() {
        $clients = $this->client->getAll();
        $this->view('clients/index', ['clients' => $clients]);
    }
    

    // Crear nuevo cliente
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'full_name' => $_POST['full_name'] ?? '',
                'dni' => $_POST['dni'] ?? '',
            ];

            if (empty($data['full_name']) || empty($data['dni'])) {
                $_SESSION['error'] = 'Todos los campos son requeridos';
                header('Location: /clients/create');
                return;
            }

            if ($this->client->create($data)) {
                $_SESSION['success'] = 'Cliente creado exitosamente';
                header('Location: /clients');
            } else {
                $_SESSION['error'] = 'Error al crear el cliente';
                header('Location: /clients/create');
            }
            return;
        }

        $this->view('clients/form', ['title' => 'Crear Cliente']);
    }

    // Editar cliente
    public function edit($id) {
        $client = $this->client->getById($id);
        
        if (!$client) {
            $_SESSION['error'] = 'Cliente no encontrado';
            header('Location: /clients');
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'id' => $id,
                'full_name' => $_POST['full_name'] ?? '',
                'dni' => $_POST['dni'] ?? '',
            ];

            if (empty($data['full_name']) || empty($data['dni'])) {
                $_SESSION['error'] = 'Todos los campos son requeridos';
                header("Location: /clients/edit/$id");
                return;
            }

            if ($this->client->update($data)) {
                $_SESSION['success'] = 'Cliente actualizado exitosamente';
                header('Location: /clients');
            } else {
                $_SESSION['error'] = 'Error al actualizar el cliente';
                header("Location: /clients/edit/$id");
            }
            return;
        }

        $this->view('clients/form', ['title' => 'Editar Cliente', 'client' => $client]);
    }

    // Eliminar cliente
    public function delete($id) {
        if ($this->client->delete($id)) {
            $_SESSION['success'] = 'Cliente eliminado exitosamente';
        } else {
            $_SESSION['error'] = 'Error al eliminar el cliente';
        }
        header('Location: /clients');
    }

    // Buscar clientes por nombre o DNI
    public function search() {
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            http_response_code(405);
            echo json_encode(["error" => "Método no permitido"]);
            return;
        }

        $term = isset($_GET['term']) ? trim($_GET['term']) : '';

        if (empty($term)) {
            echo json_encode([]);
            return;
        }

        $results = $this->client->search($term);
        header('Content-Type: application/json');
        echo json_encode($results);
    }


    public function show($id) {
    $client = $this->client->getById($id);
    
    if (!$client) {
        $_SESSION['error'] = 'Cliente no encontrado';
        header('Location: /clients');
        return;
    }

    $this->view('clients/view', ['client' => $client]);
    }

}