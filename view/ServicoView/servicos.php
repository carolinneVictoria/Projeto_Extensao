<?php include ("../../app/header.php"); ?>

<!-- Navbar e Barra de Busca -->
<div class="container-fluid bg-dark d-flex position-fixed" style="top: 50px; left: 160px; width: calc(100% - 160px); height: 50px; z-index: 1030;">
  <nav class="navbar navbar-expand-sm navbar-dark bg-dark w-100">
    <div class="container-fluid">
      <div class="collapse navbar-collapse d-flex justify-content-between" id="mynavbar">
        <ul class="navbar-nav mb-4 mb-lg-0">
          <li class="nav-item"><a class="nav-link" href="servicos.php">Todos</a></li>
          <li class="nav-item"><a class="nav-link" href="servicosPendentes.php">Serviços Pendentes</a></li>
          <li class="nav-item"><a class="nav-link" href="servicosEntregues.php">Serviços Finalizados</a></li>
          <li class="nav-item"><a class="nav-link" href="formServico.php">Cadastrar novo Serviço</a></li>
        </ul>

        <!-- Campo de busca -->
        <form method="GET" action="/Projeto_Extensao/controller/ServicoController.php?acao=buscar" class="d-flex me-2" role="search">
          <input type="hidden" name="acao" value="buscar">
          <input type="text" name="busca" class="form-control me-2" placeholder="Buscar por Descricao"value="<?= $_GET['busca'] ?? '' ?>">
          <button class="btn btn-outline-light" type="submit">Buscar</button>
        </form>
      </div>
    </div>
  </nav>
</div>

<!-- Conteúdo principal -->
<div class="container" style="margin-left: -10px; padding-top: 50px;">

<?php
include_once "../../config/conexaoBD.php"; 
include_once "../../model/Servico.php";

// Instancia o model e busca os serviços
$servicoModel = new Servico($conn);
$servicos = $servicoModel->listarServicos();
$totalServicos = mysqli_num_rows($servicos); 

echo "<h5>Serviços cadastrados: $totalServicos</h5>";

// Exibe a tabela de serviços
echo "
<table class='table table-hover table-bordered table-sm'>
  <thead class='thead-light'>
    <tr>
      <th>ID</th>
      <th>CLIENTE</th>
      <th class='col-descricao'>DESCRIÇÃO</th>
      <th>DATA DE ENTRADA</th>
      <th>ENTREGA</th>
      <th>VALOR</th>
      <th>AÇÕES</th>
    </tr>
  </thead>
  <tbody>";

while ($registro = mysqli_fetch_assoc($servicos)) {
  $idServico = $registro['idServico'];
  $entrega = $registro['entrega'] == 0 ? 'Sim' : 'Não';
  $valor = number_format($registro['valorTotal'], 2, ',', '.');

  echo "
    <tr>
      <td>{$registro['idServico']}</td>
      <td>{$registro['nome']}</td>
      <td>{$registro['descricao']}</td>
      <td>{$registro['dataEntrada']}</td>
      <td>$entrega</td>
      <td>R$ $valor</td>
      <td>
        <a href='verServico.php?id=$idServico' class='btn btn-primary btn-sm'>Ver Detalhes</a>
      </td>
    </tr>";
}

echo "
  </tbody>
</table>";
?>
<?php include "../../app/footer.php"; ?>
</div>
