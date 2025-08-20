<?php include ("../app/header.php"); ?>

<div class="container" style="margin-left: -10px; padding-top: 10px;"></div>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Lista de Serviços</h2>
        <a href="/Projeto_Extensao/controller/ServicoController.php?acao=formCadastro" class="btn btn-success"><i class="fas fa-plus"></i> Novo Serviço</a>
    </div>

    <form action="/Projeto_Extensao/controller/ServicoController.php?acao=buscar" method="GET" class="mb-3">
        <div class="input-group">
            <input type="text" name="busca" class="form-control" placeholder="Pesquisar serviço...">
            <button class="btn btn-primary" type="submit" name="acao" value="buscar">
                <i class="fas fa-search"></i>
            </button>
        </div>
    </form>

<div style="padding-bottom: 10px;">
    <a href="/Projeto_Extensao/controller/ServicoController.php?acao=listar" class="btn btn-success"></i> Todos</a>
    <a href="/Projeto_Extensao/controller/ServicoController.php?acao=listarEntregues" class="btn btn-success"></i> Serviços Entregues</a>
    <a href="/Projeto_Extensao/controller/ServicoController.php?acao=listarPendentes" class="btn btn-success"></i> Serviços Pendentes</a>
</div>

<div class='table-responsive'>
        <table class='table table-striped align-middle'>
            <thead class='table-dark'>
                <tr>
                    <th>ID</th>
                    <th>CLIENTE</th>
                    <th>USUARIO</th>
                    <th>DESCRIÇÃO</th>
                    <th>DATA DE ENTRADA</th>
                    <th>ENTREGA</th>
                    <th>VALOR</th>
                    <th>AÇÕES</th>
                </tr>
            </thead>
            <tbody>
    <?php while ($registro = mysqli_fetch_assoc($servicos)) : ?>
        <tr>
            <td><?= $registro['idServico'] ?></td>
            <td><?= $registro['nome'] ?></td>
            <td><?= $registro['nomeUsuario'] ?></td>
            <td><?= $registro['descricao'] ?></td>
            <td><?= $registro['dataEntrada'] ?></td>
            <td><?= ($registro['entrega'] == 0 ? 'Sim' : 'Não') ?></td>
            <td>R$ <?= number_format($registro['valorTotal'], 2, ',', '.') ?></td>
            <td class="text-cente">
                <a class="btn btn-warning btn-sm" href="../controller/ServicoController.php?acao=ver&id=<?= $registro['idServico'] ?>">
                    <i class='fas fa-edit'></i>
                </a>
                <a class="btn btn-danger btn-sm" href="../controller/ServicoController.php?acao=excluir&id=<?= $registro['idServico'] ?>" onclick="return confirm('Tem certeza que deseja excluir?')">
                    <i class='fas fa-trash'></i>
                </a>
            </td>
        </tr>
    <?php endwhile; ?>
    </tbody>
</table>

<div class="col-md-12">
    <a href="/Projeto_Extensao/Controller/ServicoController.php?acao=listar" class="btn btn-secondary mt-3" style="width: 100px; margin-left: 515px; position: fixed;">Voltar</a>
</div>

<?php include(__DIR__ . "../../app/footer.php"); ?>
