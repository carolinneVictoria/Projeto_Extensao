<?php include("../app/header.php") ; ?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white text-center">
                    <h4 class="mb-0">Cadastro de Produto</h4>
                </div>
                <div class="card-body">
                    <form action="../controller/ProdutoController.php?acao=cadastrar" method="POST" enctype="multipart/form-data" class="was-validated">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="nomeProduto" name="nomeProduto" placeholder="Nome do Produto" required>
                                    <label for="nomeProduto">Nome do Produto:</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="valorProdutoMascara" placeholder="Valor do Produto" required>
                                    <input type="hidden" name="valorProduto" id="valorProduto">
                                    <label for="valorProduto">Valor do Produto:</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select class="form-select" id="categoriaProduto" name="idCategoria" required>
                                        <option value="" selected disabled>-- Selecione uma Categoria --</option>
                                        <?php foreach ($categorias as $categoria): ?>
                                            <option value="<?= htmlspecialchars($categoria['idCategoria']); ?>">
                                                <?= htmlspecialchars($categoria['descricao']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <label for="categoriaProduto">Categoria do Produto:</label>
                                    <div class="invalid-feedback">Por favor, selecione uma categoria.</div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="number" class="form-control" id="quantidadeProduto" name="quantidadeProduto" placeholder="Quantidade" required min="1">
                                    <label for="quantidadeProduto">Quantidade:</label>
                                </div>
                            </div>
                            
                            <div class="col-12">
                                <div class="form-floating">
                                    <textarea class="form-control" id="descricaoProduto" name="descricaoProduto" placeholder="Descrição do Produto" style="height: 100px"></textarea>
                                    <label for="descricaoProduto">Descrição do Produto:</label>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-between">
                            <a href="javascript:history.back()" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Voltar
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Cadastrar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('valorProdutoMascara').addEventListener('input', function (e) {
    let input = e.target.value.replace(/\D/g, '');
    let valorNumerico = (parseInt(input) / 100).toFixed(2);
    let valorFormatado = 'R$ ' + valorNumerico.replace('.', ',');

    e.target.value = valorFormatado;
    document.getElementById('valorProduto').value = valorNumerico;
});
</script>

<?php include("../../app/footer.php") ?>