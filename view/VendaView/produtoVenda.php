<?php
include("../../app/header.php"); 
// Inclui a conexão ao banco e o modelo de produtos
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

// Verificando se o idServico foi passado corretamente na URL
if (isset($_GET['id'])) {
    $idVenda = $_GET['id'];

    // Verifica se o idVenda é um valor válido (um número positivo)
    if (!is_numeric($idVenda) || $idVenda <= 0) {
        echo "ID de venda inválido.";
        exit();
    }

    // Buscando informações do serviço
    $venda = $vendaModel->buscarVendaPorId($idVenda);
    
    // Verifica se o serviço foi encontrado
    if ($venda === null) {
        echo "Venda não encontrado.";
        exit();
    }
} else {
    echo "ID da venda não foi fornecido.";
    exit();
}
?>

<div class="container-fluid text-left">

    <h4 class="mb-4">Adicionar Produto a Venda</h4>

    
    <form id="formProduto" action="/Projeto_Extensao/controller/VendaController.php?acao=adicionarProduto" method="POST" class="was-validated">
        <div class="row">
            
            <div class="col-md-2 mb-3">
                <div class="form-floating">
                    <input type="text" class="form-control" id="idVenda" name="idVenda" value="<?= ($venda['idVenda']); ?>" required readonly>
                    <label for="idServico">Id da Venda</label>
                </div>
            </div>

            
            <div class="col-md-4 mb-3">
                <div class="form-floating">
                    <select class="form-control" id="idProduto" name="idProduto" required>
                        <?php foreach ($produtos as $produto): ?>
                            <option value="<?= $produto['idProduto']; ?>" data-valor="<?= $produto['valorProduto']; ?>">
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

<script>
document.getElementById("idProduto").addEventListener("change", function() {
    let selectedOption = this.options[this.selectedIndex];
    let valor = selectedOption.getAttribute("data-valor");
    document.getElementById("valorUnitario").value = valor;
});

window.addEventListener("load", function() {
    document.getElementById("idProduto").dispatchEvent(new Event("change"));
});
</script>

</div>

<?php include("../../app/footer.php"); ?>
