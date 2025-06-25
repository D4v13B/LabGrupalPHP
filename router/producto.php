<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include __DIR__ . '/../utils/ConexionDB.php';
include __DIR__ . '/../controllers/producto.php';

$method = $_SERVER['REQUEST_METHOD'];


switch ($method) {
  case 'GET':
    if (isset($_GET['id'])) {
      obtenerProducto($pdo, $_GET['id']);
    } else {
      listarProductos($pdo);
    }
    echo json_encode(["Hola" => "Mundo"]);
    break;

  case 'POST':
    crearProducto($pdo);
    break;

  case 'PUT':
    parse_str(file_get_contents("php://input"), $_PUT);
    actualizarProducto($pdo, $_PUT);
    break;

  case 'DELETE':
    parse_str(file_get_contents("php://input"), $_DELETE);
    eliminarProducto($pdo, $_DELETE['id'] ?? null);
    break;

  default:
    http_response_code(405);
    echo json_encode(['error' => 'Método no permitido']);
    break;
}
