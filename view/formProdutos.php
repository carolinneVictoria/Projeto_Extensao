<?php include("../app/header.php") ;

include_once('../config/conexaoBD.php');
include_once ('../model/Categoria.php');

    $modelCategoria = new Categoria($conn);
    $categorias = $modelCategoria->listarCategorias();

?>

<div class="container-fluid text-left">

    <h3>Cadastro de Produto:</h3>

    
    <div class="col-sm-12">

    <form action="../controller/ProdutoController.php?acao=cadastrar" class="was-validated" method="POST" enctype="multipart/form-data">

        <!-- Campos do formulário -->
        <div class="row">

        <div class="col-md-6 mb-3">
            <div class="form-floating">
                <input type="text" class="form-control" id="nomeProduto" name="nomeProduto" required>
                <label for="nomeProduto">Nome do Produto:</label>
            </div>
        </div>

        <div class="col-md-6 mb-3">
            <div class="form-floating">
                <input type="text" class="form-control" id="valorProduto" name="valorProduto" required>
                <label for="valorProduto">Valor do Produto:</label>
            </div>
        </div>

        <div class="col-md-12 mb-3">
            <div class="form-floating">
                <textarea class="form-control" id="descricaoProduto" name="descricaoProduto" required style="height: 100px"></textarea>
                <label for="descricaoProduto">Descrição do Produto:</label>
            </div>
        </div>

        <div class="col-md-6 mb-3">
            <div class="form-floating">
                <select class="form-control" id="categoriaProduto" name="categoriaProduto" required>
                    <?php foreach ($categorias as $categoria): ?>
                        <option value="<?= $categoria['idCategoria']; ?>">
                            <?= $categoria['descricao']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <label for="categoriaProduto">Categoria do Produto:</label>
            </div>
        </div>

        <div class="col-md-6 mb-3">
            <div class="form-floating">
                <textarea class="form-control" id="quantidadeProduto" name="quantidadeProduto" required></textarea>
                <label for="quantidadeProduto">Quantidade:</label>
            </div>
        </div>

        <div class="col-md-12 text-end">
            <button type="submit" class="btn btn-primary mt-3">Cadastrar</button>
        </div>

        </div>

        

    </form>
    </div>
    

</div>

<?php include("../app/footer.php") ?>
