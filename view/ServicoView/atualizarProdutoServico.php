<?php include("../app/header.php"); ?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white text-center">
                    <h4 class="mb-0">Atualizar Produto do Serviço</h4>
                </div>
                <div class="card-body">
                    <form action="/Projeto_Extensao/controller/ServicoController.php?acao=atualizarProduto" method="POST" enctype="multipart/form-data" class="was-validated">
                        <input type="hidden" name="idServico" value="<?= htmlspecialchars($idServico); ?>">
                        <input type="hidden" name="idProduto" value="<?= htmlspecialchars($idProduto); ?>">

                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" id="produto" class="form-control" disabled value="<?= htmlspecialchars($registro['nomeProduto']); ?>" placeholder="Produto">
                                    <label for="produto">Produto:</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="number" id="quantidade" name="quantidade" class="form-control" min="1" required value="<?= (int) $registro['quantidade']; ?>" placeholder="Quantidade">
                                    <label for="quantidade">Quantidade:</label>
                                    <div class="invalid-feedback">Informe uma quantidade válida.</div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" id="valorUnitarioExibicao" class="form-control" readonly value="R$ <?= number_format($registro['valorUnitario'], 2, ',', '.'); ?>" placeholder="Valor Unitário">
                                    <input type="hidden" id="valorUnitario" name="valorUnitario" value="<?= $registro['valorUnitario']; ?>">
                                    <label for="valorUnitario">Valor Unitário:</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" id="totalProduto" class="form-control" readonly value="R$ <?= number_format($registro['quantidade'] * $registro['valorUnitario'], 2, ',', '.'); ?>" placeholder="Total">
                                    <label for="totalProduto">Total:</label>
                                </div>
                            </div>
                        </div>
                        
                        <hr class="my-4">

                        <div class="d-flex justify-content-between">
                            <a href="javascript:history.back()" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Voltar
                            </a>
                            <button type="submit" class="btn btn-primary text-white">
                                <i class="fas fa-save"></i> Atualizar Produto
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include("../app/footer.php"); ?>