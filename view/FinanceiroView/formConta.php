<?php include("../../app/header.php"); 
session_start();

?>

<div class="container-fluid">
    <h4>Cadastro de Conta:</h4>

    <div class="col-sm-12">

        <form action="/Projeto_Extensao/controller/FinanceiroController.php?acao=cadastrar" method="POST" enctype="multipart/form-data" class="was-validated">
            <div class="row">

            <div class="col-md-6 mb-3">
                <div class="form-floating">
                    <input type="text" class="form-control" id="descricao" name="descricao" required>
                    <label for="descricao">Descrição:</label>
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <div class="form-floating">
                    <input type="text" class="form-control" id="valorTotal" name="valorTotal" required>
                    <label for="valorTotal">Valor:</label>
                </div>
            </div>

                <div class="col-md-6 mb-3">
                    <div class="form-floating">
                        <input type="date" class="form-control" id="dataVencimento" name="dataVencimento" required>
                        <label for="dataVencimento">Data de Vencimento:</label>
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <div class="form-floating">
                        <select class="form-select" id="status" name="status" required>
                            <option value="1">Pago!</option>
                            <option value="0">Pagamento não efetuado!</option>
                        </select>
                        <label for="status">Entregue:</label>
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