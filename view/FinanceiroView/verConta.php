<?php include("../app/header.php"); ?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white text-center">
                    <h4 class="mb-0">Detalhes da Conta</h4>
                </div>
                <div class="card-body">
                    <form>
                        <input type="hidden" name="idConta" value="<?= htmlspecialchars($conta['idConta']); ?>">
                        
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="descricao" name="descricao" value="<?= htmlspecialchars($conta['descricao']); ?>" disabled placeholder="Descrição">
                                    <label for="descricao">Descrição:</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="valorTotal" name="valorTotal" value="R$ <?= number_format($conta['valorTotal'], 2, ',', '.'); ?>" disabled placeholder="Valor">
                                    <label for="valorTotal">Valor:</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="date" class="form-control" id="dataVencimento" name="dataVencimento" value="<?= htmlspecialchars($conta['dataVencimento']); ?>" disabled placeholder="Data de Vencimento">
                                    <label for="dataVencimento">Data de Vencimento:</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select class="form-select" id="status" name="status" disabled>
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
                            <div>
                                <a href='../controller/FinanceiroController.php?acao=formAtualizar&id=<?= htmlspecialchars($idConta); ?>' class='btn btn-warning me-2 text-white' title="Atualizar">
                                    <i class="fas fa-edit"></i> Editar
                                </a>
                                <a href='../controller/FinanceiroController.php?acao=excluir&id=<?= htmlspecialchars($idConta); ?>' class='btn btn-danger' onclick='return confirm("Tem certeza que deseja excluir?")' title="Excluir">
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