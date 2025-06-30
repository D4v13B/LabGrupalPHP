<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include __DIR__ . '/../utils/ConexionDB.php';
include __DIR__ . '/../controllers/producto.php';

// $pdo = ConexionDB::getConnection();
$controller = new ProductoController($pdo);

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
  case 'GET':
    if (isset($_GET['id'])) {
      $controller->obtener($_GET['id']);
    } else {
      $controller->listar();
    }
    break;

  case 'POST':
    $controller->crear();
    break;

  case 'PUT':
    $data = json_decode(file_get_contents("php://input"), true);
    $controller->actualizar($data);
    break;

  case 'DELETE':
    $data = json_decode(file_get_contents("php://input"), true);
    $controller->eliminar($data['id'] ?? null);
    break;

  default:
    http_response_code(405);
    echo json_encode(['error' => 'Método no permitido']);
    break;
}