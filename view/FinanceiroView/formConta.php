<?php include("../app/header.php"); ?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white text-center">
                    <h4 class="mb-0">Cadastro de Conta</h4>
                </div>
                <div class="card-body">
                    <form action="/Projeto_Extensao/controller/FinanceiroController.php?acao=cadastrar"method="POST" enctype="multipart/form-data" class="was-validated">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="descricao" name="descricao" placeholder="Descrição" required>
                                    <label for="descricao">Descrição:</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="valorContaMascara" placeholder="Valor" required>
                                    <input type="hidden" name="valorTotal" id="valorTotal">
                                    <label for="valorTotal">Valor:</label>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="date" class="form-control" id="dataVencimento" name="dataVencimento" required>
                                    <label for="dataVencimento">Data de Vencimento:</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select class="form-select" id="status" name="status" required>
                                        <option value="" selected disabled>-- Selecione o Status --</option>
                                        <option value="1">Pago</option>
                                        <option value="0">Pagamento não efetuado</option>
                                    </select>
                                    <label for="status">Status:</label>
                                </div>
                            </div>
                        </div>
                        
                        <hr class="my-4">

                        <div class="d-flex justify-content-between">
                            <a href="javascript:history.back()" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Voltar
                            </a>
                            <button type="submit" class="btn btn-success">
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
document.getElementById('valorContaMascara').addEventListener('input', function (e) {
    let input = e.target.value.replace(/\D/g, '');
    let valorNumerico = (parseInt(input) / 100).toFixed(2);
    let valorFormatado = 'R$ ' + valorNumerico.replace('.', ',');

    e.target.value = valorFormatado;
    document.getElementById('valorTotal').value = valorNumerico;
});
</script>
<?php include("../app/footer.php"); ?>