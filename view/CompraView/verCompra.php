<div class="container-fluid"><p></p>
    <h4>Detalhes da Compra:</h4>
    <div class="col-sm-12">

        <form>
            <div class="row mt-4">

            <input type="hidden" name="idCompra" value="<?= $compra['idCompra']; ?> ">

                <!-- Usuário -->
                <div class="col-md-3 mb-3">
                    <div class="form-floating border border-info rounded">
                        <input type="text" class="form-control" id="idUsuario" name="idUsuario" value="<?= htmlspecialchars($compra['nomeUsuario']); ?>" >
                        <label for="usuario">Usuário:</label>
                    </div>
                </div>

                <!-- Fornecedor -->
                <div class="col-md-3 mb-3">
                    <div class="form-floating border border-info rounded">
                        <input type="text" class="form-control" id="idFornecedor" name="idFornecedor" value="<?= htmlspecialchars($compra['razaoSocial']); ?>" >
                        <label for="idFornecedor">Fornecedor:</label>
                    </div>
                </div>

                <!-- Data de Entrada -->
                <div class="col-md-3 mb-3">
                    <div class="form-floating border border-info rounded">
                        <input type="date" class="form-control" id="data" name="data" value="<?= htmlspecialchars($compra['data']); ?>" >
                        <label for="data">Data da compra:</label>
                    </div>
                </div>

                <!-- Valor Total -->
                <div class="col-md-3 mb-3">
                    <div class="form-floating border border-info rounded">
                        <input type="text" class="form-control" id="valorTotal" name="valorTotal" value="<?= htmlspecialchars($compra['valorTotal']); ?>" >
                        <label for="valorTotal">Valor Total:</label>
                    </div>
                </div>

                <!-- Descrição -->
                <div class="col-md-12 mb-4">
                    <div class="form-floating border border-info rounded">
                        <input type="text" class="form-control" id="descricao" name="descricao" value="<?= htmlspecialchars($compra['descricao']); ?>">
                        <label for="descricao">Descrição:</label>
                    </div>
                </div>

                <div class="col-md-12 mb-3">
                <div class="d-flex justify-content-end gap-2">
                    <a href='../controller/CompraController.php?acao=atualizar&id=<?= $idCompra ?>' class='btn btn-primary btn-sm'>Atualizar</a>
                    <a href='../controller/CompraController.php?acao=excluir&id=<?= $idCompra ?>' class='btn btn-danger btn-sm' onclick='return confirm("Tem certeza que deseja excluir?")'>Excluir</a>
                    <a href="../controller/CompraController.php" class="btn btn-secondary btn me-2">Voltar</a>
                </div>
            </div>
            </div>
        </form>
    </div>
</div>
