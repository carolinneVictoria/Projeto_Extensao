<?php
session_start();

include_once 'C:/xampp/htdocs/Projeto_Extensao/controller/HeaderController.php';
$headerController = new HeaderController();
$dadosUsuario = $headerController->carregarHeader();

$idUsuario    = $_SESSION["idUsuario"] ?? null;
$tipoUsuario  = $_SESSION["tipoUsuario"] ?? null;
$fotoUsuario  = $_SESSION["fotoUsuario"] ?? null;
$nomeUsuario  = $_SESSION["nomeUsuario"] ?? null;
$emailUsuario = $_SESSION["emailUsuario"] ?? null;

$primeiroNome = $nomeUsuario ? explode(' ', $nomeUsuario)[0] : '';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php
        if(isset($_GET['pagina'])){
            $pagina = $_GET['pagina'];
            switch($pagina){
                case "index"        : echo "Página Inicial"; break;
                case "formUsuario"  : echo "Cadastrar Usuário"; break;
                case "formProduto"  : echo "Cadastrar Produto"; break;
                case "formLogin"    : echo "Login"; break;
                default             : echo "Gestão Samuka Bikes"; break;
            }
        } else {
            $pagina = "index";
            echo "Gestão Samuka Bikes";
        }
        ?>
    </title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script>
        $(document).ready(function(){
            $("#telefoneUsuario").mask("(00) 00000-0000");
        });
    </script>
</head>
<body>


<!-- Top Header -->
<div class="container-fluid bg-dark d-flex align-items-center position-fixed" style="top: 0; left: 170px; height: 50px; z-index: 1030;">
    <h4 style="color: white; margin-left: 0px;">Gestão Samuka Bikes</h4>
</div>

<!-- Sidebar Navbar Lateral -->
<nav class="navbar bg-dark navbar-dark flex-column vh-100 position-fixed p-2" style="width: 170px;">
    <div class="container-fluid">

        <?php if(isset($_SESSION['logado']) && $_SESSION['logado'] === true): ?>
            <div class="text-left mb-3">
                <img src="/Projeto_Extensao/img/logo.jpg" class="img-fluid rounded-circle" style="height: 120px; margin-top: 10px;" title="logo da loja">
                <p class="text-white mt-2"><?= $nomeUsuario ?></p>
            </div>

            <ul class="navbar-nav w-100">
                <li class="nav-item"><a class="nav-link" href="/Projeto_Extensao/index.php">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="/Projeto_Extensao/view/ProdutoView/produtos.php">Produtos</a></li>
                    <li class="nav-item"><a class="nav-link" href="/Projeto_Extensao/view/ServicoView/servicos.php">Serviços</a></li>
                    <li class="nav-item"><a class="nav-link" href="/Projeto_Extensao/view/ClienteView/clientes.php">Clientes</a></li>
                    <li class="nav-item"><a class="nav-link" href="/Projeto_Extensao/view/FornecedorView/fornecedores.php">Fornecedores</a></li>
                    <li class="nav-item"><a class="nav-link" href="../estoque.php">Estoque</a></li>
                    <li class="nav-item"><a class="nav-link" href="../vendas.php">Vendas</a></li>
                    <li class="nav-item"><a class="nav-link" href="/Projeto_Extensao/view/UsuarioView/usuarios.php">Usuarios</a></li>
                    <li class="nav-item"><a class="nav-link" href="/Projeto_Extensao/controller/logout.php">Logout</a></li>
            </ul>
        <?php else: ?>
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link <?= ($pagina == 'formLogin') ? 'active' : '' ?>" href="/Projeto_Extensao/view/UsuarioView/formLogin.php?pagina=formLogin">Login</a></li>
            </ul>
        <?php endif; ?>
    </div>
</nav>

<!-- Conteúdo Principal -->
<!-- Container PRINCIPAL do Sistema-->
<div class="container" style="margin-left: 170px; padding-top: 50px;">
        <div class="row">
            <div class="col-12"></div>