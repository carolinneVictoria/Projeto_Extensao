<?php include("../../app/header.php");

include ('../../config/conexaoBD.php');
include ('../../model/Produto.php');
include ('../../model/Categoria.php');

$produtoModel = new Produto($conn);
$categoriaModel = new Categoria($conn);

if (isset($_GET['id'])) {
    $idProduto = $_GET['id'];
    
    $produto = $produtoModel->buscarProdutoPorId($idProduto);
    $categoria = $categoriaModel->listarCategoria();
} else {
    echo "ID do produto não informado!";
    exit(); 
}
?>


<div class="container-fluid text-left">

    <h3>Detalhes do Produto:</h3>
    
    <div class="col-sm-12">
        
        <input type="hidden" name="idProduto" value="<?= $produto['idProduto']; ?> ">

        <div class="row">
        <div class="col-md-6 mb-3" >
            <div class="form-floating">
                <input type="text" class="form-control border border-info rounded" id="nomeProduto" name="nomeProduto" value="<?= $produto['nomeProduto']; ?>" required readonly>
                <label for="nomeProduto">Nome do Produto:</label>
            </div>
        </div>

        <div class="col-md-6 mb-3">
            <div class="form-floating">
                <input type="text" class="form-control border border-info rounded" id="valorProduto" name="valorProduto" value="<?= $produto['valorProduto']; ?>" required readonly>
                <label for="valorProduto">Valor do Produto:</label>
            </div>
        </div>

        <div class="col-md-12 mb-3">
            <div class="form-floating">
                <textarea style="height: 100px" class="form-control border border-info rounded" id="descricaoProduto" name="descricaoProduto" readonly><?= $produto['descricaoProduto']; ?></textarea>
                <label for="descricaoProduto">Descrição do Produto:</label>
            </div>
        </div>

        <div class="col-md-6 mb-3">
            <div class="form-floating">
                <select class="form-control border border-info rounded" id="categoriaProduto" name="categoriaProduto" required readonly>
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
                <input type="text" class="form-control border border-info rounded" id="quantidadeProduto" name="quantidadeProduto" value="<?= $produto['quantidadeProduto']; ?>" required readonly>
                <label for="quantidadeProduto">Quantidade:</label>
            </div>
        </div>

        <div class="col-md-12 mb-3">
            <div class="d-flex justify-content-end gap-2">
                <a href='formAtualizarProdutos.php?id=<?= $idProduto ?>' class='btn btn-primary btn-sm'>Atualizar</a>
                <a href='../../controller/ProdutoController.php?acao=excluir&id=<?= $idProduto ?>' class='btn btn-danger btn-sm' onclick='return confirm("Tem certeza que deseja excluir? Produto tem associação com serviços, sendo assim ele também sera excluido desse registro!")'>Excluir</a>
                <a href="produtos.php" class="btn btn-secondary btn-sm">Voltar</a>
            </div>
        </div>

        </div>

        </div>

    </form>
    </div>
    

</div>

<?php include("../../app/footer.php") ?>
