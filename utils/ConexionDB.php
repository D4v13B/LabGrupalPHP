<?php

class ConexionDB
{
  private $host = 'localhost';
  private $db   = 'nombre_base_datos';
  private $user = 'usuario';
  private $pass = 'contraseña';
  private $charset = 'utf8mb4';
  private $pdo;
  private $error;

  public function __construct()
  {
    $dsn = "mysql:host={$this->host};dbname={$this->db};charset={$this->charset}";
    $options = [
      PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
      PDO::ATTR_EMULATE_PREPARES   => false,
    ];
    try {
      $this->pdo = new PDO($dsn, $this->user, $this->pass, $options);
    } catch (PDOException $e) {
      $this->error = $e->getMessage();
      throw new Exception("Error de conexión: " . $this->error);
    }
  }

  public function getConexion()
  {
    return $this->pdo;
  }
}
