<?php
$pagina_atual = basename($_SERVER['PHP_SELF']);
?>
<nav class="navbar">
    <a href="index.php" class="navbar-brand">Sistema de Loja</a>
    <div class="navbar-links">
        <a href="index.php" class="<?= $pagina_atual == 'index.php' ? 'active' : '' ?>">Inicio</a>
        <a href="clientes.php" class="<?= $pagina_atual == 'clientes.php' ? 'active' : '' ?>">Clientes</a>
        <a href="produtos.php" class="<?= $pagina_atual == 'produtos.php' ? 'active' : '' ?>">Produtos</a>
        <a href="pedidos.php" class="<?= $pagina_atual == 'pedidos.php' ? 'active' : '' ?>">Pedidos</a>
    </div>
</nav>
