<?php include("../app/header.php"); ?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white text-center">
                    <h4 class="mb-0">Atualizar Serviço</h4>
                </div>
                <div class="card-body">
                    <form id="formServico" action="/Projeto_Extensao/controller/ServicoController.php?acao=atualizar" method="POST" enctype="multipart/form-data" class="was-validated">
                        <input type="hidden" name="idServico" value="<?= htmlspecialchars($idServico); ?>">

                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="idCliente" readonly value="<?= htmlspecialchars($servico['nome']); ?>" placeholder="Cliente">
                                    <input type="hidden" name="idCliente" value="<?= htmlspecialchars($servico['idCliente']); ?>">
                                    <label for="idCliente">Cliente:</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="idUsuario" readonly value="<?= htmlspecialchars($servico['nomeUsuario']); ?>" placeholder="Usuário">
                                    <input type="hidden" name="idUsuario" value="<?= htmlspecialchars($servico['idUsuario']); ?>">
                                    <label for="idUsuario">Usuário:</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="date" class="form-control" id="dataEntrada" name="dataEntrada" value="<?= htmlspecialchars($servico['dataEntrada']); ?>" placeholder="Data de Entrada">
                                    <label for="dataEntrada">Data de Entrada:</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="maoDeObra" name="maodeObra" value="<?= number_format($servico['maodeObra'], 2, ',', '.'); ?>" placeholder="Mão de Obra" required>
                                    <label for="maoDeObra">Mão de Obra:</label>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-floating">
                                    <textarea style="height: 100px" class="form-control" id="descricao" name="descricao" placeholder="Descrição"><?= htmlspecialchars($servico['descricao']); ?></textarea>
                                    <label for="descricao">Descrição:</label>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="valorTotal" readonly value="R$ <?= number_format($valorTotal + $servico['maodeObra'], 2, ',', '.'); ?>" placeholder="Valor Total">
                                    <label for="valorTotal">Valor Total:</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select class="form-select" id="entrega" name="entrega" required>
                                        <option value="1" <?= ($servico['entrega'] == 1) ? 'selected' : ''; ?>>Não</option>
                                        <option value="0" <?= ($servico['entrega'] == 0) ? 'selected' : ''; ?>>Sim</option>
                                    </select>
                                    <label for="entrega">Entregue:</label>
                                </div>
                            </div>
                        </div>
                        
                        <hr class="my-4">

                        <h5>Produtos Usados</h5>
                        <div class="table-responsive">
                            <?php
                            if (!empty($produtosAssociados)) {
                                echo "
                                <table class='table table-hover table-bordered table-sm'>
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

                                foreach ($produtosAssociados as $registro) {
                                    $totalProduto = $registro['quantidade'] * $registro['valorUnitario'];
                                    echo "
                                    <tr>
                                        <td>" . htmlspecialchars($registro['nomeProduto']) . "</td>
                                        <td>" . htmlspecialchars($registro['quantidade']) . "</td>
                                        <td>R$ " . number_format($registro['valorUnitario'], 2, ',', '.') . "</td>
                                        <td>R$ " . number_format($totalProduto, 2, ',', '.') . "</td>
                                        <td class='text-center'>
                                            <a href='/Projeto_Extensao/controller/ServicoController.php?acao=formAtualizarProduto&idProduto=" . htmlspecialchars($registro['idProduto']) . "&idServico=" . htmlspecialchars($registro['idServico']) . "' class='btn btn-warning btn-sm' title='Atualizar'>
                                                <i class='fas fa-edit'></i>
                                            </a>
                                            <a href='/Projeto_Extensao/controller/ServicoController.php?acao=excluirProduto&id=" . htmlspecialchars($registro['idProduto']) . "&idServico=" . htmlspecialchars($idServico) . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Tem certeza que deseja excluir?\")' title='Excluir'>
                                                <i class='fas fa-trash'></i>
                                            </a>
                                        </td>
                                    </tr>";
                                }
                                echo "</tbody></table>";
                            } else {
                                echo "<p class='text-muted'>Nenhum produto associado ao serviço ainda.</p>";
                            }
                            ?>
                        </div>

                        <hr class="my-4">
                        
                        <div class="d-flex justify-content-between">
                            <button onclick="history.back()" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Voltar
                            </button>
                            <div>
                                <a href="/Projeto_Extensao/controller/ServicoController.php?acao=formProdutoServico&id=<?= htmlspecialchars($idServico); ?>" class="btn btn-info me-2 text-white" title="Adicionar Produtos">
                                    <i class="fas fa-plus"></i> Adicionar Produtos
                                </a>
                                <button type="submit" class="btn btn-success text-white">
                                    <i class="fas fa-save"></i> Atualizar Serviço
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include("../../app/footer.php"); ?>