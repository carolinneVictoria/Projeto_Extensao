<?php
error_reporting(0);
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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <script>
        $(document).ready(function(){
            $("#telefoneUsuario").mask("(00) 00000-0000");
        });
    </script>
    <style>
        .table td, .table th {
        max-width: 150px;   /* largura máxima da célula */
        white-space: nowrap; /* evita quebrar linha */
        overflow: hidden;    /* esconde o que passar */
        text-overflow: ellipsis; /* coloca "..." */
        }
        body {
            min-height: 100vh;
            display: flex;
            background-color: #f8f9fa;
        }
        .sidebar {
            min-width: 210px;
            background-color: #212529;
            color: white;
            padding: 20px;
            
        }
        .sidebar h2 {
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }
        .sidebar a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 5px;
        }
        .sidebar a:hover {
            background-color: #343a40;
        }
        .content {
            flex: 1;
            padding: 20px;
        }
        .card {
            border-radius: 10px;
        }
        .perfil-container {
            text-align: center;
            margin-bottom: 20px;
        }
        .perfil-img {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #6c757d;
        }
        .perfil-nome {
            margin-top: 10px;
            font-size: 1.1rem;
            font-weight: bold;
        }
    </style>
</head>
<body>

<!-- Sidebar Navbar Lateral -->
    <div class="sidebar">
        <h2>Samuka Bikes</h2>
        <?php if(isset($_SESSION['logado']) && $_SESSION['logado'] === true): ?>
            <div class="perfil-container">
                <img src="/Projeto_Extensao/<?= htmlspecialchars($fotoUsuario); ?>" alt="Foto de Perfil" class="perfil-img">
                <p class="perfil-nome"><?= htmlspecialchars($primeiroNome); ?></p>
            </div>
        <a href="/Projeto_Extensao/index.php">📈 Dashboard</a>
        <a href="/Projeto_Extensao/Controller/ProdutoController.php?acao=listar">📦 Produtos</a>
        <a href="/Projeto_Extensao/Controller/ClienteController.php?acao=listar">👥 Clientes</a>
        <a href="/Projeto_Extensao/Controller/FornecedorController.php?acao=listar">🚚 Fornecedores</a>
        <a href="/Projeto_Extensao/controller/ServicoController.php?acao=listar">🛠 Serviços</a>
        <a href="/Projeto_Extensao/Controller/VendaController.php?acao=listar">💰 Vendas</a>
        <a href="/Projeto_Extensao/Controller/UsuarioController.php?acao=listar">👥 Usuários</a>
        <a href="/Projeto_Extensao/controller/CompraController.php?acao=listar">📦 Estoque</a>
        <a href="/Projeto_Extensao/controller/FinanceiroController.php?acao=listar">📊 Financeiro</a>
        <a href="/Projeto_Extensao/controller/logout.php">Logout</a>
        <?php else: ?>
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link <?= ($pagina == 'formLogin') ? 'active' : '' ?>" href="/Projeto_Extensao/view/UsuarioView/formLogin.php?pagina=formLogin">Login</a></li>
            </ul>
        <?php endif; ?>
    </div>

<!-- Conteúdo Principal -->
<!-- Container PRINCIPAL do Sistema-->
<div class="container">
        <div class="row">
            <div class="col-12">