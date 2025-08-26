<?php include ("../app/header.php"); ?>

<div class="container" style="margin-left: -10px; padding-top: 10px;"></div>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Lista de Compras</h2>
        <a href="/Projeto_Extensao/controller/CompraController.php?acao=formCadastro" class="btn btn-success"><i class="fas fa-plus"></i> Nova Compra</a>
    </div>

    <form action="/Projeto_Extensao/controller/CompraController.php?acao=buscar" method="GET" class="mb-3">
        <div class="input-group">
            <input type="text" name="busca" class="form-control" placeholder="Pesquisar serviço...">
            <button class="btn btn-primary" type="submit" name="acao" value="buscar">
                <i class="fas fa-search"></i>
            </button>
        </div>
    </form>

<div class='table-responsive'>
        <table class='table table-striped align-middle'>
            <thead class='table-dark'>
                <tr>
                <th>ID</th>
                <th>DESCRIÇÃO</th>
                <th>FORNECEDOR</th>
                <th>DATA DA COMPRA</th>
                <th>VALOR</th>
                <th>AÇÕES</th>
            </tr>
            </thead>
            <tbody>
    <?php
    while ($registro = mysqli_fetch_assoc($compras)) : ?>
        <tr>
            <td><?= $registro['idCompra'] ?></td>
            <td><?= $registro['descricao'] ?></td>
            <td><?= $registro['razaoSocial'] ?></td>
            <td><?= $registro['data'] ?></td>
            <td>R$ <?= number_format($registro['valorTotal'], 2, ',', '.') ?></td>
            <td class="text-cente">
                <a class="btn btn-warning btn-sm" href="../controller/CompraController.php?acao=ver&id=<?= $registro['idCompra'] ?>">
                    <i class='fas fa-edit'></i>
                </a>
                <a class="btn btn-danger btn-sm" href="../controller/CompraController.php?acao=excluir&id=<?= $registro['idCompra'] ?>" onclick="return confirm('Tem certeza que deseja excluir?')">
                    <i class='fas fa-trash'></i>
                </a>
            </td>
        </tr>
    <?php endwhile; ?>
    </tbody>
</table>

<div class="col-md-12">
    <a href="/Projeto_Extensao/controller/CompraController.php?acao=listar" class="btn btn-secondary mt-3" style="width: 100px; margin-left: 515px; position: fixed;">Voltar</a>
</div>

<?php include("../app/footer.php"); ?>
