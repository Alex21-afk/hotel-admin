<?php

class StaysController extends Controller {

    private $stay;
    private $room;
    private $client;

    public function __construct() {
    $this->stay = $this->model("Stay");
    $this->room = $this->model("Room");
    $this->client = $this->model("Client");
}

    /** Página con estancias activas */
    public function index() {
        $active = $this->stay->getActive();
        $this->view('stays/index', ['active' => $active]);
    }

    /** Formulario Check-in */
    public function create() {
       
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $this->stay->createStay($_POST);

            // Cambiar estado de habitación
            $this->room->updateStatus($_POST['room_id'], "occupied");

            $_SESSION['success'] = 'Check-in registrado exitosamente';
            header("Location: /stays");
            exit;
        }

        // Clientes y habitaciones disponibles
        $clients = $this->client->getAll();
        $rooms = $this->room->getAvailable();

        $this->view('stays/form_checkin', [
            'clients' => $clients,
            'rooms' => $rooms
        ]);
    }

    /** Realizar Check-out */
    public function checkout($id) {
        $stay = $this->stay->find($id);
        
        if (!$stay) {
            $_SESSION['error'] = 'Estancia no encontrada';
            header('Location: /stays');
            return;
        }

        if ($stay['check_out']) {
            $_SESSION['error'] = 'Esta estancia ya tiene check-out';
            header('Location: /stays');
            return;
        }

        // Calcular el total
        $calculation = $this->stay->calculateTotal($stay['check_in'], $stay['price']);
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Realizar checkout
            if ($this->stay->checkout($id, $calculation['total'])) {
                // Liberar habitación
                $this->room->updateStatus($stay['room_id'], 'available');
                
                $_SESSION['success'] = 'Check-out realizado exitosamente. Total: S/ ' . number_format($calculation['total'], 2);
                header('Location: /stays');
            } else {
                $_SESSION['error'] = 'Error al realizar el check-out';
                header('Location: /stays');
            }
            return;
        }

        // Mostrar vista de confirmación
        $this->view('stays/checkout', [
            'stay' => $stay,
            'calculation' => $calculation
        ]);
    }
}
