<?php include ("../../app/header.php"); ?>
<!-- Navbar e Barra de Busca -->
<div class="container-fluid bg-dark d-flex position-fixed" style="top: 50px; left: 160px; width: calc(100% - 160px); height: 50px; z-index: 1030;">
  <nav class="navbar navbar-expand-sm navbar-dark bg-dark w-100">
    <div class="container-fluid">
      <div class="collapse navbar-collapse d-flex justify-content-between" id="mynavbar">
          <ul class="navbar-nav mb-4 mb-lg-0">
          <li class="nav-item"><a class="nav-link" href="formProdutos.php">Cadastrar novo Produto</a></li>
          <li class="nav-item"><a class="nav-link" href="../CategoriaView/categorias.php">Categorias</a></li>
        </ul>
        <!-- Campo de busca -->
        <form method="GET" action="/Projeto_Extensao/controller/ProdutoController.php?acao=buscar" class="d-flex me-2" role="search">
          <input type="hidden" name="acao" value="buscar">
          <input type="text" name="busca" class="form-control me-2" placeholder="Buscar por Nome"value="<?= $_GET['busca'] ?? '' ?>">
          <button class="btn btn-outline-light" type="submit">Buscar</button>
        </form>
      </div>
    </div>
  </nav>
</div>

<!-- Conteúdo principal -->
<div class="container" style="margin-left: -10px; padding-top: 50px;">

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
                <td>{$registro['quantidadeProduto']}</td>
                <td>R$ " . number_format($registro['valorProduto'], 2, ',', '.') . "</td>
                <td>{$registro['descricao']}</td>
                <td>
                <a href='verProduto.php?id=$idProduto' class='btn btn-primary btn-sm'>Ver Detalhes</a>
                </td>
            </tr>
        </tbody>
    ";
}
echo "</table>";
?>
<?php include "../../app/footer.php"; ?>
</div>