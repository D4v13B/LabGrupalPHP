<?php

header('Content-Type: application/json');

class ProductoController
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function listar()
    {
        try {
            $stmt = $this->pdo->query("SELECT * FROM productos");
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($data);
        } catch (PDOException $th) {
            echo json_encode(["error" => $th->getMessage()]);
        }
    }

    public function obtener($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM productos WHERE id = ?");
        $stmt->execute([$id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        echo json_encode($data ?: ["error" => "Producto no encontrado"]);
    }

    public function crear()
    {
        $data = json_decode(file_get_contents("php://input"), true);
        $stmt = $this->pdo->prepare("INSERT INTO productos (Codigo, Producto, Precio, Cantidad) VALUES (?, ?, ?, ?)");
        $success = $stmt->execute([
            $data['Codigo'],
            $data['Producto'],
            $data['Precio'],
            $data['Cantidad']
        ]);
        echo json_encode(["success" => $success]);
    }

    public function actualizar($data)
    {
        $stmt = $this->pdo->prepare("UPDATE productos SET Codigo=?, Producto=?, Precio=?, Cantidad=? WHERE id=?");
        $success = $stmt->execute([
            $data['Codigo'],
            $data['Producto'],
            $data['Precio'],
            $data['Cantidad'],
            $data['id']
        ]);
        echo json_encode(["success" => $success]);
    }

    public function eliminar($id)
    {
        if (!$id) {
            echo json_encode(["error" => "ID requerido"]);
            return;
        }
        $stmt = $this->pdo->prepare("DELETE FROM productos WHERE id = ?");
        $success = $stmt->execute([$id]);
        echo json_encode(["success" => $success]);
    }
}
?>