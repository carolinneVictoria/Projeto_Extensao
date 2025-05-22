<?php include ("../../app/header.php"); ?>


<!-- Navbar e Barra de Busca -->
<nav class="navbar navbar-expand-sm navbar-dark bg-dark">
  <div class="container w-100">
    <div class="collapse navbar-collapse" id="mynavbar">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" href="servicos.php">Todos</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="servicosPendentes.php">Serviços Pendentes</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="servicosEntregues.php">Serviços Finalizados</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="formServico.php">Cadastrar novo Serviço</a>
        </li>
      </ul>
        <form method="GET" action="/Projeto_Extensao/controller/ServicoController.php?acao=buscar" class="d-flex" role="search">
        <input type="hidden" name="acao" value="buscar">
        <input type="text" name="busca" class="form-control me-2" placeholder="Buscar por Nome de Cliente" value="<?= $_GET['busca'] ?? '' ?>">
        <button class="btn btn-outline-light" type="submit">Buscar</button>
        </form>

    </div>
  </div>
</nav>

<?php

// Inclui a conexão ao banco e o modelo de cliente
include_once "../../config/conexaoBD.php"; 
include_once "../../model/Servico.php";

// Instanciando o Model
$servicoModel = new Servico($conn);

// Listando os clientes
$servicos = $servicoModel->listarServicos();
$totalServicos = mysqli_num_rows($servicos); 

echo "<h5>Servicos cadastrados: $totalServicos</h5>";

// Exibindo a tabela de servicos
echo "
    <table class='table table-hover table-bordered table-sm'>
        <thead class='thead-light'>
            <tr>
                <th>ID</th>
                <th>CLIENTE</th>
                <th>USUARIO</th>
                <th>DESCRIÇÃO</th>
                <th>DATA DE ENTRADA</th>
                <th>ENTREGA</th>
                <th>VALOR</th>
                <th>AÇÕES</th>
            </tr>
        </thead>";

while ($registro = mysqli_fetch_assoc($servicos)) {
  $idServico = $registro['idServico'];
    echo "
        <tbody>
            <tr>
                <td>{$registro['idServico']}</td>
                <td>{$registro['nome']}</td>
                <td>{$registro['nomeUsuario']}</td>
                <td>{$registro['descricao']}</td>
                <td>{$registro['dataEntrada']}</td>
                <td>" . ($registro['entrega'] == 0 ? 'Sim' : 'Não') . "</td>
                <td>{$registro['valorTotal']}</td>
                <td>
                <a href='formAtualizarServico.php?id=$idServico' class='btn btn-primary btn-sm'>Atualizar</a>
                <a href='../../controller/ServicoController.php?acao=excluir&id=$idServico' class='btn btn-danger btn-sm' onclick='return confirm(\"Tem certeza que deseja excluir?\")'>Excluir</a>
                <a href='verServico.php?id=$idServico' class='btn btn-primary brn-sm'>Ver</a>
                </td>
            </tr>
        </tbody>
    ";
}
echo "</table>";
?>

<?php include "../../app/footer.php"; ?>
