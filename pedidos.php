<?php
require_once "dao/PedidoDAO.php";
require_once "dao/ClienteDAO.php";
require_once "dao/ProdutoDAO.php";

$pedidoDAO = new PedidoDAO();
$clienteDAO = new ClienteDAO();
$produtoDAO = new ProdutoDAO();

$mensagem = "";
$tipo = "";

// Excluir
if (isset($_GET['excluir'])) {
    $id = (int)$_GET['excluir'];
    if ($pedidoDAO->excluir($id)) {
        $mensagem = "Pedido excluido com sucesso.";
        $tipo = "success";
    } else {
        $mensagem = "Erro ao excluir pedido.";
        $tipo = "error";
    }
}

// Criar pedido
if (isset($_POST['salvar'])) {
    $clienteId = (int)$_POST['cliente_id'];
    $produtoIds = $_POST['produtos'] ?? [];

    if ($clienteId > 0 && !empty($produtoIds)) {
        $produtoIds = array_map('intval', $produtoIds);
        if ($pedidoDAO->inserir($clienteId, $produtoIds)) {
            $mensagem = "Pedido criado com sucesso.";
            $tipo = "success";
        } else {
            $mensagem = "Erro ao criar pedido.";
            $tipo = "error";
        }
    } else {
        $mensagem = "Selecione um cliente e ao menos um produto.";
        $tipo = "error";
    }
}

$pedidos = $pedidoDAO->listar();
$clientes = $clienteDAO->listar();
$produtos = $produtoDAO->listar();

// Detalhe do pedido
$pedidoDetalhe = null;
if (isset($_GET['ver'])) {
    $pedidoDetalhe = $pedidoDAO->buscarPorId((int)$_GET['ver']);
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedidos - Sistema de Loja</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php include "includes/menu.php"; ?>

<div class="page">
    <div class="page-header">
        <h1>Pedidos</h1>
        <p>Gerencie seus pedidos</p>
    </div>

    <?php if ($mensagem): ?>
        <div class="alert alert-<?= $tipo ?>"><?= htmlspecialchars($mensagem) ?></div>
    <?php endif; ?>

    <?php if ($pedidoDetalhe): ?>
        <div class="detail-card">
            <h2 style="font-size:16px; font-weight:600; margin-bottom:16px;">
                Pedido #<?= $pedidoDetalhe->getId() ?>
            </h2>
            <div class="detail-row">
                <span class="detail-label">Cliente</span>
                <span class="detail-value"><?= htmlspecialchars($pedidoDetalhe->getClienteNome()) ?></span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Data</span>
                <span class="detail-value"><?= date('d/m/Y H:i', strtotime($pedidoDetalhe->getDataCriacao())) ?></span>
            </div>

            <h3 style="font-size:13px; font-weight:500; color:#737373; text-transform:uppercase; letter-spacing:0.5px; margin:16px 0 8px;">
                Produtos
            </h3>
            <?php foreach ($pedidoDetalhe->getProdutos() as $prod): ?>
                <div class="detail-row">
                    <span class="detail-label"><?= htmlspecialchars($prod->getNome()) ?></span>
                    <span class="detail-value">R$ <?= number_format($prod->getPreco(), 2, ',', '.') ?></span>
                </div>
            <?php endforeach; ?>

            <div class="detail-row total-row">
                <span>Total</span>
                <span>R$ <?= number_format($pedidoDetalhe->getTotal(), 2, ',', '.') ?></span>
            </div>

            <a href="pedidos.php" class="btn btn-primary" style="margin-top:16px;">Voltar</a>
        </div>
    <?php endif; ?>

    <div class="form-card">
        <h2>Novo Pedido</h2>
        <?php if (empty($clientes) || empty($produtos)): ?>
            <p style="color:#737373; font-size:14px;">
                Cadastre ao menos um cliente e um produto antes de criar pedidos.
            </p>
        <?php else: ?>
            <form method="POST" action="pedidos.php">
                <div class="form-row">
                    <div class="form-group">
                        <label>Cliente</label>
                        <select name="cliente_id" required>
                            <option value="">Selecione...</option>
                            <?php foreach ($clientes as $c): ?>
                                <option value="<?= $c->getId() ?>"><?= htmlspecialchars($c->getNome()) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Produtos (segure Ctrl para selecionar varios)</label>
                        <select name="produtos[]" multiple required>
                            <?php foreach ($produtos as $p): ?>
                                <option value="<?= $p->getId() ?>">
                                    <?= htmlspecialchars($p->getNome()) ?> - R$ <?= number_format($p->getPreco(), 2, ',', '.') ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <button type="submit" name="salvar" class="btn btn-primary">Criar Pedido</button>
            </form>
        <?php endif; ?>
    </div>

    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Cliente</th>
                    <th>Data</th>
                    <th>Total</th>
                    <th>Acoes</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($pedidos)): ?>
                    <tr>
                        <td colspan="5" class="empty-state">Nenhum pedido criado.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($pedidos as $p): ?>
                        <tr>
                            <td>#<?= $p->getId() ?></td>
                            <td><?= htmlspecialchars($p->getClienteNome()) ?></td>
                            <td><?= date('d/m/Y', strtotime($p->getDataCriacao())) ?></td>
                            <td>R$ <?= number_format($p->getTotal(), 2, ',', '.') ?></td>
                            <td>
                                <div class="actions">
                                    <a href="pedidos.php?ver=<?= $p->getId() ?>" class="btn btn-edit">Ver</a>
                                    <a href="pedidos.php?excluir=<?= $p->getId() ?>" class="btn btn-danger"
                                       onclick="return confirm('Excluir este pedido?')">Excluir</a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
