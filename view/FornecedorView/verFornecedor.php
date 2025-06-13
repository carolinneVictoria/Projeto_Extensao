<?php include("../../app/header.php"); 
include ('./../config/conexaoBD.php');
include ('../../model/Fornecedor.php');

$fornecedorModel = new Fornecedor($conn);
if (isset($_GET['id'])) {
    $idFornecedor = $_GET['id'];
    
    $fornecedor = $fornecedorModel->buscarFornecedorPorId($idFornecedor);
} else {
    echo "ID do Fornecedor não informado!";
    exit(); 
}
?>

<div class="container-fluid">
    <h4>Detalhes do Fornecedor:</h4>
 
    <div class="col-sm-12">

        <form action="/Projeto_Extensao/controller/FornecedorController.php?acao=atualizar" method="POST" enctype="multipart/form-data" class="was-validated">
        
        <input type="hidden" name="idFornecedor" value="<?= $fornecedor['idFornecedor']; ?> ">
        
        <div class="row">

            <div class="col-md-6 mb-3">
                <div class="form-floating border border-info rounded">
                    <input type="text" class="form-control" id="cnpj" name="cnpj" value="<?= htmlspecialchars($fornecedor['cnpj']); ?>" required readonly>
                    <label for="cnpj">CNPJ:</label>
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <div class="form-floating border border-info rounded">
                    <input type="text" class="form-control" id="razaoSocial" name="razaoSocial" value="<?= htmlspecialchars($fornecedor['razaoSocial']); ?>" required readonly>
                    <label for="razaoSocial">Razão Social:</label>
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <div class="form-floating border border-info rounded">
                    <input type="text" class="form-control" id="endereco" name="endereco" value="<?= htmlspecialchars($fornecedor['endereco']); ?>" readonly >
                    <label for="endereco">Endereço</label>
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <div class="form-floating border border-info rounded">
                    <input type="text" class="form-control" id="telefone" name="telefone" value="<?= htmlspecialchars($fornecedor['telefone']); ?>" required readonly>
                    <label for="telefone">Telefone:</label>
                </div>
            </div>

           <div class="col-md-12 mb-3">
                <div class="d-flex justify-content-end gap-2">
                    <a href='formAtualizarFornecedor.php?id=<?= $idFornecedor ?>' class='btn btn-primary btn-sm'>Atualizar</a>
                    <a href='../../controller/FornecedorController.php?acao=excluir&id=<?= $idFornecedor?>' class='btn btn-danger btn-sm' onclick='return confirm(\"Tem certeza que deseja excluir?\")'>Excluir</a>
                    <a href="fornecedores.php" class="btn btn-secondary btn me-2">Voltar</a>
                </div>
            </div>

            </div>
        </form>
    </div>
</div>

<?php include("../../app/footer.php"); ?>