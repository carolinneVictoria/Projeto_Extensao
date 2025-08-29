<?php include("../app/header.php"); ?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white text-center">
                    <h4 class="mb-0">Detalhes do Fornecedor</h4>
                </div>
                <div class="card-body">
                    <form>
                        <input type="hidden" name="idFornecedor" value="<?= htmlspecialchars($fornecedor['idFornecedor']); ?>">
                        
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="cnpj" name="cnpj" value="<?= htmlspecialchars($fornecedor['cnpj']); ?>" disabled placeholder="CNPJ">
                                    <label for="cnpj">CNPJ:</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="razaoSocial" name="razaoSocial" value="<?= htmlspecialchars($fornecedor['razaoSocial']); ?>" disabled placeholder="Razão Social">
                                    <label for="razaoSocial">Razão Social:</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="endereco" name="endereco" value="<?= htmlspecialchars($fornecedor['endereco']); ?>" disabled placeholder="Endereço">
                                    <label for="endereco">Endereço:</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="telefone" name="telefone" value="<?= htmlspecialchars($fornecedor['telefone']); ?>" disabled placeholder="Telefone">
                                    <label for="telefone">Telefone:</label>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-between">
                            <button onclick="history.back()" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Voltar
                            </button>
                            <div>
                                <a href='../controller/FornecedorController.php?acao=formAtualizar&id=<?= htmlspecialchars($idFornecedor); ?>' class='btn btn-warning me-2 text-white'>
                                    <i class="fas fa-edit"></i> Editar
                                </a>
                                <a href='../controller/FornecedorController.php?acao=excluir&id=<?= htmlspecialchars($idFornecedor); ?>' class='btn btn-danger' onclick='return confirm("Tem certeza que deseja excluir?")'>
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