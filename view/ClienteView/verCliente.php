<?php include("../app/header.php"); ?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white text-center">
                    <h4 class="mb-0">Detalhes do Cliente</h4>
                </div>
                <div class="card-body">
                    <form>
                        <input type="hidden" name="idCliente" value="<?= htmlspecialchars($cliente['idCliente']); ?>">

                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="nome" name="nome" value="<?= htmlspecialchars($cliente['nome']); ?>" readonly>
                                    <label for="nome">Nome:</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="telefone" name="telefone" value="<?= htmlspecialchars($cliente['telefone']); ?>" readonly>
                                    <label for="telefone">Telefone:</label>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="cpf" name="cpf" value="<?= htmlspecialchars($cliente['cpf']); ?>" readonly>
                                    <label for="cpf">CPF:</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="date" class="form-control" id="dataNascimento" name="dataNascimento" value="<?= htmlspecialchars($cliente['dataNascimento']); ?>" readonly>
                                    <label for="dataNascimento">Data de Nascimento:</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="endereco" name="endereco" value="<?= htmlspecialchars($cliente['endereco']); ?>" readonly>
                                    <label for="endereco">Endereço</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="bicicleta" name="bicicleta" value="<?= htmlspecialchars($cliente['bicicleta']); ?>" readonly>
                                    <label for="bicicleta">Bicicleta</label>
                                </div>
                            </div>
                        </div>
                        
                        <hr class="my-4">

                        <div class="d-flex justify-content-between">
                            <a href="javascript:history.back()" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Voltar
                            </a>
                            <div>
                                <a href='../controller/ClienteController.php?acao=formAtualizar&id=<?= htmlspecialchars($cliente['idCliente']); ?>' class='btn btn-warning'>
                                    <i class="fas fa-edit"></i> Editar
                                </a>
                                <a href='../controller/ClienteController.php?acao=excluir&id=<?= htmlspecialchars($cliente['idCliente']); ?>' class='btn btn-danger' onclick="return confirm('Tem certeza que deseja excluir? Esse cliente pode ter um serviço, e ele será excluido junto!')">
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