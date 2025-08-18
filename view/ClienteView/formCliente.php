<?php include("../app/header.php"); session_start(); ?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white text-center">
                    <h4 class="mb-0">Cadastro de Cliente</h4>
                </div>
                <div class="card-body">
                    <form action="/Projeto_Extensao/controller/ClienteController.php?acao=cadastrar" method="POST" enctype="multipart/form-data" class="was-validated">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome completo" required>
                                    <label for="nome">Nome:</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="telefone" name="telefone" placeholder="(xx) xxxxx-xxxx" required>
                                    <label for="telefone">Telefone:</label>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="cpf" name="cpf" placeholder="xxx.xxx.xxx-xx">
                                    <label for="cpf">CPF:</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="date" class="form-control" id="dataNascimento" name="dataNascimento">
                                    <label for="dataNascimento">Data de Nascimento:</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="endereco" name="endereco" placeholder="Endereço">
                                    <label for="endereco">Endereço</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="bicicleta" name="bicicleta" placeholder="Marca e modelo da bicicleta">
                                    <label for="bicicleta">Bicicleta</label>
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