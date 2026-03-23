<?php

require_once __DIR__ . "/../config/database.php";
require_once __DIR__ . "/../models/Pedido.php";
require_once __DIR__ . "/../models/Produto.php";

class PedidoDAO {

    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function inserir($clienteId, $produtoIds) {
        try {
            $this->conn->beginTransaction();

            $sql = "INSERT INTO pedidos (cliente_id) VALUES (:cliente_id)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(":cliente_id", $clienteId);
            $stmt->execute();

            $pedidoId = $this->conn->lastInsertId();

            $sql = "INSERT INTO pedido_produtos (pedido_id, produto_id) VALUES (:pedido_id, :produto_id)";
            $stmt = $this->conn->prepare($sql);

            foreach ($produtoIds as $produtoId) {
                $stmt->bindValue(":pedido_id", $pedidoId);
                $stmt->bindValue(":produto_id", $produtoId);
                $stmt->execute();
            }

            $this->conn->commit();
            return $pedidoId;

        } catch (Exception $e) {
            $this->conn->rollBack();
            return false;
        }
    }

    public function listar() {
        $sql = "SELECT p.id, p.cliente_id, p.data_criacao, c.nome as cliente_nome,
                       COALESCE(SUM(pr.preco), 0) as total
                FROM pedidos p
                JOIN clientes c ON p.cliente_id = c.id
                LEFT JOIN pedido_produtos pp ON p.id = pp.pedido_id
                LEFT JOIN produtos pr ON pp.produto_id = pr.id
                GROUP BY p.id, p.cliente_id, p.data_criacao, c.nome
                ORDER BY p.id DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        $pedidos = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $pedido = new Pedido($row['id'], $row['cliente_id'], $row['data_criacao']);
            $pedido->setClienteNome($row['cliente_nome']);
            $pedido->setTotal($row['total']);
            $pedidos[] = $pedido;
        }
        return $pedidos;
    }

    public function buscarPorId($id) {
        $sql = "SELECT p.id, p.cliente_id, p.data_criacao, c.nome as cliente_nome
                FROM pedidos p
                JOIN clientes c ON p.cliente_id = c.id
                WHERE p.id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(":id", $id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) return null;

        $pedido = new Pedido($row['id'], $row['cliente_id'], $row['data_criacao']);
        $pedido->setClienteNome($row['cliente_nome']);

        $sql = "SELECT pr.* FROM produtos pr
                JOIN pedido_produtos pp ON pr.id = pp.produto_id
                WHERE pp.pedido_id = :pedido_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(":pedido_id", $id);
        $stmt->execute();

        $produtos = [];
        while ($r = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $produtos[] = new Produto($r['id'], $r['nome'], $r['preco']);
        }
        $pedido->setProdutos($produtos);
        $pedido->calcularTotal();

        return $pedido;
    }

    public function excluir($id) {
        try {
            $this->conn->beginTransaction();

            $sql = "DELETE FROM pedido_produtos WHERE pedido_id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(":id", $id);
            $stmt->execute();

            $sql = "DELETE FROM pedidos WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(":id", $id);
            $stmt->execute();

            $this->conn->commit();
            return true;

        } catch (Exception $e) {
            $this->conn->rollBack();
            return false;
        }
    }

    public function contar() {
        $sql = "SELECT COUNT(*) as total FROM pedidos";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'];
    }
}
