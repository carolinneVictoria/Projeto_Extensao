<?php include ("../app/header.php"); ?>

<div class="container" style="margin-left: -10px; padding-top: 10px;">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Lista de Produtos</h2>
        <a href="/Projeto_Extensao/controller/ProdutoController.php?acao=formCadastrar" class="btn btn-success"><i class="fas fa-plus"></i> Novo Produto</a>
    </div>

    <form action="/Projeto_Extensao/controller/ProdutoController.php?acao=buscar" method="GET" class="mb-3">
        <div class="input-group">
            <input type="text" name="busca" class="form-control" placeholder="Pesquisar produto...">
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
                <th>NOME</th>
                <th>DESCRIÇÃO</th>
                <th>QUANTIDADE</th>
                <th>VALOR</th>
                <th>CATEGORIA</th>
                <th>AÇÕES</th>
            </tr>
        </thead>
        <tbody>
        <?php
            while ($registro = mysqli_fetch_assoc($produtos)){
                $idProduto = $registro['idProduto'];
                echo "
                    <tbody>
                    <tr>
                        <td>{$registro['idProduto']}</td>
                        <td>{$registro['nomeProduto']}</td>
                        <td>{$registro['descricaoProduto']}</td>
                        <td>{$registro['quantidadeProduto']}</td>
                        <td>R$ " . number_format($registro['valorProduto'], 2, ',', '.') . "</td>
                        <td>{$registro['descricao']}</td>
                        <td class='text-center'>
                        <a class='btn btn-warning btn-sm' href='../controller/ProdutoController.php?acao=ver&id=$idProduto'>
                            <i class='fas fa-edit'></i>
                        </a>
                        <a class='btn btn-danger btn-sm' href='../controller/ProdutoController.php?acao=excluir&id=$idProduto' onclick=\"return confirm('Tem certeza que deseja excluir?')\">
                            <i class='fas fa-trash'></i>
                        </a>
                        </td>
                    </tr>
                </tbody> ";
        }
echo " </table>";
?>
    </tbody>
</table>

<div class="col-md-12">
    <a href="/Projeto_Extensao/controller/ProdutoController.php?acao=listar" class="btn btn-secondary mt-3" style="width: 100px; margin-left: 515px; position: fixed;">Voltar</a>
</div>

<?php include("../app/footer.php"); ?>
