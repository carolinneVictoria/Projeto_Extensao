<?php
session_start(); // Inicia a sessão
include_once '../models/Usuario.php';
include_once '../conexaoBD.php'; // Arquivo de conexão com o banco de dados

// Instanciando o Model de Usuario
$usuarioModel = new Usuario($conn);

// Verifica se o formulário foi enviado via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fotoUsuario = $_FILES['fotoUsuario'];
    $nomeUsuario = $_POST['nomeUsuario'];
    $telefoneUsuario = $_POST['telefoneUsuario'];
    $emailUsuario = $_POST['emailUsuario'];
    $senhaUsuario = md5($_POST['senhaUsuario']); // Senha criptografada
    $confirmarSenhaUsuario = md5($_POST['confirmarSenhaUsuario']); // Senha confirmada

    // Validação de campos
    $erroPreenchimento = false;
    if (empty($nomeUsuario)) {
        $_SESSION['erroNome'] = "O campo NOME é obrigatório!";
        $erroPreenchimento = true;
    }

    if (empty($telefoneUsuario)) {
        $_SESSION['erroTelefone'] = "O campo TELEFONE é obrigatório!";
        $erroPreenchimento = true;
    }

    if (empty($emailUsuario)) {
        $_SESSION['erroEmail'] = "O campo EMAIL é obrigatório!";
        $erroPreenchimento = true;
    }

    if (empty($senhaUsuario)) {
        $_SESSION['erroSenha'] = "O campo SENHA é obrigatório!";
        $erroPreenchimento = true;
    }

    if ($senhaUsuario != $confirmarSenhaUsuario) {
        $_SESSION['erroSenhaConfirmar'] = "As senhas não coincidem!";
        $erroPreenchimento = true;
    }

    // Validação de Foto
    $fotoUsuarioPath = "img/" . basename($fotoUsuario['name']);
    if ($fotoUsuario['size'] > 5000000) {
        $_SESSION['erroFoto'] = "A foto não pode ser maior do que 5MB!";
        $erroPreenchimento = true;
    }

    // Se não houver erro de preenchimento, insere o usuário no banco
    if (!$erroPreenchimento) {
        move_uploaded_file($fotoUsuario['tmp_name'], $fotoUsuarioPath);
        $usuarioModel->cadastrarUsuario($fotoUsuarioPath, $nomeUsuario, $telefoneUsuario, $emailUsuario, $senhaUsuario);
        header('Location: ../views/usuarioCadastrado.php'); // Redireciona para página de sucesso
        exit();
    } else {
        // Caso haja erro, redireciona com os erros de preenchimento
        header('Location: ../views/formUsuario.php');
        exit();
    }
}
?>