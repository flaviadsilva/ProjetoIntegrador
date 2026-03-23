<?php
require_once "dao/ClienteDAO.php";
require_once "dao/ProdutoDAO.php";
require_once "dao/PedidoDAO.php";

$clienteDAO = new ClienteDAO();
$produtoDAO = new ProdutoDAO();
$pedidoDAO = new PedidoDAO();

$totalClientes = $clienteDAO->contar();
$totalProdutos = $produtoDAO->contar();
$totalPedidos = $pedidoDAO->contar();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Loja</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php include "includes/menu.php"; ?>

<div class="page">
    <div class="page-header">
        <h1>Dashboard</h1>
        <p>Visao geral do sistema</p>
    </div>

    <div class="stats">
        <a href="clientes.php" class="stat-card">
            <h3>Clientes</h3>
            <div class="number"><?= $totalClientes ?></div>
        </a>

        <a href="produtos.php" class="stat-card">
            <h3>Produtos</h3>
            <div class="number"><?= $totalProdutos ?></div>
        </a>

        <a href="pedidos.php" class="stat-card">
            <h3>Pedidos</h3>
            <div class="number"><?= $totalPedidos ?></div>
        </a>
    </div>
</div>

</body>
</html>
