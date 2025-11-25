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
        View::render("stays/index", ['active' => $active]);
    }

    /** Formulario Check-in */
    public function create() {
       
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $this->stay->createStay($_POST);

            // Cambiar estado de habitación
            $this->room->updateStatus($_POST['room_id'], "occupied");

            header("Location: /stay");
            exit;
        }

        // Clientes y habitaciones disponibles
        $clients = $this->client->getAll();
        $rooms = $this->room->getAvailable();

        View::render("stays/form_checkin", [
            'clients' => $clients,
            'rooms' => $rooms
        ]);
    }
}
