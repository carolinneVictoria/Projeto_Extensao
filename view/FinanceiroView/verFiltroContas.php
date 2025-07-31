<?php include("../../app/header.php"); ?>

<!-- Navbar e Barra de Busca -->
<div class="container-fluid bg-dark d-flex position-fixed" style="top: 50px; left: 160px; width: calc(100% - 160px); height: 50px; z-index: 1030;">
  <nav class="navbar navbar-expand-sm navbar-dark bg-dark w-100">
    <div class="container-fluid">
      <div class="collapse navbar-collapse d-flex justify-content-between" id="mynavbar">
        <ul class="navbar-nav mb-4 mb-lg-0">
          <li class="nav-item"><a class="nav-link" href="contas.php">Todos</a></li>
          <li class="nav-item"><a class="nav-link" href="contasPendentes.php">Contas Pagas</a></li>
          <li class="nav-item"><a class="nav-link" href="contasPagas.php">Contas Pendentes</a></li>
          <li class="nav-item"><a class="nav-link" href="../view/FinanceiroView/formConta.php">Cadastrar nova Conta</a></li>
        </ul>

        <!-- Campo de busca -->
        <form method="GET" action="/Projeto_Extensao/controller/FinanceiroController.php?acao=buscar" class="d-flex me-2" role="search">
          <input type="hidden" name="acao" value="buscar">
          <input type="text" name="busca" class="form-control me-2" placeholder="Buscar por Mês"value="<?= $_GET['busca'] ?? '' ?>">
          <button class="btn btn-outline-light" type="submit">Buscar</button>
        </form>
      </div>
    </div>
  </nav>
</div>

<!-- Conteúdo principal -->
<div class="container" style="margin-left: -10px; padding-top: 50px;">

<!-- Campo para filtrar por mês -->
    <form method="GET" action="/Projeto_Extensao/controller/FinanceiroController.php" class="row g-1 mt-4 mb-4">
      <input type="hidden" name="acao" value="filtrar">

      <div class="col-md-3">
          <label class="form-label">Mês</label>
          <select name="mes" class="form-select">
          <option value="">Todos</option>
          <?php
          for ($i = 1; $i <= 12; $i++) {
              $mesSelecionado = (isset($_GET['mes']) && $_GET['mes'] == $i) ? 'selected' : '';
              echo "<option value='$i' $mesSelecionado>" . str_pad($i, 2, '0', STR_PAD_LEFT) . "</option>";
          }
          ?>
          </select>
      </div>

      <div class="col-md-3">
          <label class="form-label">Ano</label>
          <input type="number" name="ano" class="form-control" value="<?= $_GET['ano'] ?? date('Y') ?>">
      </div>

      <div class="col-md-3 align-self-end">
          <button type="submit" class="btn btn-primary">Filtrar</button>
      </div>
    </form>

<!-- Listagem principal -->
<?php
  echo "<h5>Contas:</h5>";

  echo "
  <table class='table table-hover table-bordered table-sm'>
    <thead class='thead-light'>
      <tr>
        <th>ID</th>
        <th>DESCRIÇÃO</th>
        <th>VALOR</th>
        <th>DATA DE VENCIMENTO</th>
        <th>STATUS</th>
        <th>AÇÕES</th>
      </tr>
    </thead>
    <tbody>";
?>

<?php foreach ($contas as $registro):
    $idConta = $registro['idConta'];
    $status = $registro['status'] == 0 ? 'A pagar' : 'Pago';
    $valor = number_format($registro['valorTotal'], 2, ',', '.');
?>
    <tr>
    <td><?= $registro['idConta'] ?></td>
    <td><?= $registro['descricao'] ?></td>
    <td>R$ <?= $valor ?></td>
    <td><?= $registro['dataVencimento'] ?></td>
    <td><?= $status ?></td>
    <td>
        <a href='/Projeto_Extensao/controller/FinanceiroController.php?acao=verConta&id=<?= $idConta ?>' class='btn btn-primary btn-sm'>Ver Detalhes</a>
    </td>
    </tr>
<?php endforeach; ?>
    </tbody>
    </table>
</div>
