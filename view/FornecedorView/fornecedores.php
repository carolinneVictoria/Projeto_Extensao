<?php include ("../../app/header.php"); ?>
<!-- Navbar e Barra de Busca -->
<div class="container-fluid bg-dark d-flex position-fixed" style="top: 50px; left: 160px; width: calc(100% - 160px); height: 50px; z-index: 1030;">
  <nav class="navbar navbar-expand-sm navbar-dark bg-dark w-100">
    <div class="container-fluid">
      <div class="collapse navbar-collapse d-flex justify-content-between" id="mynavbar">
          <ul class="navbar-nav mb-4 mb-lg-0">
            <li class="nav-item"><a class="nav-link" href="/Projeto_Extensao/view/FornecedorView/formFornecedor.php?acao=cadastrar">Cadastrar novo Fornecedor</a></li>
          </ul>
        <!-- Campo de busca -->
        <form method="GET" action="/Projeto_Extensao/controller/FornecedorController.php?acao=buscar" class="d-flex me-2" role="search">
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
include ('../../config/conexaoBD.php');
require_once ('../../model/Fornecedor.php');

// Instanciando o Model
$fornecedorModel = new Fornecedor($conn);
// Listando os clientes
$fornecedores = $fornecedorModel->listarFornecedores();

echo "<h5>Fornecedores cadastrados:</h5>";

// Exibindo a tabela de fornecedores
echo "
    <table class='table table-hover table-bordered table-sm'>
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
                <a href='verFornecedor.php?id=$idFornecedor' class='btn btn-primary brn-sm'>Ver</a>
                </td>
            </tr>
        </tbody>
    ";
}
echo "</table>";
?>
<?php include "../../app/footer.php"; ?>

</div>