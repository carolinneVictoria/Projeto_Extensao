<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include("../../app/header.php"); 
include_once "../../model/Estoque.php";
include_once "../../model/Produto.php";
include_once "../../model/CompraProduto.php";

// Instanciando o Model
$compraModel = new Estoque($conn);
$produtoModel = new Produto($conn);
$compraProdutoModel = new CompraProduto($conn);

// Listando produtos
$produtos = $produtoModel->listarProdutos();

// Verifica se os IDs foram passados corretamente
if (!isset($_GET['idProduto'], $_GET['idCompra'])) {
    echo "ID da compra ou do produto não informado!";
    exit;
}

$idCompra = (int) $_GET['idCompra'];
$idProduto = (int) $_GET['idProduto'];
// Busca os dados necessários
$compra  = $compraModel->buscarCompraPorId($idCompra);
$produto  = $produtoModel->buscarProdutoPorId($idProduto);
$registro = $compraProdutoModel->buscarProdutoCompra($idCompra, $idProduto);

if (!$registro) {
    echo "Registro de produto na compra não encontrado!";
    exit;
}
?>

<!-- Adicionar Produto a Venda -->
<div class="container-fluid text-left">

    <h4 class="mb-4">Atualizar Produto</h4>

    <form id="formProduto" action="/Projeto_Extensao/controller/CompraController.php?acao=atualizarProduto" method="POST" class="was-validated">
        <div class="row">
            <!-- Campos ocultos -->
            <input type="hidden" name="idCompra" value="<?= $idCompra ?>">
            <input type="hidden" name="idProduto" value="<?= $idProduto ?>">

            <div class="col-md-4 mb-3">
                <div class="form-floating">
                    <input type="text" id="produto" class="form-control border border-success rounded" readonly value="<?= htmlspecialchars($registro['nomeProduto']) ?>">
                    <label for="produto" class="form-label">Produto</label>
                </div>
            </div>

            
            <div class="col-md-3 mb-3">
                <div class="form-floating">
                    <input type="number" class="form-control" id="quantidade" name="quantidade" required min="1" value="<?= (int) $registro['quantidade'] ?>">
                    <label for="quantidade">Quantidade</label>
                </div>
            </div>

            
            <div class="col-md-3 mb-3">
                <div class="form-floating">
                    <input type="text" class="form-control" id="valorUnitario" name="valorUnitario" required readonly value="<?= number_format($registro['valorUnitario'], 2, ',', '.') ?>">
                    <label for="valorUnitario">Valor Unitário</label>
                </div>
            </div>


            <div class="col-md-12 mb-3 d-flex align-items-end">
                <button type="submit" class="btn btn-success w-100">Atualizar Produto</button>
            </div>
        </div>
    </form>

            <div class="d-flex justify-content-end mt-3">
                <button onclick="history.back()" class="btn btn-secondary btn me-2">Voltar</button>
            </div>

<script>
document.getElementById("idProduto").addEventListener("change", function() {
    let selectedOption = this.options[this.selectedIndex];
    let valor = selectedOption.getAttribute("data-valor");
    let quantidade = selectedOption.getAttribute("data-quantidade");

    document.getElementById("valorUnitario").value = valor;
    document.getElementById("quantidade").value = quantidade;
});

window.addEventListener("load", function() {
    document.getElementById("idProduto").dispatchEvent(new Event("change"));
});
</script>


</div>
