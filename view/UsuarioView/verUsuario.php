<?php include(__DIR__ ."/../../app/header.php"); 

include ('./../config/conexaoBD.php');
include ('../../model/Usuario.php');

$usuarioModel = new Usuario($conn);

if (isset($_GET['id'])) {
    $idUsuario = $_GET['id'];
    
    $usuario = $usuarioModel->buscarUsuarioPorId($idUsuario);
} else {
    echo "ID do usuário não informado!";
    exit(); 
}

?>

<div class="container-fluid">
    <h3>Detalhes do Usuário:</h3>

    <div class="col-sm-12">

        <form action="/Projeto_Extensao/controller/UsuarioController.php?acao=atualizar" method="POST" enctype="multipart/form-data" class="was-validated">

            <input type="hidden" name="idUsuario" value="<?= $usuario['idUsuario']; ?>">

            <div class="row">

            <div class="col-md-6 mb-3">
                <div class="form-floating border border-info rounded">
                    <input type="file" class="form-control" id="fotoUsuario" name="fotoUsuario" value="<?= htmlspecialchars($usuario['fotoUsuario']); ?>" readonly>
                    <label for="fotoUsuario">Foto:</label>
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <div class="form-floating border border-info rounded">
                    <input type="text" class="form-control" id="nomeUsuario" placeholder="Informe o seu nome" name="nomeUsuario" value="<?= htmlspecialchars($usuario['nomeUsuario']); ?>" readonly>
                    <label for="nomeUsuario">Nome:</label>
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <div class="form-floating border border-info rounded">
                    <input type="text" class="form-control" id="telefoneUsuario" placeholder="Informe o seu telefone" name="telefoneUsuario" value="<?= htmlspecialchars($usuario['telefoneUsuario']); ?>" readonly>
                    <label for="telefoneUsuario">Telefone:</label>
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <div class="form-floating border border-info rounded">
                    <input type="email" class="form-control" id="emailUsuario" placeholder="Informe o seu email" name="emailUsuario" value="<?= htmlspecialchars($usuario['emailUsuario']); ?>" readonly>
                    <label for="emailUsuario">Email:</label>
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <div class="form-floating border border-info rounded">
                    <input type="password" class="form-control" id="senhaUsuario" placeholder="Informe uma senha" name="senhaUsuario" value="<?= htmlspecialchars($usuario['senhaUsuario']); ?>" readonly>
                    <label for="senhaUsuario">Senha:</label>
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <div class="form-floating border border-info rounded">
                    <input type="password" class="form-control" id="confirmarSenhaUsuario" placeholder="Confirme a senha" name="confirmarSenhaUsuario" value="<?= htmlspecialchars($usuario['senhaUsuario']); ?>" readonly>
                    <label for="confirmarSenhaUsuario">Confirme a Senha:</label>
                </div>
            </div>

            <div class="col-md-12 mb-3">
                <div class="d-flex justify-content-end gap-2">
                    <a href='formAtualizarUsuario.php?id=<?= $idUsuario ?>' class='btn btn-primary btn-sm'>Atualizar</a>
                    <a href='../../controller/UsuarioController.php?acao=excluir&id=<?= $idUsuario ?>' class='btn btn-danger btn-sm' onclick='return confirm("Tem certeza que deseja excluir?")'>Excluir</a>
                    <a href="usuarios.php" class="btn btn-secondary btn-sm">Voltar</a>
                </div>
            </div>

            </div>
        </form>
    </div>
</div>

<?php include(__DIR__ ."/../../app/footer.php"); ?>