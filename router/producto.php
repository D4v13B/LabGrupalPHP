<?php

// Obtener método HTTP
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
  case 'GET':
    if (isset($_GET['id'])) {
      obtenerProducto($pdo, $_GET['id']);
    } else {
      listarProductos($pdo);
    }
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
