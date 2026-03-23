<?php

require_once __DIR__ . "/../config/database.php";
require_once __DIR__ . "/../models/Cliente.php";

class ClienteDAO {

    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function inserir(Cliente $cliente) {
        $sql = "INSERT INTO clientes (nome, email) VALUES (:nome, :email)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(":nome", $cliente->getNome());
        $stmt->bindValue(":email", $cliente->getEmail());
        return $stmt->execute();
    }

    public function listar() {
        $sql = "SELECT * FROM clientes ORDER BY id DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        $clientes = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $cliente = new Cliente($row['id'], $row['nome'], $row['email']);
            $clientes[] = $cliente;
        }
        return $clientes;
    }

    public function buscarPorId($id) {
        $sql = "SELECT * FROM clientes WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(":id", $id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return new Cliente($row['id'], $row['nome'], $row['email']);
        }
        return null;
    }

    public function atualizar(Cliente $cliente) {
        $sql = "UPDATE clientes SET nome = :nome, email = :email WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(":nome", $cliente->getNome());
        $stmt->bindValue(":email", $cliente->getEmail());
        $stmt->bindValue(":id", $cliente->getId());
        return $stmt->execute();
    }

    public function excluir($id) {
        $sql = "DELETE FROM clientes WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(":id", $id);
        return $stmt->execute();
    }

    public function contar() {
        $sql = "SELECT COUNT(*) as total FROM clientes";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'];
    }
}
