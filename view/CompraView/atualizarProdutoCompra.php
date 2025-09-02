<?php include("../app/header.php"); ?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white text-center">
                    <h4 class="mb-0">Atualizar Produto da Compra</h4>
                </div>
                <div class="card-body">
                    <form id="formProduto" action="/Projeto_Extensao/controller/CompraController.php?acao=atualizarProduto" method="POST" enctype="multipart/form-data" class="was-validated">
                        <div class="row g-3">
                            <input type="hidden" name="idCompra" value="<?= htmlspecialchars($idCompra); ?>">
                            <input type="hidden" name="idProduto" value="<?= htmlspecialchars($idProduto); ?>">
                            
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" id="produto" class="form-control" disabled value="<?= htmlspecialchars($registro['nomeProduto']); ?>" placeholder="Produto">
                                    <label for="produto">Produto:</label>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="number" class="form-control" id="quantidade" name="quantidade" required min="1" value="<?= (int) $registro['quantidade']; ?>" placeholder="Quantidade">
                                    <label for="quantidade">Quantidade:</label>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" id="valorUnitarioExibicao" class="form-control" readonly value="R$ <?= number_format($registro['valorUnitario'], 2, ',', '.'); ?>" placeholder="Valor Unitário">
                                    <input type="hidden" id="valorUnitario" name="valorUnitario" value="<?= $registro['valorUnitario']; ?>">
                                    <label for="valorUnitario">Valor Unitário:</label>
                                </div>
                            </div>

                            <div class="col-12 text-end">
                                <button type="submit" class="btn btn-primary text-white">
                                    <i class="fas fa-save"></i> Atualizar Produto
                                </button>
                            </div>
                        </div>
                    </form>
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