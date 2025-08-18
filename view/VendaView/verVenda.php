<?php include("../app/header.php"); ?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white text-center">
                    <h4 class="mb-0">Detalhes da Venda</h4>
                </div>
                <div class="card-body">
                    <form novalidate>
                        <input type="hidden" name="idVenda" value="<?= htmlspecialchars($idVenda); ?>">

                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="idUsuario" value="<?= htmlspecialchars($venda['nomeUsuario']); ?>" disabled placeholder="Usuário">
                                    <input type="hidden" name="idUsuario" value="<?= htmlspecialchars($venda['idUsuario']); ?>">
                                    <label for="idUsuario">Usuário:</label>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="date" class="form-control" id="data" name="data" value="<?= htmlspecialchars($venda['data']); ?>" disabled placeholder="Data da Venda">
                                    <label for="dataEntrada">Data da Venda:</label>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="valorTotal" disabled value="R$ <?= number_format($venda['valorTotal'], 2, ',', '.'); ?>" placeholder="Valor Total">
                                    <label for="valorTotal">Valor Total:</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="descontoVenda" name="descontoVenda" value="R$ <?= number_format($venda['descontoVenda'], 2, ',', '.'); ?>" disabled placeholder="Desconto">
                                    <label for="descontoVenda">Desconto:</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select class="form-select" id="formaPagamento" name="formaPagamento" required disabled>
                                        <option value="Pix" <?= ($venda['formaPagamento'] == 'Pix') ? 'selected' : '' ?>>Pix</option>
                                        <option value="Dinheiro" <?= ($venda['formaPagamento'] == 'Dinheiro') ? 'selected' : '' ?>>Dinheiro</option>
                                        <option value="Cartão de Débito" <?= ($venda['formaPagamento'] == 'Cartão de Débito') ? 'selected' : '' ?>>Cartão de Débito</option>
                                        <option value="Cartão de Crédito" <?= ($venda['formaPagamento'] == 'Cartão de Crédito') ? 'selected' : '' ?>>Cartão de Crédito</option>
                                    </select>
                                    <label for="formaPagamento">Forma de Pagamento:</label>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <h5 class="mb-3">Produtos da Venda</h5>
                        <div class="table-responsive">
                            <?php if (!empty($produtosAssociados)): ?>
                                <table class="table table-hover table-striped">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>PRODUTO</th>
                                            <th>QUANTIDADE</th>
                                            <th>VALOR UNITÁRIO</th>
                                            <th>TOTAL</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($produtosAssociados as $registro): ?>
                                            <?php $totalProduto = $registro['quantidade'] * $registro['valorUnitario']; ?>
                                            <tr>
                                                <td><?= htmlspecialchars($registro['nomeProduto']); ?></td>
                                                <td><?= htmlspecialchars($registro['quantidade']); ?></td>
                                                <td>R$ <?= number_format($registro['valorUnitario'], 2, ',', '.'); ?></td>
                                                <td>R$ <?= number_format($totalProduto, 2, ',', '.'); ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            <?php else: ?>
                                <p class="text-muted">Nenhum produto associado à venda.</p>
                            <?php endif; ?>
                        </div>
                    </form>
                </div>
                <div class="card-footer d-flex justify-content-between">
                    <a href="javascript:history.back()" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Voltar
                    </a>
                    <div>
                        <a href='../controller/VendaController.php?acao=formAtualizar&id=<?= htmlspecialchars($idVenda); ?>' class='btn btn-warning me-2 text-white' title="Editar Venda">
                            <i class="fas fa-edit"></i> Editar
                        </a>
                        <a href='../../controller/VendaController.php?acao=excluir&id=<?= htmlspecialchars($idVenda); ?>' class='btn btn-danger' onclick='return confirm("Tem certeza que deseja excluir?")' title="Excluir Venda">
                            <i class="fas fa-trash"></i> Excluir
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include("../../app/footer.php"); ?>