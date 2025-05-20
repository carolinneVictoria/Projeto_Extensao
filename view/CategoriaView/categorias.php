<?php include (__DIR__."/../../app/header.php"); ?>


<!-- Navbar e Barra de Busca -->
<nav class="navbar navbar-expand-sm navbar-dark bg-dark">
  <div class="container w-100">
    <div class="collapse navbar-collapse" id="mynavbar">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" href="/Projeto_Extensao/view/ProdutoView/produtos.php">Produtos</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#modalCategoria">Cadastrar Categoria</a>
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
include_once (__DIR__."/../../config/conexaoBD.php"); 
include_once (__DIR__."/../../model/Categoria.php");

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
                <a class='btn btn-primary btn-sm' href='#' data-bs-toggle='modal' data-bs-target='#modalAtualizarCategoria{$idCategoria}'>Atualizar</a>

                  <!-- Modal Atualizar Categoria -->
                  <div class='modal fade' id='modalAtualizarCategoria{$idCategoria}' tabindex='-1' aria-labelledby='modalAtualizarCategoriaLabel{$idCategoria}' aria-hidden='true'>
                    <div class='modal-dialog'>
                      <div class='modal-content'>
                        <form action='/Projeto_Extensao/controller/CategoriaController.php?acao=atualizar' method='POST'>
                          <div class='modal-header'>
                            <h5 class='modal-title' id='modalAtualizarCategoriaLabel{$idCategoria}'>Atualizar Categoria</h5>
                            <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Fechar'></button>
                          </div>
                          <div class='modal-body'>
                            <input type='hidden' name='acao' value='atualizar'>
                            <input type='hidden' name='idCategoria' value='{$registro['idCategoria']}'>
                            <div class='mb-3'>
                              <label for='descricaoCategoria{$idCategoria}' class='form-label'>Nome da Categoria:</label>
                              <input type='text' class='form-control' id='descricaoCategoria{$idCategoria}' name='descricao' value='{$registro['descricao']}' required>
                            </div>
                          </div>
                          <div class='modal-footer'>
                            <button type='submit' class='btn btn-success'>Salvar Alterações</button>
                            <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cancelar</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>

                <a href='/Projeto_Extensao/controller/CategoriaController.php?acao=excluir&id=$idCategoria' class='btn btn-danger btn-sm' onclick='return confirm(\"Tem certeza que deseja excluir?\")'>Excluir</a>
                </td>
            </tr>
        </tbody>
    ";
}
echo "</table>";
?>

<!-- Janela flutuante para cadastro de categoria -->
<div class="modal fade" id="modalCategoria" tabindex="-1" aria-labelledby="modalCategoriaLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="/Projeto_Extensao/controller/CategoriaController.php?acao=cadastrar" method="POST">
        <div class="modal-header">
          <h5 class="modal-title" id="modalCategoriaLabel">Nova Categoria</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="acao" value="cadastrar">
          <div class="mb-3">
            <label for="descricaoCategoria" class="form-label">Nome da Categoria:</label>
            <input type="text" class="form-control" id="descricaoCategoria" name="descricao" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Cadastrar</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        </div>
      </form>
    </div>
  </div>
</div>


<?php include "../../app/footer.php"; ?>
