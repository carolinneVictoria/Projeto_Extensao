<div class="container-fluid">
    <h4>Atualizar Conta:</h4>

    <div class="col-sm-12">

        <form action="/Projeto_Extensao/controller/FinanceiroController.php?acao=atualizar" method="POST" enctype="multipart/form-data" class="was-validated">
        
        <input type="hidden" name="idConta" value="<?= $conta['idConta']; ?> ">
        
        <div class="row">

            <div class="col-md-6 mb-3">
                <div class="form-floating">
                    <input type="text" class="form-control" id="descricao" name="descricao" value="<?= htmlspecialchars($conta['descricao']); ?>" required>
                    <label for="descricao">Descrição:</label>
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <div class="form-floating">
                    <input type="text" class="form-control" id="valorTotal" name="valorTotal" value="<?= htmlspecialchars($conta['valorTotal']); ?>" required>
                    <label for="valorTotal">Valor:</label>
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <div class="form-floating">
                    <input type="text" class="form-control" id="dataVencimento" name="dataVencimento" value="<?= htmlspecialchars($conta['dataVencimento']); ?>" >
                    <label for="dataVencimento">Data de Vencimento</label>
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <div class="form-floating">
                    <select class="form-select" id="status" name="status">
                        <option value="1" <?= $conta['status']==1?'selected':'' ?>>Pago!</option>
                        <option value="0" <?= $conta['status']==0?'selected':'' ?>>A Pagar!</option>
                    </select>
                    <label for="status">Status:</label>
                </div>
            </div>

            <div class="col-md-12 text-end">
                <button type="submit" class="btn btn-primary">Atualizar</button>
            </div>

            </div>
        </form>
    </div>
</div>