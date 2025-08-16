<?php include ("../../app/header.php"); ?>

<!-- Conteúdo principal -->
<div class="container" style="margin-left: -10px; padding-top: 10px;"></div>
    <!-- Título e botão -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Lista de Clientes</h2>
        <a href="formCliente.php" class="btn btn-success"><i class="fas fa-plus"></i> Novo Cliente</a>
    </div>

    <!-- Formulário de busca -->
    <form action="/Projeto_Extensao/controller/ClienteController.php?acao=buscar" method="GET" class="mb-3">
        <div class="input-group">
            <input type="text" name="busca" class="form-control" placeholder="Pesquisar cliente...">
            <button class="btn btn-primary" type="submit" name="acao" value="buscar">
                <i class="fas fa-search"></i>
            </button>
        </div>
    </form>

<?php
include ('../../config/conexaoBD.php');
require_once ('../../model/Cliente.php');

// Instanciando o Model
$clienteModel = new Cliente($conn);

// Listando os clientes
$clientes = $clienteModel->listarClientes();

// Exibindo a tabela de clientes
echo "
    <div class='table-responsive'>
        <table class='table table-striped align-middle'>
            <thead class='table-dark'>
                <tr>
                  <th>ID</th>
                  <th>NOME</th>
                  <th>TELEFONE</th>
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
                <td>{$registro['bicicleta']}</td>
                <td class='text-center'>
                  <a class='btn btn-warning btn-sm' href='verCliente.php?id=$idCliente'>
                      <i class='fas fa-edit'></i>
                  </a>
                  <a class='btn btn-danger btn-sm' href='../../controller/ClienteController.php?acao=excluir&id=$idCliente' onclick=\"return confirm('Tem certeza que deseja excluir?')\">
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