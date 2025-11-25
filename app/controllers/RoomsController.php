<?php

class RoomsController extends Controller {

    private $room;

    public function __construct() {
        $this->room = new Room();
    }

    public function index() {
        $rooms = $this->room->getAll();
        View::render("rooms/index", ['rooms' => $rooms]);
    }

    public function view($id) {
        $room = $this->room->find($id);
        View::render("rooms/view", ['room' => $room]);
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->room->create($_POST);
            header("Location: /hotel-admin/public/rooms");
            exit;
        }
        View::render("rooms/form");
    }

    public function edit($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->room->updateRoom($id, $_POST);
            header("Location: /hotel-admin/public/rooms");
            exit;
        }
        $room = $this->room->find($id);
        View::render("rooms/form", ['room' => $room]);
    }

    public function delete($id) {
        $this->room->deleteRoom($id);
        header("Location: /hotel-admin/public/rooms");
    }

    public function status($id, $status) {  
        $valid = ['available', 'occupied', 'maintenance'];

        if (!in_array($status, $valid)) {
            die("Estado inválido.");
    }

    $this->room->changeStatus($id, $status);
    header("Location: /hotel-admin/public/rooms");
    exit;
}

}
