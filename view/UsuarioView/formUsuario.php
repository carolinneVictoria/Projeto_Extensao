<?php include("../../app/header.php"); 
session_start();

if (isset($_SESSION['erroSenhaConfirmar'])) {
    echo "<p style='color:red'>" . $_SESSION['erroSenhaConfirmar'] . "</p>";
    unset($_SESSION['erroSenhaConfirmar']);
}

if (isset($_SESSION['erroUpload'])) {
    echo "<p style='color:red'>" . $_SESSION['erroUpload'] . "</p>";
    unset($_SESSION['erroUpload']);
}

if (isset($_SESSION['erroCadastro'])) {
    echo "<p style='color:red'>" . $_SESSION['erroCadastro'] . "</p>";
    unset($_SESSION['erroCadastro']);
}
?>

<div class="container-fluid">
    <h4>Cadastro de Usuário:</h4>

    <div class="col-sm-12">

        <form action="/Projeto_Extensao/controller/UsuarioController.php?acao=cadastrar" method="POST" enctype="multipart/form-data" class="was-validated">
            <div class="row">

            <div class="col-md-6 mb-3">
                <div class="form-floating">
                    <input type="file" class="form-control" id="fotoUsuario" name="fotoUsuario">
                    <label for="fotoUsuario">Foto:</label>
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <div class="form-floating">
                    <input type="text" class="form-control" id="nomeUsuario" placeholder="Informe o seu nome" name="nomeUsuario" required>
                    <label for="nomeUsuario">Nome:</label>
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <div class="form-floating">
                    <input type="text" class="form-control" id="telefoneUsuario" placeholder="Informe o seu telefone" name="telefoneUsuario" required>
                    <label for="telefoneUsuario">Telefone:</label>
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <div class="form-floating">
                    <input type="email" class="form-control" id="emailUsuario" placeholder="Informe o seu email" name="emailUsuario" required>
                    <label for="emailUsuario">Email:</label>
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <div class="form-floating">
                    <input type="password" class="form-control" id="senhaUsuario" placeholder="Informe uma senha" name="senhaUsuario" required>
                    <label for="senhaUsuario">Senha:</label>
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <div class="form-floating">
                    <input type="password" class="form-control" id="confirmarSenhaUsuario" placeholder="Confirme a senha" name="confirmarSenhaUsuario" required>
                    <label for="confirmarSenhaUsuario">Confirme a Senha:</label>
                </div>
            </div>

            <div class="col-md-12 text-end">
                <button type="submit" class="btn btn-primary">Cadastrar</button>
            </div>

            </div>
        </form>
    </div>
</div>

<?php include("../../app/footer.php"); ?>