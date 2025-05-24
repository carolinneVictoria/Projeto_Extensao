<?php
include("../../app/header.php");
include_once "../../config/conexaoBD.php";
include_once "../../model/Servico.php";
include_once "../../model/Produto.php";
include_once "../../model/ServicoProduto.php";

$servicoModel        = new Servico($conn);
$produtoModel        = new Produto($conn);
$servicoProdutoModel = new ServicoProduto($conn);

if (!isset($_GET['idServico'], $_GET['idProduto'])) {
    echo "ID do serviço ou do produto não informado!";
    exit;
}

$idServico = (int) $_GET['idServico'];
$idProduto = (int) $_GET['idProduto'];

$servico = $servicoModel->buscarServicoPorId($idServico);
$produto = $produtoModel->buscarProdutoPorId($idProduto);

$registro = $servicoProdutoModel->buscarProdutoServico($idServico, $idProduto);

if (!$registro) {
    echo "Registro de produto no serviço não encontrado!";
    exit;
}

$produtos = $produtoModel->listarProdutos();
?>

<div class="container-fluid">
  <h4 class="mb-4">Atualizar Produto no Serviço #<?= $idServico ?></h4>

  <form action="/Projeto_Extensao/controller/ServicoController.php?acao=atualizarProduto" method="POST" class="row g-3 needs-validation">

    <input type="hidden" name="idServico" value="<?= $idServico ?>">
    <input type="hidden" name="idProduto" value="<?= $idProduto ?>">


    <div class="col-md-4">
      <label for="produto" class="form-label">Produto</label>
      <input type="text" id="produto" class="form-control" readonly
             value="<?= htmlspecialchars($registro['nomeProduto']) ?>">
    </div>

    <div class="col-md-2">
      <label for="quantidade" class="form-label">Quantidade</label>
      <input type="number" id="quantidade" name="quantidade" class="form-control" 
             min="1" required
             value="<?= (int)$registro['quantidade'] ?>">
      <div class="invalid-feedback">Informe uma quantidade válida.</div>
    </div>

    <div class="col-md-3">
      <label for="valorUnitario" class="form-label">Valor Unitário</label>
      <input type="text" id="valorUnitario" name="valorUnitario" class="form-control" 
             required readonly
             value="<?= number_format($registro['valorUnitario'], 2, ',', '.') ?>">
      <div class="invalid-feedback">Valor inválido.</div>
    </div>

    <div class="col-md-3">
      <label for="totalProduto" class="form-label">Total</label>
      <input type="text" id="totalProduto" class="form-control" readonly
             value="R$ <?= number_format($registro['quantidade'] * $registro['valorUnitario'], 2, ',', '.') ?>">
    </div>

    <div class="col-12 text-end">
      <button type="submit" class="btn btn-primary">Atualizar Produto</button>
      <a href="formAtualizarServico.php?id=<?= $idServico ?>" class="btn btn-secondary ms-2">Voltar</a>
    </div>
  </form>
</div>

<?php include("../../app/footer.php"); ?>
