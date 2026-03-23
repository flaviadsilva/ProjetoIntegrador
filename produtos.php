<?php
require_once "dao/ProdutoDAO.php";

$produtoDAO = new ProdutoDAO();
$mensagem = "";
$tipo = "";

// Excluir
if (isset($_GET['excluir'])) {
    $id = (int)$_GET['excluir'];
    if ($produtoDAO->excluir($id)) {
        $mensagem = "Produto excluido com sucesso.";
        $tipo = "success";
    } else {
        $mensagem = "Erro ao excluir. Verifique se o produto esta vinculado a pedidos.";
        $tipo = "error";
    }
}

// Buscar produto para edicao
$produtoEdicao = null;
if (isset($_GET['editar'])) {
    $produtoEdicao = $produtoDAO->buscarPorId((int)$_GET['editar']);
}

// Salvar (inserir ou atualizar)
if (isset($_POST['salvar'])) {
    $nome = trim($_POST['nome']);
    $preco = floatval($_POST['preco']);

    if (!empty($nome) && $preco >= 0) {
        if (!empty($_POST['id'])) {
            $produto = new Produto((int)$_POST['id'], $nome, $preco);
            if ($produtoDAO->atualizar($produto)) {
                $mensagem = "Produto atualizado com sucesso.";
                $tipo = "success";
                $produtoEdicao = null;
            } else {
                $mensagem = "Erro ao atualizar.";
                $tipo = "error";
            }
        } else {
            $produto = new Produto(null, $nome, $preco);
            if ($produtoDAO->inserir($produto)) {
                $mensagem = "Produto cadastrado com sucesso.";
                $tipo = "success";
            } else {
                $mensagem = "Erro ao cadastrar.";
                $tipo = "error";
            }
        }
    }
}

$produtos = $produtoDAO->listar();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produtos - Sistema de Loja</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php include "includes/menu.php"; ?>

<div class="page">
    <div class="page-header">
        <h1>Produtos</h1>
        <p>Gerencie seus produtos</p>
    </div>

    <?php if ($mensagem): ?>
        <div class="alert alert-<?= $tipo ?>"><?= htmlspecialchars($mensagem) ?></div>
    <?php endif; ?>

    <div class="form-card">
        <h2><?= $produtoEdicao ? "Editar Produto" : "Novo Produto" ?></h2>
        <form method="POST" action="produtos.php">
            <?php if ($produtoEdicao): ?>
                <input type="hidden" name="id" value="<?= $produtoEdicao->getId() ?>">
            <?php endif; ?>
            <div class="form-row">
                <div class="form-group">
                    <label>Nome</label>
                    <input type="text" name="nome" placeholder="Nome do produto" required
                           value="<?= $produtoEdicao ? htmlspecialchars($produtoEdicao->getNome()) : '' ?>">
                </div>
                <div class="form-group">
                    <label>Preco (R$)</label>
                    <input type="number" step="0.01" min="0" name="preco" placeholder="0.00" required
                           value="<?= $produtoEdicao ? $produtoEdicao->getPreco() : '' ?>">
                </div>
            </div>
            <button type="submit" name="salvar" class="btn btn-primary">
                <?= $produtoEdicao ? "Atualizar" : "Cadastrar" ?>
            </button>
        </form>
    </div>

    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Preco</th>
                    <th>Acoes</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($produtos)): ?>
                    <tr>
                        <td colspan="4" class="empty-state">Nenhum produto cadastrado.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($produtos as $p): ?>
                        <tr>
                            <td><?= $p->getId() ?></td>
                            <td><?= htmlspecialchars($p->getNome()) ?></td>
                            <td>R$ <?= number_format($p->getPreco(), 2, ',', '.') ?></td>
                            <td>
                                <div class="actions">
                                    <a href="produtos.php?editar=<?= $p->getId() ?>" class="btn btn-edit">Editar</a>
                                    <a href="produtos.php?excluir=<?= $p->getId() ?>" class="btn btn-danger"
                                       onclick="return confirm('Excluir este produto?')">Excluir</a>
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
