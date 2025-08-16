<?php include ("../../app/header.php"); ?>

<!-- Conteúdo principal -->
<div class="container" style="margin-left: -10px; padding-top: 10px;"></div>
    <!-- Título e botão -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Lista de Produtos</h2>
        <a href="formProdutos.php" class="btn btn-success"><i class="fas fa-plus"></i> Novo Produto</a>
    </div>

    <!-- Formulário de busca -->
    <form action="/Projeto_Extensao/controller/ProdutoController.php?acao=buscar" method="GET" class="mb-3">
        <div class="input-group">
            <input type="text" name="busca" class="form-control" placeholder="Pesquisar produto...">
            <button class="btn btn-primary" type="submit" name="acao" value="buscar">
                <i class="fas fa-search"></i>
            </button>
        </div>
    </form>

<?php
// Inclui a conexão ao banco e o modelo de Produto
include_once "../../config/conexaoBD.php";
include_once "../../model/Produto.php";

// Instanciando o Model
$produtoModel = new Produto($conn);

// Listando os produtos
$produtos = $produtoModel->listarProdutos();
$totalProdutos = mysqli_num_rows($produtos);

// Exibindo a tabela de produtos
echo "
    <div class='table-responsive'>
        <table class='table table-striped align-middle'>
            <thead class='table-dark'>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Quantidade</th>
                    <th>Preço (R$)</th>
                    <th>Categoria</th>
                    <th class='text-center'>Ações</th>
                </tr>
            </thead>";

while ($registro = mysqli_fetch_assoc($produtos)) {
  $idProduto = $registro['idProduto'];
    echo "
        <tbody>
            <tr>
                <td>{$registro['idProduto']}</td>
                <td>{$registro['nomeProduto']}</td>
                <td>{$registro['quantidadeProduto']}</td>
                <td>R$ " . number_format($registro['valorProduto'], 2, ',', '.') . "</td>
                <td>{$registro['descricao']}</td>
                <td class='text-center'>
                  <a class='btn btn-warning btn-sm' href='verProduto.php?id=$idProduto'>
                      <i class='fas fa-edit'></i>
                  </a>
                  <a class='btn btn-danger btn-sm' href='../../controller/ProdutoController.php?acao=excluir&id=$idProduto' onclick=\"return confirm('Tem certeza que deseja excluir?')\">
                    <i class='fas fa-trash'></i>
                  </a>
                </td>

            </tr>
        </tbody>
    ";
}
echo "</table>";
?>
<?php include "../../app/footer.php"; ?>
</div>