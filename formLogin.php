<?php include("header.php") ?>

    <div class="container-fluid text-center" style="margin-left">

        <?php
            if(isset($_GET["erroLogin"])){
                $erroLogin = $_GET["erroLogin"];

                if($erroLogin == "dadosInvalidos"){
                    echo "<div class='alert alert-warning text-center'>
                        <strong>Usuário</strong> ou <strong>SENHA</strong> inválidos!
                    </div>";
                }
                
            }
        ?>

        <h2>Acessar o Sistema:</h2>

        <div class="d-flex justify-content-center mb-3">
            <div class="row">
                <div class="col-12">
                    <form action="login.php" class="was-validated" method="POST">
                        <div class="form-floating mb-3 mt-3">
                            <input type="email" class="form-control" id="emailUsuario" placeholder="Informe o seu email" name="emailUsuario" required>
                            <label for="emailUsuario" class="form-label">Email:</label>
                            <div class="valid-feedback"></div>
                            <div class="invalid-feedback"></div>
                        </div>

                        <div class="form-floating mb-3 mt-3">
                            <input type="password" class="form-control" id="senhaUsuario" placeholder="Informe a senha" name="senhaUsuario" required>
                            <label for="senhaUsuario" class="form-label">Senha:</label>
                            <div class="valid-feedback"></div>
                            <div class="invalid-feedback"></div>
                        </div>

                        <button type="submit" class="btn btn-primary">Login</button>
                    </form>
                </div>
            </div>
        </div>
        <br>
        <p>
            Ainda não possui cadastro?
            <a href="formUsuario.php" title="Cadastrar-se">
                Clique aqui!
            </a>
        </p>
    </div>