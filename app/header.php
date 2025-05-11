<?php
include_once 'C:/xampp/htdocs/Projeto_Extensao/controller/HeaderController.php';
$headerController = new HeaderController();
$dadosUsuario = $headerController->carregarHeader();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Samuka Bikes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container-fluid bg-dark d-flex align-items-center position-fixed" style="top: 0; left: 0; height: 50px; z-index: 1030;">
        <h4 style="color: white; margin-left: 170px;">Gestão Samuka Bikes</h4>
    </div>

    <!-- Barra de Navegação do Sistema -->
    <nav class="navbar bg-dark navbar-dark flex-column vh-100 position-fixed p-2" style="width: 170px; margin-top: 50px;">
        <div class="container-fluid">
            <ul class="navbar-nav">
                <?php
                if ($dadosUsuario) {
                    $nomeUsuario = $dadosUsuario['nomeUsuario'];
                    $fotoUsuario = $dadosUsuario['fotoUsuario'];
                    $tipoUsuario = $dadosUsuario['tipoUsuario'];
                    $primeiroNome = explode(' ', $nomeUsuario)[0];

                    echo "
                    <li>
                        <div class='container'>
                            <img src='$fotoUsuario' class='img-fluid max-height rounded' title='Esta é a sua foto de perfil, $primeiroNome!' />
                        </div>
                    </li>
                    <li class='nav-item dropdown'>
                        <a class='nav-link dropdown-toggle' href='#' role='button' data-bs-toggle='dropdown' style='color: ".($tipoUsuario == 'admin' ? 'white' : 'yellow').";'><strong>$nomeUsuario</strong></a>
                        <ul class='dropdown-menu'>
                            <li><a class='dropdown-item' href='visualizarPerfil.php?pagina=formLogin&idUsuario={$dadosUsuario['idUsuario']}'>Meu Perfil</a></li>
                            <li><a class='dropdown-item' href='logout.php'>Logout</a></li>
                        </ul>
                    </li>";
                } else {
                    echo "<li class='nav-item'>
                            <a class='nav-link' href='formLogin.php'>Login</a>
                          </li>";
                }
                ?>
            </ul>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="collapsibleNavbar">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="../index.php">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="../Projeto_Extensao/view/produtos.php">Produtos</a></li>
                    <li class="nav-item"><a class="nav-link" href="../estoque.php">Estoque</a></li>
                    <li class="nav-item"><a class="nav-link" href="../vendas.php">Vendas</a></li>
                    <li class="nav-item"><a class="nav-link" href="../Projeto_Extensao/view/usuarios.php">Usuarios</a></li>
                </ul>
            </div>
        </div>
    </nav>
 <!-- Container PRINCIPAL do Sistema-->
 <div class="container" style="margin-left: 170px; padding-top: 50px;">
        <div class="row">
            <div class="col-12"></div>