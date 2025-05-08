<?php include("../app/header.php"); ?>

<div class="container-fluid text-center">
    <h2>Cadastro de Usuário:</h2>

    <div class="d-flex justify-content-center mb-3">
        <form action="../controller/UsuarioController.php" method="POST" enctype="multipart/form-data" class="was-validated">
            <div class="form-floating mb-3 mt-3">
                <input type="file" class="form-control" id="fotoUsuario" name="fotoUsuario" required>
                <label for="fotoUsuario">Foto:</label>
            </div>

            <div class="form-floating mb-3 mt-3">
                <input type="text" class="form-control" id="nomeUsuario" placeholder="Informe o seu nome" name="nomeUsuario" required>
                <label for="nomeUsuario">Nome:</label>
            </div>

            <div class="form-floating mb-3 mt-3">
                <input type="text" class="form-control" id="telefoneUsuario" placeholder="Informe o seu telefone" name="telefoneUsuario" required>
                <label for="telefoneUsuario">Telefone:</label>
            </div>

            <div class="form-floating mb-3 mt-3">
                <input type="email" class="form-control" id="emailUsuario" placeholder="Informe o seu email" name="emailUsuario" required>
                <label for="emailUsuario">Email:</label>
            </div>

            <div class="form-floating mb-3 mt-3">
                <input type="password" class="form-control" id="senhaUsuario" placeholder="Informe uma senha" name="senhaUsuario" required>
                <label for="senhaUsuario">Senha:</label>
            </div>

            <div class="form-floating mb-3 mt-3">
                <input type="password" class="form-control" id="confirmarSenhaUsuario" placeholder="Confirme a senha" name="confirmarSenhaUsuario" required>
                <label for="confirmarSenhaUsuario">Confirme a Senha:</label>
            </div>

            <button type="submit" class="btn btn-primary">Cadastrar</button>
        </form>
    </div>
</div>

<?php include("../app/footer.php"); ?>