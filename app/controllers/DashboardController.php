<?php

require_once "../core/Controller.php";

class DashboardController extends Controller {

    public function index() {
        // Verificar si hay sesión iniciada
        if (!isset($_SESSION["user"])) {
            header("Location: /auth/login");
            exit;
        }

        // Obtener estadísticas
        $roomModel = $this->model("Room");
        $stayModel = $this->model("Stay");
        $reservationModel = $this->model("Reservation");
        $clientModel = $this->model("Client");

        // Contar recursos
        $totalRooms = count($roomModel->getAll());
        $availableRooms = count($roomModel->getAvailable());
        $activeStays = count($stayModel->getActive());
        $totalClients = count($clientModel->getAll());
        
        // Estadísticas de reservaciones
        $activeReservations = count($reservationModel->getActive());
        $upcomingReservations = count($reservationModel->getUpcoming());
        $pendingReservations = count($reservationModel->getAll('pending'));

        View::render("dashboard/index", [
            "user" => $_SESSION["user"],
            "stats" => [
                "totalRooms" => $totalRooms,
                "availableRooms" => $availableRooms,
                "activeStays" => $activeStays,
                "totalClients" => $totalClients,
                "activeReservations" => $activeReservations,
                "upcomingReservations" => $upcomingReservations,
                "pendingReservations" => $pendingReservations
            ]
        ]);
    }
}
