<div class="container-fluid">
    <h4>Detalhes da Conta:</h4>

    <div class="col-sm-12">

        <form action="/Projeto_Extensao/controller/FinanceiroController.php" method="POST" enctype="multipart/form-data" class="was-validated">
        
        <input type="hidden" name="idConta" value="<?= $conta['idConta']; ?> ">
        
        <div class="row">

            <div class="col-md-6 mb-3">
                <div class="form-floating border border-info rounded">
                    <input type="text" class="form-control" id="descricao" name="descricao" value="<?= htmlspecialchars($conta['descricao']); ?>" required readonly>
                    <label for="descricao">Descrição:</label>
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <div class="form-floating border border-info rounded">
                    <input type="text" class="form-control" id="valorTotal" name="valorTotal" value="<?= htmlspecialchars($conta['valorTotal']); ?>" required readonly>
                    <label for="valorTotal">Valor:</label>
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <div class="form-floating border border-info rounded">
                    <input type="text" class="form-control" id="dataVencimento" name="dataVencimento" value="<?= htmlspecialchars($conta['dataVencimento']); ?>" readonly >
                    <label for="dataVencimento">Data de Vencimento</label>
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <div class="form-floating border border-info rounded">
                    <select class="form-select" id="status" name="status" readonly>
                        <option value="1" <?= $conta['status']==1?'selected':'' ?>>Pago!</option>
                        <option value="0" <?= $conta['status']==0?'selected':'' ?>>A Pagar!</option>
                    </select>
                    <label for="status">Status:</label>
                </div>
            </div>

            <div class="col-md-12 mb-3">
                <div class="d-flex justify-content-end gap-2">
                    <a href='../controller/FinanceiroController.php?acao=atualizar&id=<?= $idConta ?>' class='btn btn-primary btn-sm'>Atualizar</a>
                    <a href='../controller/FinanceiroController.php?acao=excluir&id=<?= $idConta ?>' class='btn btn-danger btn-sm' onclick='return confirm("Tem certeza que deseja excluir?")'>Excluir</a>
                    <a href="../controller/FinanceiroController.php" class="btn btn-secondary btn me-2">Voltar</a>
                </div>
            </div>

            </div>
        </form>
    </div>
</div>

<?php include("../../app/footer.php"); ?>