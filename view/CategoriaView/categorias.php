<?php include ("../../app/header.php"); ?>


<!-- Navbar e Barra de Busca -->
<nav class="navbar navbar-expand-sm navbar-dark bg-dark">
  <div class="container w-100">
    <div class="collapse navbar-collapse" id="mynavbar">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" href="/Projeto_Extensao/view/ProdutoView/produtos.php">Produtos</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="formCategoria.php">Cadastrar Nova Categoria</a>
        </li>
      </ul>
        <form method="GET" action="/Projeto_Extensao/controller/ProdutoController.php" class="d-flex" role="search">
        <input type="hidden" name="acao" value="buscar">
        <input type="text" name="busca" class="form-control me-2" placeholder="Buscar por Nome" value="<?= $_GET['busca'] ?? '' ?>">
        <button class="btn btn-outline-light" type="submit">Buscar</button>
        </form>

    </div>
  </div>
</nav>

<?php

// Inclui a conexão ao banco e o modelo de Categoria
include_once "../../config/conexaoBD.php"; 
include_once "../../model/Categoria.php";

// Instanciando o Model
$categoriaModel = new Categoria($conn);

// Listando os produtos
$categorias = $categoriaModel->listarCategoria();
//$totalCategorias = mysqli_num_rows($categorias); 

echo "<h5>Produtos cadastrados: $totalCategorias</h5>";

// Exibindo a tabela de categoria
echo "
    <table class='table table-hover table-bordered'>
        <thead class='thead-light'>
            <tr>
                <th>ID</th>
                <th>DESCRICAO</th>
                <th>AÇÕES</th>
            </tr>
        </thead>";

while ($registro = mysqli_fetch_assoc($categorias)) {
  $idCategoria = $registro['idCategoria'];
    echo "
        <tbody>
            <tr>
                <td>{$registro['idCategoria']}</td>
                <td>{$registro['descricao']}</td>
                <td>
                <a href='formAtualizarCategoria.php?id=$idCategoria' class='btn btn-primary btn-sm'>Atualizar</a>
                <a href='../controller/CategoriaController.php?acao=excluir&id=$idCategoria' class='btn btn-danger btn-sm' onclick='return confirm(\"Tem certeza que deseja excluir?\")'>Excluir</a>
                </td>
            </tr>
        </tbody>
    ";
}
echo "</table>";
?>

<?php include "../../app/footer.php"; ?>
