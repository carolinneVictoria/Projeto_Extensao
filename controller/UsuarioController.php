<?php
require_once '../model/Usuario.php';
include_once '../config/conexaoBD.php';

$usuarioModel = new Usuario($conn);

function cadastrarUsuario($usuarioModel) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        session_start();

        $nomeUsuario = $_POST['nomeUsuario'];
        $telefoneUsuario = $_POST['telefoneUsuario'];
        $emailUsuario = $_POST['emailUsuario'];
        $senhaUsuario = $_POST['senhaUsuario'];
        $confirmarSenhaUsuario = $_POST['confirmarSenhaUsuario'];

        if ($senhaUsuario !== $confirmarSenhaUsuario) {
            $_SESSION['erroSenhaConfirmar'] = "As senhas não coincidem!";
            header('Location: ../controller/UsuarioController.php?acao=formUsuario');
            exit();
        }

        if(empty($_POST["senhaUsuario"])){
            echo "<div class='alert alert-warning text-center'>O campo <strong>SENHA</strong> é obrigatório!</div>";
            $erroPreenchimento = true;
        } else{
            $senhaUsuario = md5(filtrar_entrada($_POST["senhaUsuario"]));
        }

        if(empty($_POST["confirmarSenhaUsuario"])){
            echo "<div class='alert alert-warning text-center'>O campo <strong>CONFIRMAR SENHA</strong> é obrigatório!</div>";
            $erroPreenchimento = true;
        } else{
            $confirmarSenhaUsuario = md5(filtrar_entrada($_POST["confirmarSenhaUsuario"]));
            if($senhaUsuario != $confirmarSenhaUsuario){
                echo "<div class='alert alert-warning text-center'>As senhas informadas são <strong>DIFERENTES</strong>!</div>";
                $erroPreenchimento = true;
            }
        }

        if ($_FILES["fotoUsuario"]["size"] > 0) {
            $diretorio = "img/";
            $extensao = strtolower(pathinfo($_FILES["fotoUsuario"]["name"], PATHINFO_EXTENSION));
            $nomeUnico = uniqid() . '.' . $extensao;

            $fotoUsuario = $diretorio . $nomeUnico; // esse vai pro banco
            $caminhoCompleto = __DIR__ . "/../" . $fotoUsuario; // esse é físico no servidor

            // validações
            if ($_FILES["fotoUsuario"]["size"] > 5000000) {
                $_SESSION['erroUpload'] = "A foto não pode ser maior que 5MB!";
                header('Location: ../controller/UsuarioController.php?acao=formCadastro');
                exit();
            }

            if (!in_array($extensao, ["jpg", "jpeg", "png", "webp"])) {
                $_SESSION['erroUpload'] = "A foto precisa estar nos formatos JPG, JPEG, PNG ou WEBP!";
                header('Location: ../controller/UsuarioController.php?acao=formCadastro');
                exit();
            }

            // tenta mover o arquivo
            if (!move_uploaded_file($_FILES["fotoUsuario"]["tmp_name"], $caminhoCompleto)) {
                $_SESSION['erroUpload'] = "Erro ao tentar fazer o upload da foto!";
                header('Location: ../controller/UsuarioController.php?acao=formCadastro');
                exit();
            } else {
                $_SESSION['sucessoUpload'] = "Foto enviada com sucesso!";
            }

        } else {
            $_SESSION['erroUpload'] = "Nenhuma foto foi enviada!";
            header('Location: ../controller/UsuarioController.php?acao=formCadastro');
            exit();
        }

            $resultado = $usuarioModel->cadastrarUsuario($fotoUsuario,$nomeUsuario,$telefoneUsuario,$emailUsuario,$senhaUsuario);

            if ($resultado) {
                listarUsuarios($usuarioModel);
                exit();
            } else {
                $_SESSION['erroCadastro'] = "Erro ao cadastrar usuário!";
                header('Location: ../controller/UsuarioController.php?acao=formCadastro');
                exit();
            }
        } else {
            $_SESSION['erroUpload'] = "Nenhuma foto foi enviada!";
            header('Location: ../controller/UsuarioController.php?acao=formCadastro');
            exit();
        }
}
function listarUsuarios($usuarioModel) {
    $paginaAtual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
    $limite = 5;
    $offset = ($paginaAtual - 1) * $limite;

    $usuarios = $usuarioModel->listarUsuariosPaginados($limite, $offset);
    $totalUsuarios = $usuarioModel->contarUsuarios();
    $totalPaginas = ceil($totalUsuarios/$limite);

    include('../view/UsuarioView/usuarios.php');
}
function atualizarUsuario($usuarioModel) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['idUsuario'])) {
        session_start();

        $idUsuario = $_POST['idUsuario'];
        $nomeUsuario = $_POST['nomeUsuario'];
        $telefoneUsuario = $_POST['telefoneUsuario'];
        $emailUsuario = $_POST['emailUsuario'];

        $senhaUsuario = !empty($_POST['senhaUsuario'])
            ? md5($_POST['senhaUsuario'])
            : null;

        $fotoUsuarioPath = $_POST['fotoAntiga'] ?? null;

        if (isset($_FILES['fotoUsuario']) && !empty($_FILES['fotoUsuario']['name'])) {
            $fotoUsuario = $_FILES['fotoUsuario'];
            $extensao = strtolower(pathinfo($fotoUsuario['name'], PATHINFO_EXTENSION));

            if (!in_array($extensao, ["jpg", "jpeg", "png", "webp"])) {
                $_SESSION['erroUpload'] = "A foto precisa estar nos formatos JPG, JPEG, PNG ou WEBP!";
                header('Location: ../controller/UsuarioController.php?acao=formAtualizar&id=' . $idUsuario);
                exit();
            }

            if ($fotoUsuario['size'] > 5000000) {
                $_SESSION['erroUpload'] = "A foto não pode ser maior que 5MB!";
                header('Location: ../controller/UsuarioController.php?acao=formAtualizar&id=' . $idUsuario);
                exit();
            }

            $nomeUnico = uniqid() . '.' . $extensao;
            $fotoUsuarioPath = "img/" . $nomeUnico;
            $caminhoCompleto = __DIR__ . "/../" . $fotoUsuarioPath;

            if (!move_uploaded_file($fotoUsuario['tmp_name'], $caminhoCompleto)) {
                $_SESSION['erroUpload'] = "Erro ao tentar fazer o upload da foto!";
                header('Location: ../controller/UsuarioController.php?acao=formAtualizar&id=' . $idUsuario);
                exit();
            }
        }

        if ($usuarioModel->atualizarUsuario($idUsuario, $fotoUsuarioPath, $nomeUsuario, $telefoneUsuario, $emailUsuario, $senhaUsuario)) {
            $_SESSION['sucesso'] = "Usuário atualizado com sucesso!";
            listarUsuarios($usuarioModel);
            exit();
        } else {
            $_SESSION['erroCadastro'] = "Erro ao atualizar o usuário!";
            header('Location: ../controller/UsuarioController.php?acao=formAtualizar&id=' . $idUsuario);
            exit();
        }
    }
}
function excluirUsuario($usuarioModel) {
    $idUsuario = $_GET['id'];
    $resultado = $usuarioModel->excluirUsuario($idUsuario);
    if($resultado) {
        listarUsuarios($usuarioModel);
    } else {
        echo "ERRO AO EXCLUIR! Possivelmente tem associações.";
    }
}
function buscarUsuarios($usuarioModel) {
    if (isset($_GET['busca'])) {
        $termo = $_GET['busca'];
        $usuarios = $usuarioModel->buscarPorNome($termo);

        include('../view/UsuarioView/verBuscaUsuario.php');
    } else {
        echo "Nenhum termo de busca informado.";
    }
}
function verUsuario($usuarioModel){
    if (isset($_GET['id'])) {
        $idUsuario = $_GET['id'];
        $usuario = $usuarioModel->buscarUsuarioPorId($idUsuario);

        if ($usuario) {
            include_once '../view/UsuarioView/verUsuario.php';
        } else {
            header('Location: ../view/UsuarioView/usuarios.php&erro=naoencontrado');
            exit();
        }
    } else {
        header('Location: ../view/UsuarioView/usuarios.php&erro=naoencontrado');
        exit();
    }
}
function formAtualizar($usuarioModel){
    if (isset($_GET['id'])) {
        $idUsuario = $_GET['id'];
        $usuario = $usuarioModel->buscarUsuarioPorId($idUsuario);

        if ($usuario) {
            include_once '../view/UsuarioView/formAtualizarUsuario.php';
        } else {
            header('Location: ../view/UsuarioView/usuarios.php&erro=naoencontrado');
            exit();
        }
    } else {
        header('Location: ../view/UsuarioView/usuarios.php&erro=naoencontrado');
        exit();
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
        excluirUsuario($usuarioModel);
    } elseif ($acao == 'buscar') {
        buscarUsuarios($usuarioModel);
    } elseif($acao == 'ver'){
        verUsuario($usuarioModel);
    } elseif($acao == 'formCadastrar'){
        include_once "../view/UsuarioView/formUsuario.php";
    } elseif($acao == 'formAtualizar'){
        formAtualizar($usuarioModel);
    }
} else {
    listarUsuarios($usuarioModel);
}

function filtrar_entrada($dado){
        $dado = trim($dado); //Remove espaços desnecessários
        $dado = stripslashes($dado); //Remove as barras invertidas
        $dado = htmlspecialchars($dado); //Converte caracteres especiais em entidades HTML

        return($dado); //Retorna o dado já filtrado
    }

?>