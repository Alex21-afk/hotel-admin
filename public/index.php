<?php
session_start();

// Cargar clases base
require_once "../core/Controller.php";
require_once "../core/View.php";

// Obtener la URL solicitada
$url = isset($_GET['url']) ? trim($_GET['url'], '/') : 'auth/login';

// Detectar URI completa (útil para API)
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// ------------------------------
// Rutas API (antes del router MVC)
// ------------------------------
if ($uri === '/api/clients/search') {
    require_once "../app/controllers/ApiClientsController.php";
    $controller = new ApiClientsController();
    $controller->search();
    exit;
}

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

// Ejecutar método
$controller->$method();
