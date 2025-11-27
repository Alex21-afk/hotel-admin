<?php

class RoomsController extends Controller {

    private $room;

    public function __construct() {
        $this->room = new Room();
    }

    public function index() {
        $rooms = $this->room->getAll();
        $this->view('rooms/index', ['rooms' => $rooms]);
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'code' => $_POST['code'] ?? '',
                'floor' => $_POST['floor'] ?? '',
                'description' => $_POST['description'] ?? '',
                'price' => $_POST['price'] ?? 0,
                'status' => $_POST['status'] ?? 'available'
            ];

            if (empty($data['code']) || empty($data['price'])) {
                $_SESSION['error'] = 'El código y precio son requeridos';
                header('Location: /rooms/create');
                return;
            }

            if ($this->room->create($data)) {
                $_SESSION['success'] = 'Habitación creada exitosamente';
                header('Location: /rooms');
            } else {
                $_SESSION['error'] = 'Error al crear la habitación';
                header('Location: /rooms/create');
            }
            return;
        }

        $this->view('rooms/form', ['title' => 'Nueva Habitación']);
    }

    public function edit($id) {
        $room = $this->room->getById($id);
        
        if (!$room) {
            $_SESSION['error'] = 'Habitación no encontrada';
            header('Location: /rooms');
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'id' => $id,
                'code' => $_POST['code'] ?? '',
                'floor' => $_POST['floor'] ?? '',
                'description' => $_POST['description'] ?? '',
                'price' => $_POST['price'] ?? 0,
                'status' => $_POST['status'] ?? 'available'
            ];

            if (empty($data['code']) || empty($data['price'])) {
                $_SESSION['error'] = 'El código y precio son requeridos';
                header("Location: /rooms/edit/$id");
                return;
            }

            if ($this->room->update($data)) {
                $_SESSION['success'] = 'Habitación actualizada exitosamente';
                header('Location: /rooms');
            } else {
                $_SESSION['error'] = 'Error al actualizar la habitación';
                header("Location: /rooms/edit/$id");
            }
            return;
        }

        $this->view('rooms/form', ['title' => 'Editar Habitación', 'room' => $room]);
    }

    public function delete($id) {
        if ($this->room->delete($id)) {
            $_SESSION['success'] = 'Habitación eliminada exitosamente';
        } else {
            $_SESSION['error'] = 'Error al eliminar la habitación';
        }
        header('Location: /rooms');
    }

    public function status($id, $status) {  
        $valid = ['available', 'occupied', 'maintenance'];

        if (!in_array($status, $valid)) {
            $_SESSION['error'] = 'Estado inválido';
            header('Location: /rooms');
            return;
        }

        if ($this->room->changeStatus($id, $status)) {
            $_SESSION['success'] = 'Estado actualizado exitosamente';
        } else {
            $_SESSION['error'] = 'Error al actualizar el estado';
        }
        header('Location: /rooms');
    }

}
