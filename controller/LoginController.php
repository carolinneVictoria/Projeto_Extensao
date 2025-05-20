<?php
session_start(); // Inicia a sessão

include_once '../model/Usuario.php';

include_once '../config/conexaoBD.php'; // Arquivo de conexão com o banco

include_once '../controller/validarSessao.php';

// Instanciando o Model de Usuario
$usuarioModel = new Usuario($conn);

// Verifica se o formulário foi submetido
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $emailUsuario = mysqli_real_escape_string($conn, $_POST['emailUsuario']);
        $senhaUsuario = md5(mysqli_real_escape_string($conn, $_POST['senhaUsuario']));

        // Criar a QUERY responsável por realizar a verificação dos dados no BD
        $buscarLogin = "SELECT * FROM Usuario WHERE emailUsuario = '{$emailUsuario}' AND senhaUsuario = ('{$senhaUsuario}')";

        // Cria uma variável booleana para verificar se a query foi executada com sucesso
        $efetuarLogin = mysqli_query($conn, $buscarLogin);

        // Verifica se encontrou algum registro
        if ($registro = mysqli_fetch_assoc($efetuarLogin)) {
            // Cria variáveis PHP para armazenar os registros encontrados no BD
            $idUsuario    = $registro['idUsuario'];
            $fotoUsuario  = $registro['fotoUsuario'];
            $emailUsuario = $registro['emailUsuario'];
            $nomeUsuario  = $registro['nomeUsuario'];

            // Cria variáveis de Sessão para armazenar os valores
            $_SESSION['idUsuario']    = $idUsuario;
            $_SESSION['fotoUsuario']  = $fotoUsuario;
            $_SESSION['emailUsuario'] = $emailUsuario;
            $_SESSION['nomeUsuario']  = $nomeUsuario;
            $_SESSION['logado']       = true;
    
            header('Location: ../index.php'); // Redireciona para a Página Inicial
            exit(); // Encerra o script para garantir que o redirecionamento ocorra
        }
        else {
            // Se não encontrou registro ou se campos estão vazios, redireciona com erro
            header('Location: ../view/UsuarioView/formLogin.php?erroLogin=dadosInvalidos');
            exit(); // Encerra o script para garantir que o redirecionamento ocorra
        }
    }
    else {
        // Se o formulário não foi submetido, redireciona para o formulário de login
        header('Location: ../view/UsuarioView/formLogin.php');
        exit(); // Encerra o script para garantir que o redirecionamento ocorra
    }

?>