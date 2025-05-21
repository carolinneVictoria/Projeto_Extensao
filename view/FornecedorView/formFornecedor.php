<?php include("../../app/header.php"); 
session_start();

?>

<div class="container-fluid">
    <h4>Cadastro de Fornecedor:</h4>
 
    <div class="col-sm-12">

        <form action="/Projeto_Extensao/controller/FornecedorController.php?acao=cadastrar" method="POST" enctype="multipart/form-data" class="was-validated">
            <div class="row">

            <div class="col-md-6 mb-3">
                <div class="form-floating">
                    <input type="text" class="form-control" id="cnpj" name="cnpj" required>
                    <label for="cnpj">CNPJ:</label>
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <div class="form-floating">
                    <input type="text" class="form-control" id="razaoSocial" name="razaoSocial" required>
                    <label for="razaoSocial">Razão Social:</label>
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <div class="form-floating">
                    <input type="text" class="form-control" id="endereco" name="endereco" >
                    <label for="endereco">Endereço</label>
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <div class="form-floating">
                    <input type="text" class="form-control" id="telefone" name="telefone" required>
                    <label for="telefone">Telefone:</label>
                </div>
            </div>

            <div class="col-md-12 text-end">
                <button type="submit" class="btn btn-primary">Cadastrar</button>
            </div>

            </div>
        </form>
    </div>
</div>

<?php include("../../app/footer.php"); ?>