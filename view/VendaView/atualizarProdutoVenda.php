<?php
include("../../app/header.php");
include_once "../../config/conexaoBD.php";
include_once "../../model/Venda.php";
include_once "../../model/Produto.php";
include_once "../../model/VendaProduto.php";

// Instanciando o Model
$vendaModel = new Venda($conn);
$produtoModel = new Produto($conn);
$vendaProdutoModel = new VendaProduto($conn);

// Listando produtos
$produtos = $produtoModel->listarProdutos();

// Verifica se os IDs foram passados corretamente
if (!isset($_GET['idProduto'], $_GET['idVenda'])) {
    echo "ID da venda ou do produto não informado!";
    exit;
}

$idVenda = (int) $_GET['idVenda'];
$idProduto = (int) $_GET['idProduto'];
// Busca os dados necessários
$venda  = $vendaModel->buscarVendaPorId($idVenda);
$produto  = $produtoModel->buscarProdutoPorId($idProduto);
$registro = $vendaProdutoModel->buscarProdutoVenda($idVenda, $idProduto);

if (!$registro) {
    echo "Registro de produto na venda não encontrado!";
    exit;
}

?>

<div class="container-fluid text-left">

    <h4 class="mb-4">Atualizar Produto na Venda</h4>

    
    <form id="formProduto" action="/Projeto_Extensao/controller/VendaController.php?acao=adicionarProduto" method="POST" class="was-validated">
        <div class="row">
            
            <!-- Campos ocultos -->
            <input type="hidden" name="idVenda" value="<?= $idVenda ?>">
            <input type="hidden" name="idProduto" value="<?= $idProduto ?>">
            
            <!-- Nome do Produto -->
            <div class="col-md-4 mb-3">
                <div class="form-floating">
                    <input type="text" id="produto" class="form-control border border-success rounded" readonly value="<?= htmlspecialchars($registro['nomeProduto']) ?>">
                    <label for="produto" class="form-label">Produto</label>
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="form-floating">
                    <input type="number" class="form-control" id="quantidade" name="quantidade" required min="1" value="<?= (int) $registro['quantidade'] ?>">
                    <label for="quantidade">Quantidade</label>
                </div>
            </div>

            
            <div class="col-md-4 mb-3">
                <div class="form-floating">
                    <input type="text" class="form-control border border-success rounded" id="valorUnitario" name="valorUnitario" required readonly value="<?= number_format($registro['valorUnitario'], 2, ',', '.') ?>">
                    <label for="valorUnitario">Valor Unitário</label>
                </div>
            </div>

            <div class="col-md-12 mb-3 d-flex align-items-end">
                <button type="submit" class="btn btn-success w-100">Adicionar Produto</button>
            </div>
        </div>
    </form>

    <?php
    
    $produtosAssociados = $vendaProdutoModel->listarProdutosVenda($idVenda);
    if ($produtosAssociados) {
        echo "
            <table class='table table-hover table-bordered table-sm'>
                <thead class='thead-light'>
                    <tr>
                        <th>PRODUTO</th>
                        <th>QUANTIDADE</th>
                        <th>VALOR UNITÁRIO</th>
                        <th>TOTAL</th>
                        <th>AÇÕES</th>
                    </tr>
                </thead>
                <tbody>
        ";

        // Exibindo os produtos associados ao serviço
        while ($registro = mysqli_fetch_assoc($produtosAssociados)) {
            $idVenda = $registro['idVenda'];
            echo "
                <tr>
                    <td>{$registro['nomeProduto']}</td>
                    <td>{$registro['quantidade']}</td>
                    <td>R$ " . number_format($registro['valorUnitario'], 2, ',', '.') . "</td>
                    <td>R$ " . number_format($registro['quantidade'] * $registro['valorUnitario'], 2, ',', '.') . "</td>
                    <td>
                        <a href='atualizarProdutoVenda.php?idProduto={$registro['idProduto']}&idVenda={$registro['idVenda']}' class='btn btn-primary btn-sm'>Atualizar</a>
                        <a href='../../controller/VendaController.php?acao=excluirProduto&id={$registro['idProduto']}&idVenda={$idVenda}' class='btn btn-danger btn-sm' onclick='return confirm(\"Tem certeza que deseja excluir?\")'>Excluir</a>
                    </td>
                </tr>
            ";
        }
        echo "</tbody></table>";
    } else {
        echo "<p>Nenhum produto associado ao serviço ainda.</p>";
    }
    ?>

            <div class="d-flex justify-content-end mt-3">
                <a href="formAtualizarVenda.php?id=<?= $idVenda ?>" class="btn btn-secondary btn me-2">Voltar</a>
            </div>

</div>

<script>
document.getElementById("idProduto").addEventListener("change", function() {
    let selectedOption = this.options[this.selectedIndex];
    let valor = selectedOption.getAttribute("data-valor");

    // Formata como moeda brasileira
    let valorFormatado = parseFloat(valor).toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });

    // Atualiza o campo de valor unitário
    document.getElementById("valorUnitario").value = valorFormatado;
});

// Ao carregar a página, aplica o valor formatado do item já selecionado
window.addEventListener("load", function() {
    document.getElementById("idProduto").dispatchEvent(new Event("change"));
});
</script>


<?php include("../../app/footer.php"); ?>
