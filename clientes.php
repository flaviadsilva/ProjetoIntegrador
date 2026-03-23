<?php
require_once "dao/ClienteDAO.php";

$clienteDAO = new ClienteDAO();
$mensagem = "";
$tipo = "";

// Excluir
if (isset($_GET['excluir'])) {
    $id = (int)$_GET['excluir'];
    if ($clienteDAO->excluir($id)) {
        $mensagem = "Cliente excluido com sucesso.";
        $tipo = "success";
    } else {
        $mensagem = "Erro ao excluir. Verifique se o cliente possui pedidos vinculados.";
        $tipo = "error";
    }
}

// Buscar cliente para edicao
$clienteEdicao = null;
if (isset($_GET['editar'])) {
    $clienteEdicao = $clienteDAO->buscarPorId((int)$_GET['editar']);
}

// Salvar (inserir ou atualizar)
if (isset($_POST['salvar'])) {
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);

    if (!empty($nome) && !empty($email)) {
        if (!empty($_POST['id'])) {
            $cliente = new Cliente((int)$_POST['id'], $nome, $email);
            if ($clienteDAO->atualizar($cliente)) {
                $mensagem = "Cliente atualizado com sucesso.";
                $tipo = "success";
                $clienteEdicao = null;
            } else {
                $mensagem = "Erro ao atualizar.";
                $tipo = "error";
            }
        } else {
            $cliente = new Cliente(null, $nome, $email);
            if ($clienteDAO->inserir($cliente)) {
                $mensagem = "Cliente cadastrado com sucesso.";
                $tipo = "success";
            } else {
                $mensagem = "Erro ao cadastrar.";
                $tipo = "error";
            }
        }
    }
}

$clientes = $clienteDAO->listar();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientes - Sistema de Loja</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php include "includes/menu.php"; ?>

<div class="page">
    <div class="page-header">
        <h1>Clientes</h1>
        <p>Gerencie seus clientes</p>
    </div>

    <?php if ($mensagem): ?>
        <div class="alert alert-<?= $tipo ?>"><?= htmlspecialchars($mensagem) ?></div>
    <?php endif; ?>

    <div class="form-card">
        <h2><?= $clienteEdicao ? "Editar Cliente" : "Novo Cliente" ?></h2>
        <form method="POST" action="clientes.php">
            <?php if ($clienteEdicao): ?>
                <input type="hidden" name="id" value="<?= $clienteEdicao->getId() ?>">
            <?php endif; ?>
            <div class="form-row">
                <div class="form-group">
                    <label>Nome</label>
                    <input type="text" name="nome" placeholder="Nome completo" required
                           value="<?= $clienteEdicao ? htmlspecialchars($clienteEdicao->getNome()) : '' ?>">
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" placeholder="email@exemplo.com" required
                           value="<?= $clienteEdicao ? htmlspecialchars($clienteEdicao->getEmail()) : '' ?>">
                </div>
            </div>
            <button type="submit" name="salvar" class="btn btn-primary">
                <?= $clienteEdicao ? "Atualizar" : "Cadastrar" ?>
            </button>
        </form>
    </div>

    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Acoes</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($clientes)): ?>
                    <tr>
                        <td colspan="4" class="empty-state">Nenhum cliente cadastrado.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($clientes as $c): ?>
                        <tr>
                            <td><?= $c->getId() ?></td>
                            <td><?= htmlspecialchars($c->getNome()) ?></td>
                            <td><?= htmlspecialchars($c->getEmail()) ?></td>
                            <td>
                                <div class="actions">
                                    <a href="clientes.php?editar=<?= $c->getId() ?>" class="btn btn-edit">Editar</a>
                                    <a href="clientes.php?excluir=<?= $c->getId() ?>" class="btn btn-danger"
                                       onclick="return confirm('Excluir este cliente?')">Excluir</a>
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
