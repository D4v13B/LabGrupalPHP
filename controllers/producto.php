<?php
require 'conexion.php';
require 'Producto.php';

header('Content-Type: application/json');

$pdo = conectar(); // función definida en conexion.php
$producto = new Producto($pdo);

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

// Métodos REST

function listarProductos($pdo) {
    $stmt = $pdo->query("SELECT * FROM productos");
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($data);
}

function obtenerProducto($pdo, $id) {
    $stmt = $pdo->prepare("SELECT * FROM productos WHERE id = ?");
    $stmt->execute([$id]);
    $data = $stmt->fetch(PDO::FETCH_ASSOC);
    echo json_encode($data ?: ["error" => "Producto no encontrado"]);
}

function crearProducto($pdo) {
    $data = json_decode(file_get_contents("php://input"), true);
    $stmt = $pdo->prepare("INSERT INTO productos (Codigo, Producto, Precio, Cantidad) VALUES (?, ?, ?, ?)");
    $success = $stmt->execute([
        $data['Codigo'],
        $data['Producto'],
        $data['Precio'],
        $data['Cantidad']
    ]);
    echo json_encode(["success" => $success]);
}

function actualizarProducto($pdo, $data) {
    $stmt = $pdo->prepare("UPDATE productos SET Codigo=?, Producto=?, Precio=?, Cantidad=? WHERE id=?");
    $success = $stmt->execute([
        $data['Codigo'],
        $data['Producto'],
        $data['Precio'],
        $data['Cantidad'],
        $data['id']
    ]);
    echo json_encode(["success" => $success]);
}

function eliminarProducto($pdo, $id) {
    if (!$id) {
        echo json_encode(["error" => "ID requerido"]);
        return;
    }
    $stmt = $pdo->prepare("DELETE FROM productos WHERE id = ?");
    $success = $stmt->execute([$id]);
    echo json_encode(["success" => $success]);
}
?>
