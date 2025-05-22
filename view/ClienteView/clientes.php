<?php include ("../../app/header.php"); ?>

<!-- Navbar e Barra de Busca -->
<nav class="navbar navbar-expand-sm navbar-dark bg-dark">
  <div class="container w-100">
    <div class="collapse navbar-collapse" id="mynavbar">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" href="/Projeto_Extensao/view/ClienteView/formCliente.php?acao=cadastrar">Cadastrar novo Cliente</a>
        </li>
      </ul>
      <form method="GET" action="/Projeto_Extensao/controller/ClienteController.php" class="d-flex" role="search">
        <input type="hidden" name="acao" value="buscar">
        <input type="text" name="busca" class="form-control me-2" placeholder="Buscar por Nome" value="<?= $_GET['busca'] ?? '' ?>">
        <button class="btn btn-outline-light" type="submit">Buscar</button>
      </form>
    </div>
  </div>
</nav>

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
                <a href='formAtualizarCliente.php?id=$idCliente' class='btn btn-primary btn-sm'>Atualizar</a>
                <a href='../../controller/ClienteController.php?acao=excluir&id=$idCliente' class='btn btn-danger btn-sm' onclick='return confirm(\"Tem certeza que deseja excluir?\")'>Excluir</a>
                </td>
            </tr>
        </tbody>
    ";
}
echo "</table>";


if (isset($_GET['id'])) {
    $idCliente = $_GET['id'];
    
    $cliente = $clienteModel->excluirCliente($idCliente);
} 

?>

<?php include "../../app/footer.php"; ?>

?>