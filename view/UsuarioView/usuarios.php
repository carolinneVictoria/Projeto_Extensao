<?php include ("../../app/header.php"); 

?>

<!-- Navbar e Barra de Busca -->
<nav class="navbar navbar-expand-sm navbar-dark bg-dark">
  <div class="container w-100">
    <div class="collapse navbar-collapse" id="mynavbar">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" href="/Projeto_Extensao/view/UsuarioView/formUsuario.php?acao=cadastrar">Cadastrar novo Usuário</a>
        </li>
      </ul>
      <form method="GET" action="/Projeto_Extensao/controller/UsuarioController.php" class="d-flex" role="search">
        <input type="hidden" name="acao" value="buscar">
        <input type="text" name="busca" class="form-control me-2" placeholder="Buscar por Nome" value="<?= $_GET['busca'] ?? '' ?>">
        <button class="btn btn-outline-light" type="submit">Buscar</button>
      </form>
    </div>
  </div>
</nav>

<?php

include ('../../config/conexaoBD.php');
require_once ('../../model/Usuario.php');
// Instanciando o Model
$usuarioModel = new Usuario($conn);

// Listando os usuarios
$usuarios = $usuarioModel->listarUsuarios();

echo "<h5>Usuarios cadastrados:</h5>";

// Exibindo a tabela de usuarios
echo "
    <table class='table table-hover table-bordered table-sm'>
        <thead class='thead-light'>
            <tr>
                <th>ID</th>
                <th>NOME</th>
                <th>TELEFONE</th>
                <th>EMAIL</th>
                <th>TIPO</th>
                <th>STATUS</th>
                <th>AÇÕES</th>
            </tr>
        </thead>";

while ($registro = mysqli_fetch_assoc($usuarios)) {
  $idUsuario = $registro['idUsuario'];
    echo "
        <tbody>
            <tr>
                <td>{$registro['idUsuario']}</td>
                <td>{$registro['nomeUsuario']}</td>
                <td>{$registro['telefoneUsuario']}</td>
                <td>{$registro['emailUsuario']}</td>
                <td>{$registro['tipoUsuario']}</td>
                <td>{$registro['statusUsuario']}</td>
                <td>
                <a href='formAtualizarUsuario.php?id=$idUsuario' class='btn btn-primary btn-sm'>Atualizar</a>
                <a href='../../controller/UsuarioController.php?acao=excluir&id=$idUsuario' class='btn btn-danger btn-sm' onclick='return confirm(\"Tem certeza que deseja excluir?\")'>Excluir</a>
                </td>
            </tr>
        </tbody>
    ";
}
echo "</table>";

if (isset($_GET['id'])) {
    $idUsuario = $_GET['id'];
    
    $usuario = $usuarioModel->excluirUsuario($idUsuario);
} 

?>

<?php include "../../app/footer.php"; ?>
