<?php 
include("../../app/header.php");
include('../../config/conexaoBD.php');
include('../../model/Venda.php');
include('../../model/Usuario.php');
include('../../model/VendaProduto.php');

$vendaModel = new Venda($conn);
$usuarioModel = new Usuario($conn);
$vendaProdutoModel = new VendaProduto($conn);

if (isset($_GET['id'])) {
    $idVenda = $_GET['id'];
    $venda   = $vendaModel->buscarVendaPorId($idVenda);
    $usuario = $usuarioModel->buscarUsuarioPorId($venda['idUsuario']);
} else {
    echo "ID do serviço não informado!";
    exit();
}

$valorTotal = 0;
$produtosAssociados = $vendaProdutoModel->listarProdutosVenda($idVenda);

if ($produtosAssociados) {
    while ($registro = mysqli_fetch_assoc($produtosAssociados)) {
        $valorTotal += $registro['quantidade'] * $registro['valorUnitario'] - $registro['descontoVenda'];
    }
    if (!$vendaModel->atualizarValorTotalVenda($idVenda, $valorTotal)) {
        echo "Erro ao atualizar o valor total no banco de dados!";
        exit();
    }
} else {
    $produtosAssociados = [];
}
?>

<div class="container-fluid">
    <h3>Detalhes da Venda:</h3>
    <div class="col-sm-12">

    <form id="formVenda" action="/Projeto_Extensao/controller/VendaController.php?acao=atualizar" method="POST" class="was-validated">
        <input type="hidden" name="idVenda" value="<?= $idVenda ?>">

        <div class="row">

            <div class="col-md-4 mb-3">
                <div class="form-floating ">
                    <input type="hidden" name="idUsuario" value="<?= $venda['idUsuario'] ?>">
                    <input type="text" class="form-control" id="idUsuario" value="<?= $usuario['nomeUsuario']; ?>">
                    <label for="idUsuario">Usuario:</label>
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="form-floating ">
                    <input type="date" class="form-control" id="data" name="data" value="<?= $venda['data']; ?>">
                    <label for="dataEntrada">Data da venda:</label>
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="form-floating border border-success rounded">
                    <input type="hidden" name="valorTotal" value="<?= $valorTotal ?>">
                    <input type="text" class="form-control" id="valorTotal" readonly value="R$ <?= number_format($valorTotal, 2, ',', '.'); ?>">
                    <label for="valorTotal">Valor Total:</label>
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="form-floating">
                    <input type="text" class="form-control" id="descontoVenda" name="descontoVenda" value="<?= $venda['descontoVenda']; ?>">
                    <label for="descontoVenda">Desconto:</label>
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="form-floating">
                    <select class="form-select" id="formaPagamento" name="formaPagamento" required>
                        <option value="Pix" <?= ($venda['formaPagamento'] == 'Pix') ? 'selected' : '' ?>>Pix</option>
                        <option value="Cartão de Débito" <?= ($venda['formaPagamento'] == 'Cartão de Débito') ? 'selected' : '' ?>>Cartão de Débito</option>
                        <option value="Cartão de Crédito" <?= ($venda['formaPagamento'] == 'Cartão de Crédito') ? 'selected' : '' ?>>Cartão de Crédito</option>
                    </select>
                    <label for="formaPagamento">Forma de Pagamento:</label>
                </div>
            </div>


            <h5>Produtos</h5>
            <div class="col-md-12 mb-3">
            <?php
            if (!empty($produtosAssociados)) {
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

                // Exibir os produtos associados ao serviço
                foreach ($produtosAssociados as $registro) {
                    $totalProduto = $registro['quantidade'] * $registro['valorUnitario'];
                    echo "
                        <tr>
                            <td>{$registro['nomeProduto']}</td>
                            <td>{$registro['quantidade']}</td>
                            <td>R$ " . number_format($registro['valorUnitario'], 2, ',', '.') . "</td>
                            <td>R$ " . number_format($totalProduto, 2, ',', '.') . "</td>
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
            </div>

            <div class="d-flex justify-content-end mt-3">
                <a href="produtoVenda.php?id=<?= $idVenda ?>" class="btn btn-primary btn me-2">Adicionar Produtos</a>
                <button type="submit" class="btn btn-primary">Realizar Venda</button>
            </div>
            <p></p>

        </div>
        </form>
    </div>
</div>

<script>
document.getElementById('descontoVenda').addEventListener('input', function (e) {
    let value = e.target.value.replace(/\D/g, '');
    value = (parseInt(value) / 100).toFixed(2);
    e.target.value = 'R$ ' + value.replace('.', ',');
});
</script>

<?php include("../../app/footer.php") ?>
