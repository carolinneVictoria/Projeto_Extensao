<?php
    session_start(); // Inicia a sessão

    include("conexaoBD.php");

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Cria variáveis para receber o email e a senha informados no formLogin
        // Utiliza a função mysqli_real_escape_string para evitar SQL Injection
        $emailUsuario = mysqli_real_escape_string($conn, $_POST['emailUsuario']);
        $senhaUsuario = mysqli_real_escape_string($conn, $_POST['senhaUsuario']);

        // Criar a QUERY responsável por realizar a verificação dos dados no BD
        $buscarLogin = "SELECT * FROM Usuario WHERE emailUsuario = '{$emailUsuario}' AND senhaUsuario = MD5('{$senhaUsuario}')";

        // Cria uma variável booleana para verificar se a query foi executada com sucesso
        $efetuarLogin = mysqli_query($conn, $buscarLogin);

        // Verifica se encontrou algum registro
        if ($registro = mysqli_fetch_assoc($efetuarLogin)) {
            // Cria variáveis PHP para armazenar os registros encontrados no BD
            $idUsuario    = $registro['idUsuario'];
            $tipoUsuario  = $registro['tipoUsuario'];
            $fotoUsuario  = $registro['fotoUsuario'];
            $emailUsuario = $registro['emailUsuario'];
            $nomeUsuario  = $registro['nomeUsuario'];

            // Cria variáveis de Sessão para armazenar os valores
            $_SESSION['idUsuario']    = $idUsuario;
            $_SESSION['tipoUsuario']  = $tipoUsuario;
            $_SESSION['fotoUsuario']  = $fotoUsuario;
            $_SESSION['emailUsuario'] = $emailUsuario;
            $_SESSION['nomeUsuario']  = $nomeUsuario;
            $_SESSION['logado']       = true;
            $_SESSION['ultimoAcesso'] = time();

            header('Location: index.php'); // Redireciona para a Página Inicial
            exit(); // Encerra o script para garantir que o redirecionamento ocorra
        }
        else {
            // Se não encontrou registro ou se campos estão vazios, redireciona com erro
            header('Location: formLogin.php?erroLogin=dadosInvalidos');
            exit(); // Encerra o script para garantir que o redirecionamento ocorra
        }
    }
    else {
        // Se o formulário não foi submetido, redireciona para o formulário de login
        header('Location: formLogin.php');
        exit(); // Encerra o script para garantir que o redirecionamento ocorra
    }
?>