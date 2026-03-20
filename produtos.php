<?php

require_once "classes/Produto.php";
session_start();

// 🔥 IMPORTANTE (usa só uma vez se der erro)
if (!isset($_SESSION['produtos'])) {
    $_SESSION['produtos'] = [];
}

// Cadastro
if ($_POST) {
    $id = count($_SESSION['produtos']) + 1;
    $nome = $_POST['nome'];
    $preco = $_POST['preco'];

    $produto = new Produto($id, $nome, $preco);

    $_SESSION['produtos'][] = $produto;
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

<h2>Cadastro de Produto</h2>

<form method="POST">
    <input type="text" name="nome" placeholder="Nome do produto" required>
    <input type="number" step="0.01" name="preco" placeholder="Preço" required>
    <button type="submit">Cadastrar</button>
</form>

<h3>Lista de Produtos</h3>

<?php
if (empty($_SESSION['produtos'])) {
    echo "<p>Nenhum produto cadastrado.</p>";
} else {
    foreach ($_SESSION['produtos'] as $p) {
        echo "<p>";
        echo $p->getNome() . " - R$ " . number_format($p->getPreco(), 2, ',', '.');
        echo "</p>";
    }
}
?>

</div>

</body>
</html>