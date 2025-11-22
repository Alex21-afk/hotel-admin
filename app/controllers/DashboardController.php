<?php

require_once "../core/Controller.php";

class DashboardController extends Controller {

    public function index() {
        // Verificar si hay sesión iniciada
        if (!isset($_SESSION["user"])) {
            header("Location: /auth/login");
            exit;
        }

        View::render("dashboard/index", [
            "user" => $_SESSION["user"]
        ]);
    }
}
