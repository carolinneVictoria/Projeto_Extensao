<?php include("../app/header.php") ?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white text-center">
                    <h4 class="mb-0">Atualizar Conta</h4>
                </div>
                <div class="card-body">
                    <form action="/Projeto_Extensao/controller/FinanceiroController.php?acao=atualizar" method="POST" enctype="multipart/form-data" class="was-validated">
                        <input type="hidden" name="idConta" value="<?= htmlspecialchars($conta['idConta']); ?>">
                        
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="descricao" name="descricao" value="<?= htmlspecialchars($conta['descricao']); ?>" placeholder="Descrição" required>
                                    <label for="descricao">Descrição:</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="valorContaMascara" value="<?= htmlspecialchars($conta['valorTotal']); ?>" placeholder="Valor" required>
                                    <input type="hidden" name="valorTotal" id="valorTotal">
                                    <label for="valorTotal">Valor:</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="date" class="form-control" id="dataVencimento" name="dataVencimento" value="<?= htmlspecialchars($conta['dataVencimento']); ?>" placeholder="Data de Vencimento">
                                    <label for="valorTotal">Data de Vencimento:</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select class="form-select" id="status" name="status" required>
                                        <option value="1" <?= ($conta['status'] == 1) ? 'selected' : ''; ?>>Pago</option>
                                        <option value="0" <?= ($conta['status'] == 0) ? 'selected' : ''; ?>>A Pagar</option>
                                    </select>
                                    <label for="status">Status:</label>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">
                        
                        <div class="d-flex justify-content-between">
                            <a href="../controller/FinanceiroController.php?acao=listar" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Voltar
                            </a>
                            <button type="submit" class="btn btn-primary text-white">
                                <i class="fas fa-save"></i> Atualizar
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
<?php include("../app/footer.php") ?>