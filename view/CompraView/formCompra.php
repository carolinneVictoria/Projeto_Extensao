<?php include("../app/header.php"); ?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white text-center">
                    <h4 class="mb-0">Cadastro de Compra</h4>
                </div>
                <div class="card-body">
                    <form id="formServico" action="/Projeto_Extensao/controller/CompraController.php?acao=cadastrar" method="POST" enctype="multipart/form-data" class="was-validated">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select class="form-select" id="usuario" name="idUsuario" required>
                                        <option value="" selected disabled>-- Selecione um Usuário --</option>
                                        <?php foreach ($usuarios as $usuario): ?>
                                            <option value="<?= htmlspecialchars($usuario['idUsuario']); ?>"><?= htmlspecialchars($usuario['nomeUsuario']); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <label for="usuario">Usuário:</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select class="form-select" id="idFornecedor" name="idFornecedor" required>
                                        <option value="" selected disabled>-- Selecione um Fornecedor --</option>
                                        <?php foreach ($fornecedores as $fornecedor): ?>
                                            <option value="<?= htmlspecialchars($fornecedor['idFornecedor']); ?>"><?= htmlspecialchars($fornecedor['razaoSocial']); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <label for="idFornecedor">Fornecedor:</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="date" class="form-control" id="data" name="data" required>
                                    <label for="data">Data da compra:</label>
                                </div>
                            </div>

                            <input type="hidden" name="valorTotal" id="valorTotal">
                            
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <textarea class="form-control" id="descricao" name="descricao" placeholder="Descrição" style="height: 100px"></textarea>
                                    <label for="descricao">Descrição:</label>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-between">
                            <a href="javascript:history.back()" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Voltar
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Cadastrar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include("../app/footer.php"); ?>