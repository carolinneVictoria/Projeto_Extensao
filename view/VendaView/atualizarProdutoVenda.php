<?php include("../app/header.php"); ?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white text-center">
                    <h4 class="mb-0">Atualizar Produto na Venda</h4>
                </div>
                <div class="card-body">
                    <form id="formProduto" action="/Projeto_Extensao/controller/VendaController.php?acao=atualizarProduto" method="POST" class="needs-validation" novalidate>
                        <div class="row g-3">
                            <input type="hidden" name="idVenda" value="<?= htmlspecialchars($idVenda); ?>">
                            <input type="hidden" name="idProduto" value="<?= htmlspecialchars($idProduto); ?>">

                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="text" id="produto" class="form-control" disabled value="<?= htmlspecialchars($registro['nomeProduto']); ?>" placeholder="Produto">
                                    <label for="produto">Produto:</label>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="number" class="form-control" id="quantidade" name="quantidade" required min="1" value="<?= (int) $registro['quantidade']; ?>" placeholder="Quantidade">
                                    <label for="quantidade">Quantidade:</label>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="valorUnitario" name="valorUnitario" disabled value="<?= number_format($registro['valorUnitario'], 2, ',', '.'); ?>" placeholder="Valor Unitário">
                                    <label for="valorUnitario">Valor Unitário:</label>
                                </div>
                            </div>

                            <div class="col-12 text-end">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Atualizar Produto
                                </button>
                            </div>
                        </div>
                    </form>

                    <hr class="my-4">

                    <h5 class="mb-3">Produtos na Venda</h5>
                    <div class="table-responsive">
                        <?php
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
                                    <td>" . htmlspecialchars($registro['nomeProduto']) . "</td>
                                    <td>" . htmlspecialchars($registro['quantidade']) . "</td>
                                    <td>R$ " . number_format($registro['valorUnitario'], 2, ',', '.') . "</td>
                                    <td>R$ " . number_format($totalProduto, 2, ',', '.') . "</td>
                                    <td class='text-center'>
                                        <a href='/Projeto_Extensao/controller/VendaController.php?acao=formAtualizarProduto&idProduto=" . htmlspecialchars($registro['idProduto']) . "&idVenda=" . htmlspecialchars($registro['idVenda']) . "' class='btn btn-warning btn-sm' title='Atualizar'>
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
                <div class="card-footer d-flex justify-content-end">
                    <button onclick="history.back()" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Voltar
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include("../app/footer.php"); ?>