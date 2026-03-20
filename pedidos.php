<?php

    require_once "classes/Cliente.php";
    require_once "classes/Produto.php";
    require_once "classes/Pedido.php";

    session_start();

    // 🔥 garantir que existem
    if (!isset($_SESSION['clientes'])) {
        $_SESSION['clientes'] = [];
    }

    if (!isset($_SESSION['produtos'])) {
        $_SESSION['produtos'] = [];
    }

    if (!isset($_SESSION['pedidos'])) {
        $_SESSION['pedidos'] = [];
    }

    // 🔥 criar pedido
    if ($_POST) {

        $clienteIndex = $_POST['cliente'];
        $produtosSelecionados = $_POST['produtos'] ?? [];

        $cliente = $_SESSION['clientes'][$clienteIndex];

        $pedido = new Pedido(rand(1000,9999), $cliente);

        foreach ($produtosSelecionados as $index) {
            $pedido->adicionarProduto($_SESSION['produtos'][$index]);
        }

        $_SESSION['pedidos'][] = $pedido;
    }
    ?>

    <!DOCTYPE html>
    <html>
    <head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    </head>
    <body>

    <?php include "includes/menu.php"; ?>

    <div class="container">

    <h2>Criar Pedido</h2>

    <form method="POST">

    <label>Cliente:</label>
    <select name="cliente" required>
    <?php foreach ($_SESSION['clientes'] as $i => $c): ?>
        <option value="<?= $i ?>"><?= $c->getNome() ?></option>
    <?php endforeach; ?>
    </select>

    <br><br>

    <label>Produtos:</label>
    <select name="produtos[]" multiple required>
    <?php foreach ($_SESSION['produtos'] as $i => $p): ?>
        <option value="<?= $i ?>">
            <?= $p->getNome() ?> - R$ <?= number_format($p->getPreco(), 2, ',', '.') ?>
        </option>
    <?php endforeach; ?>
    </select>

    <br><br>

    <button type="submit">Criar Pedido</button>

    </form>

    <hr>

    <h2>Pedidos Criados</h2>

    <?php
    if (empty($_SESSION['pedidos'])) {
        echo "<p>Nenhum pedido criado.</p>";
    } else {
        foreach ($_SESSION['pedidos'] as $p) {
            $p->exibirResumo();
        }
    }
    ?>

    </div>

    </body>
    </html>