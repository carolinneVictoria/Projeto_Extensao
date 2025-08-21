<?php include ("../../app/header.php"); ?>

<!-- Conteúdo principal -->
<div class="container" style="margin-left: -10px; padding-top: 10px;"></div>
    <!-- Título e botão -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Lista de Serviços</h2>
        <a href="formProdutos.php" class="btn btn-success"><i class="fas fa-plus"></i> Novo Serviço</a>
    </div>

    <!-- Formulário de busca -->
    <form action="/Projeto_Extensao/controller/ServicoController.php?acao=buscar" method="GET" class="mb-3">
        <div class="input-group">
            <input type="text" name="busca" class="form-control" placeholder="Pesquisar serviço...">
            <button class="btn btn-primary" type="submit" name="acao" value="buscar">
                <i class="fas fa-search"></i>
            </button>
        </div>
    </form>
<div style="padding-bottom: 10px;">
  <a href="servicos.php" class="btn btn-success"></i> Todos</a>
  <a href="servicosEntregues.php" class="btn btn-success"></i> Serviços Entregues</a>
  <a href="servicosPendentes.php" class="btn btn-success"></i> Serviços Pendentes</a>
</div>

<?php

echo "
<div class='table-responsive'>
        <table class='table table-striped align-middle'>
            <thead class='table-dark'>
              <tr>
                <th>ID</th>
                <th>CLIENTE</th>
                <th class='col-descricao'>DESCRIÇÃO</th>
                <th>DATA DE ENTRADA</th>
                <th>ENTREGA</th>
                <th>VALOR</th>
                <th>AÇÕES</th>
              </tr>
            </thead>";

while ($registro = mysqli_fetch_assoc($servicos)) {
  $idServico = $registro['idServico'];
  $entrega = $registro['entrega'] == 0 ? 'Sim' : 'Não';
  $valor = number_format($registro['valorTotal'], 2, ',', '.');

  echo "
  <tbody>
    <tr>
      <td>{$registro['idServico']}</td>
      <td>{$registro['nome']}</td>
      <td>{$registro['descricao']}</td>
      <td>{$registro['dataEntrada']}</td>
      <td>$entrega</td>
      <td>R$ $valor</td>
      <td class='text-center'>
        <a class='btn btn-warning btn-sm' href='/Projeto_Extensao/controller/ServicoController.php?acao=ver&id=$idServico'>
            <i class='fas fa-edit'></i>
        </a>
        <a class='btn btn-danger btn-sm' href='../controller/ServicoController.php?acao=excluir&id=$idServico' onclick=\"return confirm('Tem certeza que deseja excluir?')\">
          <i class='fas fa-trash'></i>
        </a>
      </td>
    </tr>";
}

echo "
  </tbody>
</table>";
?>
<?php include "../../app/footer.php"; ?>
</div>
