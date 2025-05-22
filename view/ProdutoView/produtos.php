<?php include ("../../app/header.php"); ?>


<!-- Navbar e Barra de Busca -->
<nav class="navbar navbar-expand-sm navbar-dark bg-dark">
  <div class="container w-100">
    <div class="collapse navbar-collapse" id="mynavbar">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" href="formProdutos.php">Cadastrar novo Produto</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../CategoriaView/categorias.php">Categorias</a>
        </li>
      </ul>
        <form method="GET" action="/Projeto_Extensao/controller/ProdutoController.php?acao=buscar" class="d-flex" role="search">
        <input type="hidden" name="acao" value="buscar">
        <input type="text" name="busca" class="form-control me-2" placeholder="Buscar por Nome" value="<?= $_GET['busca'] ?? '' ?>">
        <button class="btn btn-outline-light" type="submit">Buscar</button>
        </form>

    </div>
  </div>
</nav>

<?php

// Inclui a conexão ao banco e o modelo de Produto
include_once "../../config/conexaoBD.php"; 
include_once "../../model/Produto.php";

// Instanciando o Model
$produtoModel = new Produto($conn);

// Listando os produtos
$produtos = $produtoModel->listarProdutos();
$totalProdutos = mysqli_num_rows($produtos); 

echo "<h5>Produtos cadastrados: $totalProdutos</h5>";

// Exibindo a tabela de produtos
echo "
    <table class='table table-hover table-bordered table-sm'>
        <thead class='thead-light'>
            <tr>
                <th>ID</th>
                <th>NOME</th>
                <th>DESCRICAO</th>
                <th>QUANTIDADE</th>
                <th>VALOR</th>
                <th>CATEGORIA</th>
                <th>AÇÕES</th>
            </tr>
        </thead>";

while ($registro = mysqli_fetch_assoc($produtos)) {
  $idProduto = $registro['idProduto'];
    echo "
        <tbody>
            <tr>
                <td>{$registro['idProduto']}</td>
                <td>{$registro['nomeProduto']}</td>
                <td>{$registro['descricaoProduto']}</td>
                <td>{$registro['quantidadeProduto']}</td>
                <td>{$registro['valorProduto']}</td>
                <td>{$registro['descricao']}</td>
                <td>
                <a href='formAtualizarProdutos.php?id=$idProduto' class='btn btn-primary btn-sm'>Atualizar</a>
                <a href='../../controller/ProdutoController.php?acao=excluir&id=$idProduto' class='btn btn-danger btn-sm' onclick='return confirm(\"Tem certeza que deseja excluir?\")'>Excluir</a>
                </td>
            </tr>
        </tbody>
    ";
}
echo "</table>";
?>

<?php include "../../app/footer.php"; ?>
