<?php
include_once '../model/Usuario.php';
include_once '../config/conexaoBD.php';


session_start();

// Instância do Model
$usuarioModel = new Usuario($conn);


function cadastrarUsuario($usuarioModel) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $fotoUsuario = $_FILES['fotoUsuario'];
        $nomeUsuario = $_POST['nomeUsuario'];
        $telefoneUsuario = $_POST['telefoneUsuario'];
        $emailUsuario = $_POST['emailUsuario'];
        $senhaUsuario = $_POST['senhaUsuario'];
        $confirmarSenhaUsuario = $_POST['confirmarSenhaUsuario'];

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
        if ($senhaUsuario !== $confirmarSenhaUsuario) {
            $_SESSION['erroSenhaConfirmar'] = "As senhas não coincidem!";
            $erroPreenchimento = true;
        }

        $fotoUsuarioPath = "img/" . basename($fotoUsuario['name']);
        if ($fotoUsuario['size'] > 5000000) {
            $_SESSION['erroFoto'] = "A foto não pode ser maior do que 5MB!";
            $erroPreenchimento = true;
        }

        if (!$erroPreenchimento) {
            move_uploaded_file($fotoUsuario['tmp_name'], $fotoUsuarioPath);

            $usuarioModel->cadastrarUsuario(
                $fotoUsuarioPath,
                $nomeUsuario,
                $telefoneUsuario,
                $emailUsuario,
                $senhaUsuario
            );

            header('Location: ../views/usuarioCadastrado.php');
            exit();
        } else {
            header('Location: ../views/formUsuario.php');
            exit();
        }
    }
}

function listarUsuarios($usuarioModel) {
    $usuarios = $usuarioModel->listarUsuarios();

    include('../view/usuarios.php');
}



function atualizarUsuario($usuarioModel) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['idUsuario'])) {
        $idUsuario = $_POST['idUsuario'];
        $fotoUsuario = $_FILES['fotoUsuario'];
        $nomeUsuario = $_POST['nomeUsuario'];
        $telefoneUsuario = $_POST['telefoneUsuario'];
        $emailUsuario = $_POST['emailUsuario'];
        $senhaUsuario = $_POST['senhaUsuario'];

        $fotoUsuarioPath = "img/" . basename($fotoUsuario['name']);
        move_uploaded_file($fotoUsuario['tmp_name'], $fotoUsuarioPath);

        if ($usuarioModel->atualizarUsuario(
            $idUsuario,
            $fotoUsuarioPath,
            $nomeUsuario,
            $telefoneUsuario,
            $emailUsuario,
            $senhaUsuario
        )) {
            header("Location: ../view/usuarios.php");
            exit();
        } else {
            echo "Erro ao atualizar o usuário!";
        }
    }
}

function excluirUsuario($usuarioModel, $idUsuario){
    $idUsuario = $_GET['id'];
    $resultado = $usuarioModel->excluirUsuario($idUsuario);
    if ($resultado) {
    echo "Usuário excluído com sucesso!";
    header('Location: usuarios.php');
    exit();
    } else {
    echo "Erro ao excluir o usuário.";
    }
}

// Roteamento
if (isset($_GET['acao'])) {
    $acao = $_GET['acao'];

    if ($acao == 'cadastrar') {
        cadastrarUsuario($usuarioModel);
    } elseif ($acao == 'listar') {
        listarUsuarios($usuarioModel);
    } elseif ($acao == 'atualizar') {
        atualizarUsuario($usuarioModel);
    } elseif($acao == 'excluir'){
        excluirUsuario($usuarioModel, $idUsuario);
    }
} else {
    listarUsuarios($usuarioModel);
}

?>