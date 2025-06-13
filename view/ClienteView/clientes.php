<?php include ("../../app/header.php"); ?>
<!-- Navbar e Barra de Busca -->
<div class="container-fluid bg-dark d-flex position-fixed" style="top: 50px; left: 160px; width: calc(100% - 160px); height: 50px; z-index: 1030;">
  <nav class="navbar navbar-expand-sm navbar-dark bg-dark w-100">
    <div class="container-fluid">
      <div class="collapse navbar-collapse d-flex justify-content-between" id="mynavbar">
          <ul class="navbar-nav mb-4 mb-lg-0">
            <li class="nav-item"><a class="nav-link" href="/Projeto_Extensao/view/ClienteView/formCliente.php?acao=cadastrar">Cadastrar novo Cliente</a></li>
          </ul>
        <!-- Campo de busca -->
        <form method="GET" action="/Projeto_Extensao/controller/ClienteController.php?acao=buscar" class="d-flex me-2" role="search">
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
require_once ('../../model/Cliente.php');

// Instanciando o Model
$clienteModel = new Cliente($conn);

// Listando os clientes
$clientes = $clienteModel->listarClientes();
echo "<h5>Clientes cadastrados:</h5>";

// Exibindo a tabela de clientes
echo "
    <table class='table table-hover table-bordered table-sm'>
        <thead class='thead-light'>
            <tr>
                <th>ID</th>
                <th>NOME</th>
                <th>TELEFONE</th>
                <th>CPF</th>
                <th>DATA DE NASCIMENTO</th>
                <th>ENDEREÇO</th>
                <th>BICICLETA</th>
                <th>AÇÕES</th>
            </tr>
        </thead>";

while ($registro = mysqli_fetch_assoc($clientes)) {
  $idCliente = $registro['idCliente'];
    echo "
        <tbody>
            <tr>
                <td>{$registro['idCliente']}</td>
                <td>{$registro['nome']}</td>
                <td>{$registro['telefone']}</td>
                <td>{$registro['cpf']}</td>
                <td>{$registro['dataNascimento']}</td>
                <td>{$registro['endereco']}</td>
                <td>{$registro['bicicleta']}</td>
                <td>
                <a href='verCliente.php?id=$idCliente' class='btn btn-primary brn-sm'>Ver</a>
                </td>
            </tr>
        </tbody>
    ";
}
echo "</table>";
?>

<?php include "../../app/footer.php"; ?>

</div>