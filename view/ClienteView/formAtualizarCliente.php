<?php include(__DIR__."/../../app/header.php"); ?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white text-center">
                    <h4 class="mb-0">Atualizar Cliente</h4>
                </div>
                <div class="card-body">
                    <form action="../controller/ClienteController.php?acao=atualizar" method="POST" enctype="multipart/form-data" class="was-validated">
                        <input type="hidden" name="idCliente" value="<?= htmlspecialchars($cliente['idCliente']); ?>">

                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="nome" name="nome" value="<?= htmlspecialchars($cliente['nome']); ?>" placeholder="Nome completo" required>
                                    <label for="nome">Nome:</label>
                                    <div class="invalid-feedback">Por favor, preencha o nome.</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="telefone" name="telefone" value="<?= htmlspecialchars($cliente['telefone']); ?>" placeholder="(xx) xxxxx-xxxx" required>
                                    <label for="telefone">Telefone:</label>
                                    <div class="invalid-feedback">Por favor, preencha o telefone.</div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="cpf" name="cpf" value="<?= htmlspecialchars($cliente['cpf']); ?>" placeholder="xxx.xxx.xxx-xx">
                                    <label for="cpf">CPF:</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="date" class="form-control" id="dataNascimento" name="dataNascimento" value="<?= htmlspecialchars($cliente['dataNascimento']); ?>">
                                    <label for="dataNascimento">Data de Nascimento:</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="endereco" name="endereco" value="<?= htmlspecialchars($cliente['endereco']); ?>" placeholder="Endereço">
                                    <label for="endereco">Endereço</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="bicicleta" name="bicicleta" value="<?= htmlspecialchars($cliente['bicicleta']); ?>" placeholder="Marca e modelo da bicicleta">
                                    <label for="bicicleta">Bicicleta</label>
                                </div>
                            </div>
                        </div>
                        
                        <hr class="my-4">
                        
                        <div class="d-flex justify-content-between">
                            <a href="javascript:history.back()" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Voltar
                            </a>
                            <button type="submit" class="btn btn-primary text-white">
                                <i class="fas fa-edit"></i> Atualizar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include("../../app/footer.php"); ?>