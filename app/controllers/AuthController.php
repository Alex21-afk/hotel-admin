<?php

require_once "../core/Controller.php";

class AuthController extends Controller {

    public function login() {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {

            $username = $_POST["username"];
            $password = $_POST["password"];

            $userModel = $this->model("User");
            $user = $userModel->findByUsername($username);

            if ($user && password_verify($password, $user["password"])) {
                session_start();
                $_SESSION["user"] = $user;
                header("Location: /dashboard");
                exit;
            }

            $error = "Usuario o contraseña incorrectos";
            View::render("auth/login", ["error" => $error]);
            return;
        }

        View::render("auth/login");
    }

    public function logout() {
        session_start();
        session_destroy();
        header("Location: /");
    }
}
