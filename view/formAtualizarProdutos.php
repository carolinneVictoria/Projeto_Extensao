<?php include("../app/header.php");

include ('../config/conexaoBD.php');
include ('../model/Produto.php');
include ('../model/Categoria.php');

$produtoModel = new Produto($conn);
$categoriaModel = new Categoria($conn);

if (isset($_GET['id'])) {
    $idProduto = $_GET['id'];
    
    $produto = $produtoModel->buscarProdutoPorId($idProduto);
    $categoria = $categoriaModel->listarCategorias();
} else {
    echo "ID do produto não informado!";
    exit(); 
}
?>


<div class="container-fluid text-left">

    <h3>Atualização de Produto:</h3>
    
    <div class="col-sm-12">

    <form action="../controller/ProdutoController.php?acao=atualizar" class="was-validated" method="POST" enctype="multipart/form-data">

        <!-- Campos do formulário -->
        
        <input type="hidden" name="idProduto" value="<?= $produto['idProduto']; ?> ">

        <div class="row">


        <div class="col-md-6 mb-3">
            <div class="form-floating">
                <input type="text" class="form-control" id="nomeProduto" name="nomeProduto" value="<?= $produto['nomeProduto']; ?>" required>
                <label for="nomeProduto">Nome do Produto:</label>
            </div>
        </div>

        <div class="col-md-6 mb-3">
            <div class="form-floating">
                <input type="text" class="form-control" id="valorProduto" name="valorProduto" value="<?= $produto['valorProduto']; ?>" required>
                <label for="valorProduto">Valor do Produto:</label>
            </div>
        </div>

        <div class="col-md-12 mb-3">
            <div class="form-floating">
                <textarea style="height: 100px" class="form-control" id="descricaoProduto" name="descricaoProduto"><?= $produto['descricaoProduto']; ?></textarea>
                <label for="descricaoProduto">Descrição do Produto:</label>
            </div>
        </div>

        <div class="col-md-6 mb-3">
            <div class="form-floating">
                <select class="form-control" id="categoriaProduto" name="categoriaProduto" required>
                    <?php foreach ($categoria as $categorias): ?>
                        <option value="<?= $categorias['idCategoria']; ?>" 
                            <?= $categorias['idCategoria'] == $produto['idCategoria'] ? 'selected' : ''; ?>>
                            <?= $categorias['descricao']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            <label for="categoriaProduto">Categoria do Produto:</label>
            </div>
        </div>

        <div class="col-md-6 mb-3">
            <div class="form-floating">
                <input type="text" class="form-control" id="quantidadeProduto" name="quantidadeProduto" value="<?= $produto['quantidadeProduto']; ?>" required>
                <label for="quantidadeProduto">Quantidade:</label>
            </div>
        </div>

        <div class="col-md-12 text-end">
            <button type="submit" class="btn btn-primary mt-3">Atualizar</button>
        </div>

        </div>

    </form>
    </div>
    

</div>

<?php include("../app/footer.php") ?>
