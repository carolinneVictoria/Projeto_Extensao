<?php include ("../../app/header.php"); ?>
<!-- Navbar e Barra de Busca -->
<div class="container-fluid bg-dark d-flex position-fixed" style="top: 50px; left: 160px; width: calc(100% - 160px); height: 50px; z-index: 1030;">
  <nav class="navbar navbar-expand-sm navbar-dark bg-dark w-100">
    <div class="container-fluid">
      <div class="collapse navbar-collapse d-flex justify-content-between" id="mynavbar">
          <ul class="navbar-nav mb-4 mb-lg-0">
            <li class="nav-item"><a class="nav-link" href="/Projeto_Extensao/view/UsuarioView/formUsuario.php?acao=cadastrar">Cadastrar novo Usuário</a></li>
          </ul>
        <!-- Campo de busca -->
        <form method="GET" action="/Projeto_Extensao/controller/UsuarioController.php?acao=buscar" class="d-flex me-2" role="search">
          <input type="hidden" name="acao" value="buscar">
          <input type="text" name="busca" class="form-control me-2" placeholder="Buscar por Nome"value="<?= $_GET['busca'] ?? '' ?>">
          <button class="btn btn-outline-light" type="submit">Buscar</button>
        </form>
      </div>
    </div>
  </nav>
</div>

<!-- Conteúdo principal -->
<div class="container" style="margin-left: -10px; padding-top: 50px;">

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
                <a href='verUsuario.php?id=$idUsuario' class='btn btn-primary btn-sm'>Ver Detalhes</a>
                </td>
            </tr>
        </tbody>
    ";
}
echo "</table>";
?>
<?php include "../../app/footer.php"; ?>

</div>