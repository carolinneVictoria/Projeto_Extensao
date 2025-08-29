<?php include("../app/header.php"); session_start(); ?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white text-center">
                    <h4 class="mb-0">Cadastro de Usuário</h4>
                </div>
                <div class="card-body">
                    <form action="/Projeto_Extensao/controller/UsuarioController.php?acao=cadastrar" method="POST" enctype="multipart/form-data" class="was-validated">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="nomeUsuario" placeholder="Informe o seu nome" name="nomeUsuario" required>
                                    <label for="nomeUsuario">Nome:</label>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="telefoneUsuario" placeholder="Informe o seu telefone" name="telefoneUsuario" required>
                                    <label for="telefoneUsuario">Telefone:</label>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="email" class="form-control" id="emailUsuario" placeholder="Informe o seu email" name="emailUsuario" required>
                                    <label for="emailUsuario">Email:</label>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="file" class="form-control" id="fotoUsuario" name="fotoUsuario">
                                    <label for="fotoUsuario">Foto:</label>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="password" class="form-control" id="senhaUsuario" placeholder="Informe uma senha" name="senhaUsuario" required>
                                    <label for="senhaUsuario">Senha:</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="password" class="form-control" id="confirmarSenhaUsuario" placeholder="Confirme a senha" name="confirmarSenhaUsuario" required>
                                    <label for="confirmarSenhaUsuario">Confirme a Senha:</label>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-between">
                            <a href="javascript:history.back()" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Voltar
                            </a>
                            <button type="submit" class="btn btn-success">
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