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

// Verificando se o idServico foi passado corretamente na URL
if (isset($_GET['id'])) {
    $idCompra = $_GET['id'];

    // Verifica se o idCompra é um valor válido (um número positivo)
    if (!is_numeric($idCompra) || $idCompra <= 0) {
        echo "ID de compra inválido.";
        exit();
    }

    // Buscando informações do serviço
    $compra = $compraModel->buscarCompraPorId($idCompra);
    
    // Verifica se o serviço foi encontrado
    if ($compra === null) {
        echo "Compra não encontrado.";
        exit();
    }
} else {
    echo "ID da compra não foi fornecido.";
    exit();
}
?>

<!-- Adicionar Produto a Venda -->
<div class="container-fluid text-left">

    <h4 class="mb-4">Adicionar Produto a Compra</h4>

    <form id="formProduto" action="/Projeto_Extensao/controller/CompraController.php?acao=adicionarProduto" method="POST" class="was-validated">
        <div class="row">
            <input type="hidden" name="idCompra" value="<?= $idCompra ?>">

            <div class="col-md-4 mb-3">
                <div class="form-floating">
                    <select class="form-control" id="idProduto" name="idProduto" required>
                        <?php foreach ($produtos as $produto): ?>
                            <option value="<?= $produto['idProduto']; ?>" data-valor="<?= $produto['valorProduto']; ?>" data-quantidade="<?= $produto['quantidadeProduto']; ?>">
                                <?= $produto['nomeProduto']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <label for="idProduto">Produto:</label>
                </div>
            </div>

            
            <div class="col-md-3 mb-3">
                <div class="form-floating">
                    <input type="number" class="form-control" id="quantidade" name="quantidade" required min="1">
                    <label for="quantidade">Quantidade</label>
                </div>
            </div>

            
            <div class="col-md-3 mb-3">
                <div class="form-floating">
                    <input type="text" class="form-control" id="valorUnitario" name="valorUnitario" required readonly>
                    <label for="valorUnitario">Valor Unitário</label>
                </div>
            </div>

            
            <div class="col-md-2 mb-3 d-flex align-items-center">
                <a href="../ProdutoView/formProdutosCompra.php?id=<?= $idCompra ?>" class="btn btn-primary btn me-2">Criar Produto</a>
            </div>

            <div class="col-md-12 mb-3 d-flex align-items-end">
                <button type="submit" class="btn btn-success w-100">Adicionar Produto</button>
            </div>
        </div>
    </form>

    <?php
    
    $produtosAssociados = $compraProdutoModel->listarProdutosCompra($idCompra);
    if ($produtosAssociados) {
        echo "
            <table class='table table-hover table-bordered table-sm'>
                <thead class='thead-light'>
                    <tr>
                        <th>PRODUTO</th>
                        <th>QUANTIDADE</th>
                        <th>VALOR UNITÁRIO</th>
                        <th>AÇÕES</th>
                    </tr>
                </thead>
                <tbody>
        ";

        // Exibindo os produtos associados ao serviço
        while ($registro = mysqli_fetch_assoc($produtosAssociados)) {
            $idCompraP = $registro['idCompra'];
            echo "
                <tr>
                    <td>{$registro['nomeProduto']}</td>
                    <td>{$registro['quantidade']}</td>
                    <td>R$ " . number_format($registro['valorUnitario'], 2, ',', '.') . "</td>
                    <td>
                        <a href='atualizarProdutoCompra.php?idProduto={$registro['idProduto']}&idCompra={$registro['idCompra']}' class='btn btn-primary btn-sm'>Atualizar</a>
                        <a href='../../controller/CompraController.php?acao=excluirProduto&id={$registro['idProduto']}&idCompra={$idCompra}' class='btn btn-danger btn-sm' onclick='return confirm(\"Tem certeza que deseja excluir?\")'>Excluir</a>
                    </td>
                </tr>
            ";
        }
        echo "</tbody></table>";
    } else {
        echo "<p>Nenhum produto associado à Compra ainda.</p>";
    }
    ?>

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
