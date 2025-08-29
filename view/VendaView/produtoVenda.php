<?php include("../app/header.php"); ?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white text-center">
                    <h4 class="mb-0">Adicionar Produtos à Venda</h4>
                </div>
                <div class="card-body">
                    <form id="formProduto" action="/Projeto_Extensao/controller/VendaController.php?acao=adicionarProduto" method="POST" class="was-validated">
                        <div class="row g-3">
                            <input type="hidden" name="idVenda" value="<?= htmlspecialchars($venda['idVenda']); ?>">
                            
                            <div class="col-md-2">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="idVendaDisplay" value="<?= htmlspecialchars($venda['idVenda']); ?>" readonly placeholder="ID da Venda">
                                    <label for="idVendaDisplay">ID Venda:</label>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <select class="form-select" id="idProduto" name="idProduto" required>
                                        <option value="" selected disabled>-- Selecione um Produto --</option>
                                        <?php foreach ($produtos as $produto): ?>
                                            <option value="<?= htmlspecialchars($produto['idProduto']); ?>" data-valor="<?= htmlspecialchars($produto['valorProduto']); ?>">
                                                <?= htmlspecialchars($produto['nomeProduto']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <label for="idProduto">Produto:</label>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-floating">
                                    <input type="number" class="form-control" id="quantidade" name="quantidade" required min="1" placeholder="Quantidade">
                                    <label for="quantidade">Quantidade:</label>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="valorUnitario" name="valorUnitario" required readonly placeholder="Valor Unitário">
                                    <label for="valorUnitario">Valor Unitário:</label>
                                </div>
                            </div>

                            <div class="col-md-12 text-end">
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-plus-circle"></i> Adicionar Produto
                                </button>
                            </div>
                        </div>
                    </form>

                    <hr class="my-4">

                    <h5 class="mb-3">Produtos Adicionados</h5>
                    <div class="table-responsive">
                        <?php
                        $produtosAssociados = $vendaProdutoModel->listarProdutosVenda($venda['idVenda']);
                        if ($produtosAssociados && mysqli_num_rows($produtosAssociados) > 0) {
                            echo "
                            <table class='table table-hover table-striped'>
                                <thead class='table-dark'>
                                    <tr>
                                        <th>PRODUTO</th>
                                        <th>QUANTIDADE</th>
                                        <th>VALOR UNITÁRIO</th>
                                        <th>TOTAL</th>
                                        <th class='text-center'>AÇÕES</th>
                                    </tr>
                                </thead>
                                <tbody>";

                            while ($registro = mysqli_fetch_assoc($produtosAssociados)) {
                                $totalProduto = $registro['quantidade'] * $registro['valorUnitario'];
                                echo "
                                <tr>
                                    <td>".htmlspecialchars($registro['nomeProduto'])."</td>
                                    <td>".htmlspecialchars($registro['quantidade'])."</td>
                                    <td>R$ " . number_format($registro['valorUnitario'], 2, ',', '.') . "</td>
                                    <td>R$ " . number_format($totalProduto, 2, ',', '.') . "</td>
                                    <td class='text-center'>
                                        <a href='/Projeto_Extensao/controller/VendaController.php?acao=formAtualizarProduto&idProduto=".htmlspecialchars($registro['idProduto'])."&idVenda=".htmlspecialchars($registro['idVenda'])."' class='btn btn-warning btn-sm' title='Atualizar'>
                                            <i class='fas fa-edit'></i>
                                        </a>
                                        <a href='../controller/VendaController.php?acao=excluirProduto&id=" . htmlspecialchars($registro['idProduto']) . "&idVenda=" . htmlspecialchars($idVenda) . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Tem certeza que deseja excluir?\")' title='Excluir'>
                                            <i class='fas fa-trash'></i>
                                        </a>
                                    </td>
                                </tr>";
                            }
                            echo "</tbody></table>";
                        } else {
                            echo "<p class='text-muted'>Nenhum produto associado à venda ainda.</p>";
                        }
                        ?>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-between">
                    <button onclick="history.back()" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Voltar
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById("idProduto").addEventListener("change", function() {
    let selectedOption = this.options[this.selectedIndex];
    let valor = selectedOption.getAttribute("data-valor");
    document.getElementById("valorUnitario").value = valor;
});

window.addEventListener("load", function() {
    let idProdutoSelect = document.getElementById("idProduto");
    if (idProdutoSelect.value) {
        idProdutoSelect.dispatchEvent(new Event("change"));
    }
});
</script>

<?php include("../app/footer.php"); ?>