<?php

require "./utils/ConexionDB.php";


header('Content-Type: application/json');

$pdo = $db_con->getConexion(); // función definida en conexion.php
$producto = new Producto($pdo);


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
