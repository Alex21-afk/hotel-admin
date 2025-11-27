<?php
session_start();

// Cargar configuración de BD
require_once "../config/database.php";

// Cargar clases base
require_once "../core/Controller.php";
require_once "../core/View.php";

// Cargar modelos
require_once "../app/models/Model.php";
require_once "../app/models/User.php";
require_once "../app/models/Client.php";
require_once "../app/models/Room.php";
require_once "../app/models/Stay.php";

// Obtener la URL solicitada
$url = isset($_GET['url']) ? trim($_GET['url'], '/') : 'auth/login';

// ------------------------------
// Router MVC tradicional
// ------------------------------
$parts = explode("/", $url);

// Mapear controladores si hay singular/plural o nombres especiales
$mapControllers = [
    'stay' => 'StaysController',
    'stays' => 'StaysController',
    'client' => 'ClientsController',
    'clients' => 'ClientsController',
    'room' => 'RoomsController',
    'rooms' => 'RoomsController',
    'auth' => 'AuthController',
    'dashboard' => 'DashboardController',
    // agrega más según necesites
];

// Controlador y método
$controllerKey = $parts[0];
$controllerName = $mapControllers[$controllerKey] ?? ucfirst($controllerKey) . "Controller";
$method = $parts[1] ?? "index";

// Archivo del controlador
$controllerFile = "../app/controllers/$controllerName.php";

// Verificar si existe el controlador
if (!file_exists($controllerFile)) {
    die("Controlador '$controllerName' no encontrado.");
}

require_once $controllerFile;

$controller = new $controllerName();

// Verificar si el método existe
if (!method_exists($controller, $method)) {
    die("Método '$method' no encontrado en $controllerName.");
}

// Obtener parámetros adicionales (como el ID)
$params = array_slice($parts, 2);

// Ejecutar método con parámetros
call_user_func_array([$controller, $method], $params);