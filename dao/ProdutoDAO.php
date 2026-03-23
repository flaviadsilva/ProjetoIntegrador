<?php

require_once __DIR__ . "/../config/database.php";
require_once __DIR__ . "/../models/Produto.php";

class ProdutoDAO {

    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function inserir(Produto $produto) {
        $sql = "INSERT INTO produtos (nome, preco) VALUES (:nome, :preco)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(":nome", $produto->getNome());
        $stmt->bindValue(":preco", $produto->getPreco());
        return $stmt->execute();
    }

    public function listar() {
        $sql = "SELECT * FROM produtos ORDER BY id DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        $produtos = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $produto = new Produto($row['id'], $row['nome'], $row['preco']);
            $produtos[] = $produto;
        }
        return $produtos;
    }

    public function buscarPorId($id) {
        $sql = "SELECT * FROM produtos WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(":id", $id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return new Produto($row['id'], $row['nome'], $row['preco']);
        }
        return null;
    }

    public function atualizar(Produto $produto) {
        $sql = "UPDATE produtos SET nome = :nome, preco = :preco WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(":nome", $produto->getNome());
        $stmt->bindValue(":preco", $produto->getPreco());
        $stmt->bindValue(":id", $produto->getId());
        return $stmt->execute();
    }

    public function excluir($id) {
        $sql = "DELETE FROM produtos WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(":id", $id);
        return $stmt->execute();
    }

    public function contar() {
        $sql = "SELECT COUNT(*) as total FROM produtos";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'];
    }
}
