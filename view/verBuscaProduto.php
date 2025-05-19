<?php include("../app/header.php"); ?>

<h4>Resultado da busca por: "<?= htmlspecialchars($_GET['busca']) ?>"</h4>

<table class="table table-hover table-bordered">
    <thead class="thead-light">
        <tr>
            <th>ID</th>
            <th>NOME</th>
            <th>DESCRIÇÃO</th>
            <th>QUANTIDADE</th>
            <th>VALOR</th>
            <th>CATEGORIA</th>
            <th>AÇÕES</th>
        </tr>
    </thead>
    <tbody>
    <?php while ($registro = mysqli_fetch_assoc($produtos)) : ?>
        <tr>
            <td><?= $registro['idProduto'] ?></td>
            <td><?= $registro['nomeProduto'] ?></td>
            <td><?= $registro['descricaoProduto'] ?></td>
            <td><?= $registro['quantidadeProduto'] ?></td>
            <td><?= $registro['valorProduto'] ?></td>
            <td><?= $registro['descricao'] ?></td>
            <td>
                <a href="/Projeto_Extensao/view/formAtualizarProdutos.php?id=<?= $registro['idProduto'] ?>" class="btn btn-primary btn-sm">Atualizar</a>
                <a href="../controller/ProdutoController.php?acao=excluir&id=<?= $registro['idProduto'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</a>
            </td>
        </tr>
    <?php endwhile; ?>
    </tbody>
</table>

<div class="col-md-12">
    <a href="/Projeto_Extensao/view/produtos.php" class="btn btn-secondary mt-3" style="width: 100px; margin-left: 515px; position: fixed;">Voltar</a>
</div>

<?php include("../app/footer.php"); ?>
