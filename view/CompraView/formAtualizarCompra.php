<?php include("../app/header.php"); ?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white text-center">
                    <h4 class="mb-0">Atualizar Compra</h4>
                </div>
                <div class="card-body">
                    <form id="formCompra" action="/Projeto_Extensao/controller/CompraController.php?acao=atualizar" method="POST" enctype="multipart/form-data" class="was-validated">
                        <input type="hidden" name="idCompra" value="<?= htmlspecialchars($compra['idCompra']); ?>">

                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="idUsuario" value="<?= htmlspecialchars($compra['nomeUsuario']); ?>" readonly placeholder="Usuário">
                                    <input type="hidden" name="idUsuario" value="<?= htmlspecialchars($compra['idUsuario']); ?>">
                                    <label for="idUsuario">Usuário:</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="idFornecedor" value="<?= htmlspecialchars($compra['razaoSocial']); ?>" readonly placeholder="Fornecedor">
                                    <input type="hidden" name="idFornecedor" value="<?= htmlspecialchars($compra['idFornecedor']); ?>">
                                    <label for="idFornecedor">Fornecedor:</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="date" class="form-control" id="data" name="data" value="<?= htmlspecialchars($compra['data']); ?>" placeholder="Data da Compra" required>
                                    <label for="data">Data da compra:</label>
                                    <div class="invalid-feedback">Por favor, insira a data da compra.</div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="valorTotal" name="valorTotal" value="<?= number_format($compra['valorTotal'], 2, ',', '.'); ?>" placeholder="Valor Total" required>
                                    <label for="valorTotal">Valor Total:</label>
                                    <div class="invalid-feedback">Por favor, insira o valor total.</div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-floating">
                                    <textarea style="height: 100px" class="form-control" id="descricao" name="descricao" placeholder="Descrição"><?= htmlspecialchars($compra['descricao']); ?></textarea>
                                    <label for="descricao">Descrição:</label>
                                    <div class="invalid-feedback">Por favor, insira a descrição.</div>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <h5>Produtos</h5>
                        <div class="table-responsive">
                            <?php if (!empty($produtosAssociados)): ?>
                                <table class="table table-hover table-striped">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>PRODUTO</th>
                                            <th>QUANTIDADE</th>
                                            <th>VALOR UNITÁRIO</th>
                                            <th class='text-center'>AÇÕES</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                <?php foreach ($produtosAssociados as $registro): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($registro['nomeProduto']); ?></td>
                                        <td><?= htmlspecialchars($registro['quantidade']); ?></td>
                                        <td>R$ <?= number_format($registro['valorUnitario'], 2, ',', '.'); ?></td>
                                        <td class="text-center">
                                            <a href="/Projeto_Extensao/controller/CompraController.php?acao=formAtualizarProduto&idProduto=<?= htmlspecialchars($registro['idProduto']); ?>&idCompra=<?= htmlspecialchars($registro['idCompra']); ?>" class="btn btn-warning btn-sm" title="Atualizar Produto">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="/Projeto_Extensao/controller/CompraController.php?acao=excluirProduto&id=<?= htmlspecialchars($registro['idProduto']); ?>&idCompra=<?= htmlspecialchars($idCompra); ?>" class="btn btn-danger btn-sm" onclick='return confirm("Tem certeza que deseja excluir?")' title="Excluir Produto">
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
                        <a href="../controller/CompraController.php?acao=formProdutoCompra&id=<?= htmlspecialchars($idCompra); ?>" class="btn btn-primary me-2 text-white">
                            <i class="fas fa-plus"></i> Adicionar Produtos
                        </a>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i> Realizar Compra
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include("../app/footer.php"); ?>