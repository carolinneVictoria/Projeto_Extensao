<?php include("../app/header.php"); ?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white text-center">
                    <h4 class="mb-0">Atualização de Produto</h4>
                </div>
                <div class="card-body">
                    <form action="../controller/ProdutoController.php?acao=atualizar" method="POST" enctype="multipart/form-data" class="was-validated">
                        <input type="hidden" name="idProduto" value="<?= htmlspecialchars($produto['idProduto']); ?>">

                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="nomeProduto" name="nomeProduto" value="<?= htmlspecialchars($produto['nomeProduto']); ?>" placeholder="Nome do Produto" required>
                                    <label for="nomeProduto">Nome do Produto:</label>
                                    <div class="invalid-feedback">Por favor, insira o nome do produto.</div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="valorProduto" name="valorProduto" value="<?= htmlspecialchars($produto['valorProduto']); ?>" placeholder="Valor do Produto" required>
                                    <label for="valorProduto">Valor do Produto:</label>
                                    <div class="invalid-feedback">Por favor, insira um valor válido.</div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select class="form-select" id="categoriaProduto" name="categoriaProduto" required>
                                        <option value="" disabled>-- Selecione uma Categoria --</option>
                                        <?php foreach ($categoria as $categorias): ?>
                                            <option value="<?= htmlspecialchars($categorias['idCategoria']); ?>"
                                                <?= ($categorias['idCategoria'] == $produto['idCategoria']) ? 'selected' : ''; ?>>
                                                <?= htmlspecialchars($categorias['descricao']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <label for="categoriaProduto">Categoria do Produto:</label>
                                    <div class="invalid-feedback">Por favor, selecione uma categoria.</div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="quantidadeProduto" name="quantidadeProduto" value="<?= htmlspecialchars($produto['quantidadeProduto']); ?>" placeholder="Quantidade" required>
                                    <label for="quantidadeProduto">Quantidade:</label>
                                    <div class="invalid-feedback">Por favor, insira a quantidade.</div>
                                </div>
                            </div>
                            
                            <div class="col-12">
                                <div class="form-floating">
                                    <textarea style="height: 100px" class="form-control" id="descricaoProduto" name="descricaoProduto" placeholder="Descrição do Produto"><?= htmlspecialchars($produto['descricaoProduto']); ?></textarea>
                                    <label for="descricaoProduto">Descrição do Produto:</label>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-between">
                            <a href="javascript:history.back()" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Voltar
                            </a>
                            <button type="submit" class="btn btn-primary text-white">
                                <i class="fas fa-save"></i> Atualizar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include("../app/footer.php") ?>