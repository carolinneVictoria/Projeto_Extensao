<?php include("../../app/header.php"); 
session_start();

?>

<div class="container-fluid">
    <h4>Cadastro de Cliente:</h4>
 
    <div class="col-sm-12">

        <form action="/Projeto_Extensao/controller/ClienteController.php?acao=cadastrar" method="POST" enctype="multipart/form-data" class="was-validated">
            <div class="row">


            <div class="col-md-6 mb-3">
                <div class="form-floating">
                    <input type="text" class="form-control" id="nome" name="nome" required>
                    <label for="nome">Nome:</label>
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <div class="form-floating">
                    <input type="text" class="form-control" id="telefone" name="telefone" required>
                    <label for="telefone">Telefone:</label>
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <div class="form-floating">
                    <input type="text" class="form-control" id="cpf" name="cpf" required>
                    <label for="cpf">CPF:</label>
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <div class="form-floating">
                    <input type="date" class="form-control" id="dataNascimento" name="dataNascimento" required>
                    <label for="dataNascimento">Data de Nascimento:</label>
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
                    <input type="text" class="form-control" id="bicicleta" name="bicicleta">
                    <label for="bicicleta">Bicicleta</label>
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