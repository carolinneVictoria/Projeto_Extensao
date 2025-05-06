<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Samuka Bikes</title>

    <!-- Úlitima versão compilada e minimizada CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Última versão compilada JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- CDNs para Máscaras JQuery-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js" integrity="sha512-pHVGpX7F/27yZ0ISY+VVjyULApbDlD0/X0rgGbTqCE7WFW5MezNTWG/dnhtbBuICzsd0WQPgpE4REBLv+UqChw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- Script para Máscaras do Formulário -->
    <script>
        $(document).ready(function(){
            $("#telefoneUsuario").mask("(00) 00000-0000");
        });
    </script>

    <?php
    date_default_timezone_set('America/Sao_Paulo');
    ?>

</head>
<body>

    <!-- Container do Sistema -->
    <div class="container-fluid bg-dark d-flex align-items-center position-fixed" style="top: 0; left: 0; height: 50px; z-index: 1030;">
        <h4 style="color: white; margin-left: 170px;">Gestão Samuka Bikes</h4>
    </div>


    <?php
        error_reporting(0); //Desabilita reportagem de erros de execução
        
        session_start(); //Inicia Sessão
        if (isset($_SESSION['mensagem'])) {
            echo $_SESSION['mensagem'];
            unset($_SESSION['mensagem']);
        }
        

        //Cria variáveis para receber os valores das variáveis de sessão
        $idUsuario    = $_SESSION["idUsuario"];
        $tipoUsuario  = $_SESSION["tipoUsuario"];
        $fotoUsuario  = $_SESSION["fotoUsuario"];
        $nomeUsuario  = $_SESSION["nomeUsuario"];
        $emailUsuario = $_SESSION["emailUsuario"];

        //Utiliza a função 'explode' para segmentar o nome completo e armazenar em um array
        $nomeCompleto = explode(' ', $nomeUsuario);
        $primeiroNome = $nomeCompleto[0];
    ?>

    <!-- Barra de Navegação do Sistema -->
    <nav class="navbar bg-dark navbar-dark flex-column vh-100 position-fixed p-2" style="width: 170px; margin-top: 50px;">

        <div class="container-fluid">
            <?php
                echo "<ul class='navbar-nav'>";

                    //Verifica se há sessão iniciada
                    if(isset($_SESSION['logado']) && $_SESSION['logado'] === true){
                        //Se houver sessão iniciada, exibe a foto do perfil, o email do usuário (amarelo, caso consumidor / vermelho, caso administrador) e troca a opção LOGIN por LOGOUT
                        echo "
                            <li>
                                <div class='container'>
                                    <img src='$fotoUsuario' 
                                    class='img-fluid max-height rounded' 
                                    title='Esta é a sua foto de perfil, $primeiroNome!'>
                                </div>
                            </li>

                            <li class='nav-item dropdown'>
                                <a class='nav-link dropdown-toggle' style='margin-top: 10px;
                                href='#' role='button' data-bs-toggle='dropdown' 
                                style='color: "; if($tipoUsuario == "admin"){ echo "white'";} else{ echo "yellow'";} echo "><strong>$nomeUsuario</strong></a>
                                    <ul class='dropdown-menu'>
                                        <li><a class='dropdown-item' href='visualizarPerfil.php?pagina=formLogin&idUsuario=$idUsuario' title='Visualizar Perfil'>Meu Perfil</a></li>";
                                        if ($tipoUsuario == 'admin'){ echo"
                                            <li><a class='dropdown-item' href='visualizarPedidos.php'>Visualizar Pedidos</a></li>";
                                        }else{
                                            echo"
                                            <li><a class='dropdown-item' href='visualizarPedidos.php?pagina=formProduto&idUsuario=$idUsuario'>Meus Pedidos</a></li>";
                                        }
                                        echo
                                        "<li><a class='dropdown-item' href='logout.php?pagina=formLogin' title='Sair do Sistema'>Logout</a></li>
                                    </ul>
                            </li>

                        ";
                    }
                    else {
                        //Se não houver sessão iniciada, exibe a opção de acessar o sistema
                        echo "
                            <li class='nav-item'>
                                <a class='nav-link "; if($pagina == 'formLogin'){ echo 'active';} echo "'href='formLogin.php?pagina=formLogin' title='Acessar o Sistema'>Login</a>
                            </li>
                        ";
                    }
                echo "</ul>";
            ?>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="collapsibleNavbar">
                <ul class="navbar-nav">
                    
                    <li class="nav-item">
                        <a class="nav-link <?php if($pagina == 'index'){echo 'active';} ?>" href="index.php?pagina=index" title="Ir para a Página Inicial">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php if($pagina == 'produtos'){echo 'disable';} ?>" href="produtos.php?pagina=produtos" title="Ir para Produtos">Produtos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php if($pagina == 'estoque'){echo 'disable';} ?>" href="estoque.php?pagina=estoque" title="Ir para Estoque">Estoque</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php if($pagina == 'ordemServico'){echo 'disable';} ?>" href="ordemServico.php?pagina=ordemServico" title="Ir para Ordens de Serviço">Ordens de Serviço</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php if($pagina == 'vendas'){echo 'disable';} ?>" href="vendas.php?pagina=vendas" title="Ir para Vendas">Vendas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php if($pagina == 'clientes'){echo 'disable';} ?>" href="clientes.php?pagina=clientes" title="Ir para Clientes">Clientes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php if($pagina == 'relatorios'){echo 'disable';} ?>" href="relatorios.php?pagina=relatorios" title="Ir para Relatórios">Relatórios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php if($pagina == 'configuracao'){echo 'disable';} ?>" href="configuracao.php?pagina=configuracao" title="Ir para Configurações">Configurações</a>
                    </li>
                </ul>
            </div>

            
        </div>
    </nav>

    <!-- Container PRINCIPAL do Sistema-->
    <div class="container" style="margin-left: 170px; padding-top:52px;">
        <div class="row">
            <div class="col-12"></div>