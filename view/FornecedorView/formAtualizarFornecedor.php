<?php include("../app/header.php"); ?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white text-center">
                    <h4 class="mb-0">Atualizar Fornecedor</h4>
                </div>
                <div class="card-body">
                    <form action="/Projeto_Extensao/controller/FornecedorController.php?acao=atualizar" method="POST" enctype="multipart/form-data" class="was-validated">
                        <input type="hidden" name="idFornecedor" value="<?= htmlspecialchars($fornecedor['idFornecedor']); ?>">
                        
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="cnpj" name="cnpj" value="<?= htmlspecialchars($fornecedor['cnpj']); ?>" placeholder="CNPJ" required>
                                    <label for="cnpj">CNPJ:</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="razaoSocial" name="razaoSocial" value="<?= htmlspecialchars($fornecedor['razaoSocial']); ?>" placeholder="Razão Social" required>
                                    <label for="razaoSocial">Razão Social:</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="endereco" name="endereco" value="<?= htmlspecialchars($fornecedor['endereco']); ?>" placeholder="Endereço">
                                    <label for="endereco">Endereço:</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="telefone" name="telefone" value="<?= htmlspecialchars($fornecedor['telefone']); ?>" placeholder="Telefone" required>
                                    <label for="telefone">Telefone:</label>
                                </div>
                            </div>
                        </div>
                        
                        <hr class="my-4">

                        <div class="d-flex justify-content-between">
                            <a href="javascript:history.back()" class="btn btn-secondary">
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

<?php include("../app/footer.php"); ?>