<?php include ("../../app/header.php"); ?>

<!-- Navbar e Barra de Busca -->
<nav class="navbar navbar-expand-sm navbar-dark bg-dark">
  <div class="container w-100">
    <div class="collapse navbar-collapse" id="mynavbar">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" href="/Projeto_Extensao/view/FornecedorView/formFornecedor.php?acao=cadastrar">Cadastrar novo Fornecedor</a>
        </li>
      </ul>
      <form method="GET" action="/Projeto_Extensao/controller/FornecedorController.php" class="d-flex" role="search">
        <input type="hidden" name="acao" value="buscar">
        <input type="text" name="busca" class="form-control me-2" placeholder="Buscar por Nome" value="<?= $_GET['busca'] ?? '' ?>">
        <button class="btn btn-outline-light" type="submit">Buscar</button>
      </form>
    </div>
  </div>
</nav>

<?php
include ('../../config/conexaoBD.php');
require_once ('../../model/Fornecedor.php');
// Instanciando o Model
$fornecedorModel = new Fornecedor($conn);
// Listando os clientes
$fornecedores = $fornecedorModel->listarFornecedores();

echo "<h5>Fornecedores cadastrados:</h5>";

// Exibindo a tabela de fornecedores
echo "
    <table class='table table-hover table-bordered'>
        <thead class='thead-light'>
            <tr>
                <th>ID</th>
                <th>CNPJ</th>
                <th>RAZÃO SOCIAL</th>
                <th>ENDEREÇO</th>
                <th>TELEFONE</th>
                <th>AÇÕES</th>
            </tr>
        </thead>";

while ($registro = mysqli_fetch_assoc($fornecedores)) {
  $idFornecedor = $registro['idFornecedor'];
    echo "
        <tbody>
            <tr>
                <td>{$registro['idFornecedor']}</td>
                <td>{$registro['cnpj']}</td>
                <td>{$registro['razaoSocial']}</td>
                <td>{$registro['endereco']}</td>
                <td>{$registro['telefone']}</td>
                <td>
                <a href='formAtualizarFornecedor.php?id=$idFornecedor' class='btn btn-primary btn-sm'>Atualizar</a>
                <a href='../../controller/FornecedorController.php?acao=excluir&id=$idFornecedor' class='btn btn-danger btn-sm' onclick='return confirm(\"Tem certeza que deseja excluir?\")'>Excluir</a>
                </td>
            </tr>
        </tbody>
    ";
}
echo "</table>";

if (isset($_GET['id'])) {
    $idFornecedor = $_GET['id'];
    
    $fornecedor = $fornecedorModel->excluirFornecedor($idFornecedor);
} 

?>

<?php include "../../app/footer.php"; ?>
