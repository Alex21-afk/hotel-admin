<?php
session_start();

// Cargar el controlador base
require_once "../core/Controller.php";
require_once "../core/View.php";

// Obtener la URL (ruta)
$url = isset($_GET['url']) ? $_GET['url'] : 'auth/login';

// Quitar "/" final si existe
$url = rtrim($url, '/');

// Dividir en partes
$parts = explode("/", $url);

// Controlador y método
$controllerName = ucfirst($parts[0]) . "Controller";
$method = $parts[1] ?? "index";

// Cargar controlador
$file = "../app/controllers/$controllerName.php";

if (file_exists($file)) {
    require_once $file;
    $controller = new $controllerName();

    // Verificar si el método existe
    if (method_exists($controller, $method)) {
        $controller->$method();
    } else {
        echo "Método '$method' no encontrado en $controllerName";
    }
} else {
    echo "Controlador '$controllerName' no encontrado.";
}
