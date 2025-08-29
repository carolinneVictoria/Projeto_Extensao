<?php include("../app/header.php"); ?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white text-center">
                    <h4 class="mb-0">Detalhes do Produto</h4>
                </div>
                <div class="card-body">
                    <form>
                        <input type="hidden" name="idProduto" value="<?= htmlspecialchars($produto['idProduto']); ?>">

                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="nomeProduto" name="nomeProduto" value="<?= htmlspecialchars($produto['nomeProduto']); ?>" readonly placeholder="Nome do Produto">
                                    <label for="nomeProduto">Nome do Produto:</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="valorProduto" name="valorProduto" value="R$ <?= number_format($produto['valorProduto'], 2, ',', '.'); ?>" readonly placeholder="Valor do Produto">
                                    <label for="valorProduto">Valor do Produto:</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="categoria" name="categoria" value="<?= htmlspecialchars($produto['descricao']); ?>" readonly placeholder="Categoria">
                                    <label for="categoria">Categoria:</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="quantidadeProduto" name="quantidadeProduto" value="<?= htmlspecialchars($produto['quantidadeProduto']); ?>" readonly placeholder="Quantidade">
                                    <label for="quantidadeProduto">Quantidade:</label>
                                </div>
                            </div>
                            
                            <div class="col-12">
                                <div class="form-floating">
                                    <textarea style="height: 100px" class="form-control" id="descricaoProduto" name="descricaoProduto" readonly placeholder="Descrição do Produto"><?= htmlspecialchars($produto['descricaoProduto']); ?></textarea>
                                    <label for="descricaoProduto">Descrição do Produto:</label>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-between">
                            <button onclick="history.back()" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Voltar
                            </button>
                            <div>
                                <a href='../controller/ProdutoController.php?acao=formAtualizar&id=<?= htmlspecialchars($produto['idProduto']); ?>' class='btn btn-warning me-2 text-white'>
                                    <i class="fas fa-edit"></i> Editar
                                </a>
                                <a href='../controller/ProdutoController.php?acao=excluir&id=<?= htmlspecialchars($idProduto); ?>' class='btn btn-danger' onclick='return confirm("Tem certeza que deseja excluir? Produto tem associação com serviços, sendo assim ele também será excluído desse registro!")'>
                                    <i class="fas fa-trash"></i> Excluir
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include("../app/footer.php") ?>