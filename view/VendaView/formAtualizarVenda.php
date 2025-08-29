<?php include("../app/header.php"); ?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white text-center">
                    <h4 class="mb-0">Detalhes da Venda</h4>
                </div>
                <div class="card-body">
                    <form id="formVenda" action="/Projeto_Extensao/controller/VendaController.php?acao=atualizar" method="POST" class="needs-validation" novalidate>
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
                                    <input type="date" class="form-control" id="data" name="data" value="<?= htmlspecialchars($venda['data']); ?>">
                                    <label for="data">Data da Venda:</label>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="descontoVenda" name="descontoVenda" value="<?= htmlspecialchars($venda['descontoVenda']); ?>" placeholder="Desconto">
                                    <label for="descontoVenda">Desconto:</label>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="hidden" name="valorTotal" value="<?= htmlspecialchars($valorTotal); ?>">
                                    <input type="text" class="form-control" id="valorTotal" readonly value="R$ <?= number_format($valorTotal, 2, ',', '.'); ?>" placeholder="Valor Total">
                                    <label for="valorTotal">Valor Total:</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select class="form-select" id="formaPagamento" name="formaPagamento" required>
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
                                            <th class="text-center">AÇÕES</th>
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
                                                <td class="text-center">
                                                    <a href="/Projeto_Extensao/controller/VendaController.php?acao=formAtualizarProduto&idProduto=<?= htmlspecialchars($registro['idProduto']); ?>&idVenda=<?= htmlspecialchars($registro['idVenda']); ?>" class="btn btn-warning btn-sm" title="Atualizar Produto">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <a href="/Projeto_Extensao/controller/VendaController.php?acao=excluirProduto&id=<?= htmlspecialchars($registro['idProduto']); ?>&idVenda=<?= htmlspecialchars($idVenda); ?>" class="btn btn-danger btn-sm" onclick='return confirm("Tem certeza que deseja excluir?")' title="Excluir Produto">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            <?php else: ?>
                                <p class="text-muted">Nenhum produto associado à venda ainda.</p>
                            <?php endif; ?>
                        </div>

                        <hr class="my-4">
                        
                        <div class="d-flex justify-content-between">
                            <a href="javascript:history.back()" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Voltar
                            </a>
                            <div>
                                <a href="../controller/VendaController.php?acao=formProdutoVenda&id=<?= htmlspecialchars($idVenda); ?>" class="btn btn-primary me-2 text-white">
                                    <i class="fas fa-plus"></i> Adicionar Produtos
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Finalizar Venda
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include("../../app/footer.php") ?>