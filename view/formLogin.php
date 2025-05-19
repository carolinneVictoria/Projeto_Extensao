<?php include("../app/header.php"); ?>

<div class="container-fluid text-center" style="margin-left: 0;">

    <?php
        // Exibe a mensagem de erro caso o login falhe
        if (isset($_GET["erroLogin"]) && $_GET["erroLogin"] == "dadosInvalidos") {
            echo "<div class='alert alert-warning text-center'>
                    <strong>Usuário</strong> ou <strong>SENHA</strong> inválidos!
                </div>";
        }
    ?>

    <h2>Acessar o Sistema:</h2>

    <div class="d-flex justify-content-center mb-3">
        <div class="row">
            <div class="col-12">
                <!-- Formulário de login -->
                <form action="../controller/LoginController.php" method="POST" class="was-validated">
                    <div class="form-floating mb-3 mt-3">
                        <input type="email" class="form-control" id="emailUsuario" placeholder="Informe o seu email" name="emailUsuario" required>
                        <label for="emailUsuario">Email:</label>
                    </div>

                    <div class="form-floating mb-3 mt-3">
                        <input type="password" class="form-control" id="senhaUsuario" placeholder="Informe a senha" name="senhaUsuario" required>
                        <label for="senhaUsuario">Senha:</label>
                    </div>

                    <button type="submit" class="btn btn-primary">Login</button>
                </form>
            </div>
        </div>
    </div>
    
    <br>
    <p>
        Ainda não possui cadastro?
        <a href="/Projeto_Extensao/view/formUsuario.php" title="Cadastrar-se">Clique aqui!</a>
    </p>
</div>

<?php include("../app/footer.php"); ?>