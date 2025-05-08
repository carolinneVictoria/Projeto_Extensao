<?php
session_start(); // Inicia a sessão
include_once '../model/Usuario.php';

include_once '../conexaoBD.php'; // Arquivo de conexão com o banco

// Instanciando o Model de Usuario
$usuarioModel = new Usuario($conn);

// Verifica se o formulário foi submetido
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $emailUsuario = $_POST['emailUsuario'];
    $senhaUsuario = $_POST['senhaUsuario'];

    // Verifica o login com o Model
    $resultadoLogin = $usuarioModel->verificarLogin($emailUsuario, $senhaUsuario);

    // Se encontrar o usuário, cria as variáveis de sessão e redireciona
    if ($registro = mysqli_fetch_assoc($resultadoLogin)) {
        $_SESSION['idUsuario']    = $registro['idUsuario'];
        $_SESSION['tipoUsuario']  = $registro['tipoUsuario'];
        $_SESSION['fotoUsuario']  = $registro['fotoUsuario'];
        $_SESSION['emailUsuario'] = $registro['emailUsuario'];
        $_SESSION['nomeUsuario']  = $registro['nomeUsuario'];
        $_SESSION['logado']       = true;
        $_SESSION['ultimoAcesso'] = time();
        
        header('Location: ../index.php'); // Redireciona para a página principal
        exit();
    } else {
        // Se não encontrar o usuário, redireciona com um erro
        header('Location: ../views/formLogin.php?erroLogin=dadosInvalidos');
        exit();
    }
} else {
    // Se o formulário não foi enviado, redireciona para o formulário de login
    header('Location: ../views/formLogin.php');
    exit();
}
?>