<?php

// 🔥 PRIMEIRO carrega a classe
require_once "classes/Cliente.php";

// 🔥 DEPOIS inicia a sessão
session_start();

// 🔥 garante array
$_SESSION['clientes'] = $_SESSION['clientes'] ?? [];

// 🔥 cadastro
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nome = $_POST['nome'] ?? '';
    $email = $_POST['email'] ?? '';

    if (!empty($nome) && !empty($email)) {
        $id = count($_SESSION['clientes']) + 1;

        $cliente = new Cliente($id, $nome, $email);

        $_SESSION['clientes'][] = $cliente;
    }
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

<h2>Cadastro de Cliente</h2>

<form method="POST">
    <input type="text" name="nome" placeholder="Nome" required>
    <input type="email" name="email" placeholder="Email" required>
    <button type="submit">Cadastrar</button>
</form>

<h3>Lista de Clientes</h3>

<?php
if (empty($_SESSION['clientes'])) {
    echo "<p>Nenhum cliente cadastrado.</p>";
} else {
    foreach ($_SESSION['clientes'] as $c) {
        echo "<p>";
        echo $c->getNome() . " - " . $c->getEmail();
        echo "</p>";
    }
}
?>

</div>

</body>
</html>