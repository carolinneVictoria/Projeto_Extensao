<?php include("../../app/header.php"); ?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white text-center">
                    <h4 class="mb-0">Acessar o Sistema</h4>
                </div>
                <div class="card-body">
                    <?php if (isset($_GET["erroLogin"]) && $_GET["erroLogin"] == "dadosInvalidos"): ?>
                        <div class='alert alert-warning text-center' role='alert'>
                            <strong>Usuário</strong> ou <strong>SENHA</strong> inválidos!
                        </div>
                    <?php endif; ?>

                    <form action="/Projeto_Extensao/controller/LoginController.php" method="POST" class="needs-validation" novalidate>
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control" id="emailUsuario" placeholder="Informe o seu email" name="emailUsuario" required>
                            <label for="emailUsuario">Email:</label>
                            <div class="invalid-feedback">
                                Por favor, insira um email válido.
                            </div>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" id="senhaUsuario" placeholder="Informe a senha" name="senhaUsuario" required>
                            <label for="senhaUsuario">Senha:</label>
                            <div class="invalid-feedback">
                                Por favor, insira a senha.
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-sign-in-alt"></i> Entrar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include("../../app/footer.php"); ?>