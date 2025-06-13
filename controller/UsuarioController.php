<?php
require_once '../model/Usuario.php';
include_once '../config/conexaoBD.php';


// Instância do Model
$usuarioModel = new Usuario($conn);

function cadastrarUsuario($usuarioModel) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        session_start();

        $nomeUsuario = $_POST['nomeUsuario'];
        $telefoneUsuario = $_POST['telefoneUsuario'];
        $emailUsuario = $_POST['emailUsuario'];
        $senhaUsuario = $_POST['senhaUsuario'];
        $confirmarSenhaUsuario = $_POST['confirmarSenhaUsuario'];

        // Verificação de senha
        if ($senhaUsuario !== $confirmarSenhaUsuario) {
            $_SESSION['erroSenhaConfirmar'] = "As senhas não coincidem!";
            header('Location: ../view/formUsuario.php');
            exit();
        }

        if(empty($_POST["senhaUsuario"])){
            echo "<div class='alert alert-warning text-center'>O campo <strong>SENHA</strong> é obrigatório!</div>";
            $erroPreenchimento = true;
        } else{
            $senhaUsuario = md5(filtrar_entrada($_POST["senhaUsuario"]));
        }

        //Validação do campo confirmarSenhaUsuario
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

        // Verificação da foto
        if ($_FILES["fotoUsuario"]["size"] > 0) {
            $diretorio = "img/";
            $nomeUnico = uniqid() . '_' . basename($_FILES["fotoUsuario"]["name"]);
            $fotoUsuario = $diretorio . $nomeUnico; // Caminho relativo para salvar no banco
            $tipoDaImagem = strtolower(pathinfo($fotoUsuario, PATHINFO_EXTENSION));

            // Tamanho
            if ($_FILES["fotoUsuario"]["size"] > 5000000) {
                $_SESSION['erroUpload'] = "A foto não pode ser maior que 5MB!";
                header('Location: ../view/formUsuario.php');
                exit();
            }

            // Tipo
            if (!in_array($tipoDaImagem, ["jpg", "jpeg", "png", "webp"])) {
                $_SESSION['erroUpload'] = "A foto precisa estar nos formatos JPG, JPEG, PNG ou WEBP!";
                header('Location: ../view/formUsuario.php');
                exit();
            }

            // Caminho físico do arquivo (fora da view)
            $caminhoCompleto = __DIR__ . "/../" . $fotoUsuario;

            // Upload da imagem
            if (!move_uploaded_file($_FILES["fotoUsuario"]["tmp_name"], $caminhoCompleto)) {
                $_SESSION['erroUpload'] = "Erro ao tentar fazer o upload da foto!";
                header('Location: ../view/formUsuario.php');
                exit();
            }
}

            // Cadastro no banco via model
            $resultado = $usuarioModel->cadastrarUsuario(
                $fotoUsuario,
                $nomeUsuario,
                $telefoneUsuario,
                $emailUsuario,
                $senhaUsuario
            );

            if ($resultado) {
                header('Location: ../view/UsuarioView/usuarios.php');
                exit();
            } else {
                $_SESSION['erroCadastro'] = "Erro ao cadastrar usuário!";
                header('Location: ../view/UsuarioView/formUsuario.php');
                exit();
            }
        } else {
            $_SESSION['erroUpload'] = "Nenhuma foto foi enviada!";
            header('Location: ../view/UsuarioView/formUsuario.php');
            exit();
        }
    }



function listarUsuarios($usuarioModel) {
    $usuarios = $usuarioModel->listarUsuarios();

    include('../view/UsuarioView/usuarios.php');
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
            header("Location: ../view/UsuarioView/usuarios.php");
            exit();
        } else {
            echo "Erro ao atualizar o usuário!";
        }
    }
}

function excluirUsuario($usuarioModel) {
    $idUsuario = $_GET['id'];
    $resultado = $usuarioModel->excluirUsuario($idUsuario);
    if($resultado) {
        header('Location: ../view/UsuarioView/usuarios.php');
    } else {
        echo "ERRO AO EXCLUIR! Possivelmente tem associações.";
    }
}

function buscarUsuarios($usuarioModel) {
    if (isset($_GET['busca'])) {
        $termo = $_GET['busca'];
        $usuarios = $usuarioModel->buscarPorNome($termo);

        include('../view/UsuarioView/verBuscaUsuario.php'); // Mostra os resultados da busca
    } else {
        echo "Nenhum termo de busca informado.";
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