<?php include("../app/header.php"); ?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white text-center">
                    <h4 class="mb-0">Detalhes da Compra</h4>
                </div>
                <div class="card-body">
                    <form>
                        <input type="hidden" name="idCompra" value="<?= htmlspecialchars($compra['idCompra']); ?>">

                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="idUsuario" name="idUsuario" value="<?= htmlspecialchars($compra['nomeUsuario']); ?>" readonly placeholder="Usuário">
                                    <label for="idUsuario">Usuário:</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="idFornecedor" name="idFornecedor" value="<?= htmlspecialchars($compra['razaoSocial']); ?>" readonly placeholder="Fornecedor">
                                    <label for="idFornecedor">Fornecedor:</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="date" class="form-control" id="data" name="data" value="<?= htmlspecialchars($compra['data']); ?>" readonly placeholder="Data da Compra">
                                    <label for="data">Data da compra:</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="valorTotal" name="valorTotal" value="R$ <?= number_format($compra['valorTotal'], 2, ',', '.'); ?>" readonly placeholder="Valor Total">
                                    <label for="valorTotal">Valor Total:</label>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-floating">
                                    <textarea style="height: 100px" class="form-control" id="descricao" name="descricao" readonly placeholder="Descrição"><?= htmlspecialchars($compra['descricao']); ?></textarea>
                                    <label for="descricao">Descrição:</label>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-between">
                            <button onclick="history.back()" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Voltar
                            </button>
                            <div>
                                <a href='../controller/CompraController.php?acao=formAtualizar&id=<?= htmlspecialchars($idCompra); ?>' class='btn btn-warning me-2 text-white' title="Atualizar">
                                    <i class="fas fa-edit"></i> Editar
                                </a>
                                <a href='../controller/CompraController.php?acao=excluir&id=<?= htmlspecialchars($idCompra); ?>' class='btn btn-danger' onclick='return confirm("Tem certeza que deseja excluir?")' title="Excluir">
                                    <i class="fas fa-trash"></i> Excluir
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include("../app/footer.php"); ?>