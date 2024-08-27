<?php
include_once './utils/defaults.php';
include_once './models/DB.php';
include_once './models/Estudiante.php';

// Asegurarse de que el nombre del controlador esté correctamente capitalizado
$controller = ucfirst(strtolower($_GET['controller'])) . 'Controller';
$action = $_GET['action'];
$id = isset($_GET['id']) ? intval($_GET['id']) : null;

if (empty($action)) {
    $action = "index";
}

// Incluir el archivo del controlador
$controllerFile = "./controllers/{$controller}.php";

if (file_exists($controllerFile)) {
    include_once $controllerFile;
} else {
    die("El archivo del controlador no se encontró.");
}

// Crear una instancia del controlador y llamar a la acción
$ctrl = new $controller();

if (method_exists($ctrl, $action)) {
    $ctrl->{$action}($id);
} else {
    echo json_encode(["status" => "error", "message" => "Acción '$action' no encontrada"]);
}