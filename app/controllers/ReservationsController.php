<?php

class ReservationsController extends Controller {

    private $reservation;
    private $room;
    private $client;

    public function __construct() {
        $this->reservation = $this->model("Reservation");
        $this->room = $this->model("Room");
        $this->client = $this->model("Client");
    }

    /** Página principal - Lista de reservaciones */
    public function index() {
        $filter = $_GET['filter'] ?? 'all';
        
        if ($filter === 'active') {
            $reservations = $this->reservation->getActive();
        } elseif ($filter === 'upcoming') {
            $reservations = $this->reservation->getUpcoming();
        } elseif (in_array($filter, ['pending', 'confirmed', 'cancelled', 'completed'])) {
            $reservations = $this->reservation->getAll($filter);
        } else {
            $reservations = $this->reservation->getAll();
        }
        
        parent::view('reservations/index', [
            'reservations' => $reservations,
            'currentFilter' => $filter
        ]);
    }

    /** Crear nueva reservación */
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $blocks = (int)$_POST['blocks'];
            $roomId = $_POST['room_id'];
            
            // Obtener precio del cuarto
            $room = $this->room->getById($roomId);
            if (!$room) {
                $_SESSION['error'] = 'Cuarto no encontrado';
                header("Location: /reservations/create");
                exit;
            }
            
            // Calcular total
            $calculation = $this->reservation->calculateTotal($blocks, $room['price']);
            
            // Calcular fecha de fin
            $startDate = $_POST['reservation_date'];
            $endDate = date('Y-m-d H:i:s', strtotime($startDate . ' + ' . ($blocks * 12) . ' hours'));
            
            // Verificar disponibilidad
            if (!$this->reservation->isRoomAvailable($roomId, $startDate, $endDate)) {
                $_SESSION['error'] = 'El cuarto no está disponible en ese horario';
                header("Location: /reservations/create");
                exit;
            }
            
            // Crear reservación
            $data = [
                'client_id' => $_POST['client_id'],
                'room_id' => $roomId,
                'reservation_date' => $startDate,
                'blocks' => $blocks,
                'total_amount' => $calculation['total'],
                'status' => 'pending',
                'note' => $_POST['note'] ?? null
            ];
            
            if ($this->reservation->create($data)) {
                $_SESSION['success'] = 'Reservación creada exitosamente. Total: S/ ' . number_format($calculation['total'], 2);
                header("Location: /reservations");
            } else {
                $_SESSION['error'] = 'Error al crear la reservación';
                header("Location: /reservations/create");
            }
            exit;
        }

        // GET: Mostrar formulario
        $clients = $this->client->getAll();
        $rooms = $this->room->getAll();
        
        parent::view('reservations/form', [
            'clients' => $clients,
            'rooms' => $rooms,
            'action' => 'create'
        ]);
    }

    /** Ver detalles de una reservación */
    public function show($id) {
        $reservation = $this->reservation->find($id);
        
        if (!$reservation) {
            $_SESSION['error'] = 'Reservación no encontrada';
            header('Location: /reservations');
            exit;
        }
        
        parent::view('reservations/view', ['reservation' => $reservation]);
    }

    /** Confirmar reservación */
    public function confirm($id) {
        $reservation = $this->reservation->find($id);
        
        if (!$reservation) {
            $_SESSION['error'] = 'Reservación no encontrada';
            header('Location: /reservations');
            exit;
        }
        
        if ($reservation['status'] !== 'pending') {
            $_SESSION['error'] = 'Solo se pueden confirmar reservaciones pendientes';
            header('Location: /reservations');
            exit;
        }
        
        if ($this->reservation->confirm($id)) {
            $_SESSION['success'] = 'Reservación confirmada exitosamente';
        } else {
            $_SESSION['error'] = 'Error al confirmar la reservación';
        }
        
        header('Location: /reservations/show/' . $id);
        exit;
    }

    /** Cancelar reservación */
    public function cancel($id) {
        $reservation = $this->reservation->find($id);
        
        if (!$reservation) {
            $_SESSION['error'] = 'Reservación no encontrada';
            header('Location: /reservations');
            exit;
        }
        
        if (!in_array($reservation['status'], ['pending', 'confirmed'])) {
            $_SESSION['error'] = 'No se puede cancelar esta reservación';
            header('Location: /reservations');
            exit;
        }
        
        if ($this->reservation->cancel($id)) {
            $_SESSION['success'] = 'Reservación cancelada exitosamente';
        } else {
            $_SESSION['error'] = 'Error al cancelar la reservación';
        }
        
        header('Location: /reservations/show/' . $id);
        exit;
    }

    /** Completar reservación */
    public function complete($id) {
        $reservation = $this->reservation->find($id);
        
        if (!$reservation) {
            $_SESSION['error'] = 'Reservación no encontrada';
            header('Location: /reservations');
            exit;
        }
        
        if ($reservation['status'] !== 'confirmed') {
            $_SESSION['error'] = 'Solo se pueden completar reservaciones confirmadas';
            header('Location: /reservations');
            exit;
        }
        
        if ($this->reservation->complete($id)) {
            $_SESSION['success'] = 'Reservación completada exitosamente';
        } else {
            $_SESSION['error'] = 'Error al completar la reservación';
        }
        
        header('Location: /reservations/show/' . $id);
        exit;
    }

    /** Editar reservación */
    public function edit($id) {
        $reservation = $this->reservation->find($id);
        
        if (!$reservation) {
            $_SESSION['error'] = 'Reservación no encontrada';
            header('Location: /reservations');
            exit;
        }
        
        if (!in_array($reservation['status'], ['pending', 'confirmed'])) {
            $_SESSION['error'] = 'No se puede editar esta reservación';
            header('Location: /reservations');
            exit;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $blocks = (int)$_POST['blocks'];
            $roomId = $_POST['room_id'];
            
            // Obtener precio del cuarto
            $room = $this->room->getById($roomId);
            if (!$room) {
                $_SESSION['error'] = 'Cuarto no encontrado';
                header("Location: /reservations/edit/" . $id);
                exit;
            }
            
            // Calcular total
            $calculation = $this->reservation->calculateTotal($blocks, $room['price']);
            
            // Calcular fecha de fin
            $startDate = $_POST['reservation_date'];
            $endDate = date('Y-m-d H:i:s', strtotime($startDate . ' + ' . ($blocks * 12) . ' hours'));
            
            // Verificar disponibilidad (excluyendo esta reservación)
            if (!$this->reservation->isRoomAvailable($roomId, $startDate, $endDate, $id)) {
                $_SESSION['error'] = 'El cuarto no está disponible en ese horario';
                header("Location: /reservations/edit/" . $id);
                exit;
            }
            
            // Actualizar reservación
            $data = [
                'client_id' => $_POST['client_id'],
                'room_id' => $roomId,
                'reservation_date' => $startDate,
                'blocks' => $blocks,
                'total_amount' => $calculation['total'],
                'note' => $_POST['note'] ?? null
            ];
            
            if ($this->reservation->update($id, $data)) {
                $_SESSION['success'] = 'Reservación actualizada exitosamente';
                header("Location: /reservations/show/" . $id);
            } else {
                $_SESSION['error'] = 'Error al actualizar la reservación';
                header("Location: /reservations/edit/" . $id);
            }
            exit;
        }

        // GET: Mostrar formulario
        $clients = $this->client->getAll();
        $rooms = $this->room->getAll();
        
        parent::view('reservations/form', [
            'clients' => $clients,
            'rooms' => $rooms,
            'reservation' => $reservation,
            'action' => 'edit'
        ]);
    }

    /** API: Verificar disponibilidad de cuarto */
    public function checkAvailability() {
        header('Content-Type: application/json');
        
        $roomId = $_GET['room_id'] ?? null;
        $startDate = $_GET['start_date'] ?? null;
        $blocks = (int)($_GET['blocks'] ?? 1);
        
        if (!$roomId || !$startDate) {
            echo json_encode(['available' => false, 'message' => 'Parámetros incompletos']);
            exit;
        }
        
        $endDate = date('Y-m-d H:i:s', strtotime($startDate . ' + ' . ($blocks * 12) . ' hours'));
        $available = $this->reservation->isRoomAvailable($roomId, $startDate, $endDate);
        
        echo json_encode([
            'available' => $available,
            'message' => $available ? 'Cuarto disponible' : 'Cuarto no disponible en ese horario'
        ]);
        exit;
    }
}
