<?php include("../app/header.php");?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white text-center">
                    <h4 class="mb-0">Detalhes do Serviço</h4>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="cliente" disabled value="<?= htmlspecialchars($servico['nome']); ?>" placeholder="Cliente">
                                <label for="cliente">Cliente:</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="usuario" disabled value="<?= htmlspecialchars($servico['nomeUsuario']); ?>" placeholder="Usuário Responsável">
                                <label for="usuario">Usuário Responsável:</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-floating">
                                <input type="date" class="form-control" id="dataEntrada" disabled value="<?= htmlspecialchars($servico['dataEntrada']); ?>" placeholder="Data de Entrada">
                                <label for="dataEntrada">Data de Entrada:</label>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="maodeObra" disabled value="R$ <?= number_format($servico['maodeObra'], 2, ',', '.') ?>" placeholder="Mão de Obra">
                                <label for="maodeObra">Mão de Obra:</label>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="valorTotal" disabled value="R$ <?= number_format($valorTotal, 2, ',', '.'); ?>" placeholder="Valor Total">
                                <label for="valorTotal">Valor Total:</label>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-floating">
                                <textarea style="height: 100px" class="form-control" id="descricao" disabled placeholder="Descrição"><?= htmlspecialchars($servico['descricao']); ?></textarea>
                                <label for="descricao">Descrição:</label>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <h5 class="mb-3">Produtos Usados</h5>
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
                            <p class="text-muted">Nenhum produto associado ao serviço ainda.</p>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="card-footer d-flex justify-content-between">
    <button onclick="history.back()" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Voltar
    </button>

                <div>
                    <!-- Botão de exportação para PDF -->
                    <a href='/Projeto_Extensao/controller/ServicoController.php?acao=exportarPDF&id=<?= htmlspecialchars($idServico); ?>' class='btn btn-outline-danger me-2' title="Exportar para PDF" target="_blank">
                        <i class="fas fa-file-pdf"></i> Exportar
                    </a>

                    <!-- Botão de edição -->
                    <a href='/Projeto_Extensao/controller/ServicoController.php?acao=formAtualizar&id=<?= htmlspecialchars($idServico); ?>' class='btn btn-warning me-2 text-white' title="Editar Serviço">
                        <i class="fas fa-edit"></i> Editar
                    </a>

                    <!-- Botão de exclusão -->
                    <a href='/Projeto_Extensao/controller/ServicoController.php?acao=excluir&id=<?= htmlspecialchars($idServico); ?>' class='btn btn-danger' onclick='return confirm("Tem certeza que deseja excluir?")' title="Excluir Serviço">
                        <i class="fas fa-trash"></i> Excluir
                    </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<?php include("../app/footer.php") ?>