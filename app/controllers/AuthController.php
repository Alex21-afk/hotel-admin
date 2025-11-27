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
                if (session_status() !== PHP_SESSION_ACTIVE) {
                    session_start();
                }
                $_SESSION["user"] = $user;
                $_SESSION["user_name"] = $user['name'] ?? $user['username'];
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
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        session_destroy();
        header("Location: /");
    }

    public function profile() {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        if (!isset($_SESSION['user'])) {
            header('Location: /auth/login');
            exit;
        }

        $userModel = $this->model('User');
        $userId = $_SESSION['user']['id'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $username = trim($_POST['username'] ?? '');
            $password = $_POST['password'] ?? '';

            // Validaciones básicas
            if ($username === '') {
                $error = 'El nombre de usuario no puede estar vacío.';
                View::render('users/profile', ['user' => $_SESSION['user'], 'error' => $error]);
                return;
            }

            $existing = $userModel->findByUsername($username);
            if ($existing && $existing['id'] != $userId) {
                $error = 'El nombre de usuario ya está en uso.';
                View::render('users/profile', ['user' => $_SESSION['user'], 'error' => $error]);
                return;
            }

            $updateData = [
                'name' => $name,
                'username' => $username
            ];

            if (!empty($password)) {
                $updateData['password'] = password_hash($password, PASSWORD_DEFAULT);
            }

            $ok = $userModel->updateById($userId, $updateData);

            if ($ok) {
                $user = $userModel->findById($userId);
                $_SESSION['user'] = $user;
                $_SESSION['user_name'] = $user['name'] ?? $user['username'];
                $success = 'Perfil actualizado correctamente.';
                View::render('users/profile', ['user' => $user, 'success' => $success]);
                return;
            }

            $error = 'No se pudo actualizar el perfil. Intente nuevamente.';
            View::render('users/profile', ['user' => $_SESSION['user'], 'error' => $error]);
            return;
        }

        $user = $userModel->findById($userId);
        View::render('users/profile', ['user' => $user]);
    }
}
