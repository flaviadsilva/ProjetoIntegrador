<?php
session_start();

// garantir dados
$totalClientes = isset($_SESSION['clientes']) ? count($_SESSION['clientes']) : 0;
$totalProdutos = isset($_SESSION['produtos']) ? count($_SESSION['produtos']) : 0;
$totalPedidos  = isset($_SESSION['pedidos'])  ? count($_SESSION['pedidos'])  : 0;
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Sistema de Loja</title>
<link rel="stylesheet" href="style.css">
</head>
<body>

<?php include "includes/menu.php"; ?>

<div class="container">

    <h1>🛒 Sistema de Loja</h1>

    <p class="subtitulo">
        Gerencie clientes, produtos e pedidos de forma simples e organizada.
    </p>

    <div class="cards">

        <div class="card">
            <h2>Clientes</h2>
            <span><?= $totalClientes ?></span>
            <a href="clientes.php">Ver clientes</a>
        </div>

        <div class="card">
            <h2>Produtos</h2>
            <span><?= $totalProdutos ?></span>
            <a href="produtos.php">Ver produtos</a>
        </div>

        <div class="card">
            <h2>Pedidos</h2>
            <span><?= $totalPedidos ?></span>
            <a href="pedidos.php">Ver pedidos</a>
        </div>

    </div>

</div>

</body>
</html>