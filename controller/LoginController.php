<?php
session_start(); // Inicia a sessão
include_once '../model/Usuario.php';
include_once '../config/conexaoBD.php';
include_once '../controller/validarSessao.php';

$usuarioModel = new Usuario($conn);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $emailUsuario = mysqli_real_escape_string($conn, $_POST['emailUsuario']);
        $senhaUsuario = md5(mysqli_real_escape_string($conn, $_POST['senhaUsuario']));

        $buscarLogin = "SELECT * FROM Usuario WHERE emailUsuario = '{$emailUsuario}' AND senhaUsuario = ('{$senhaUsuario}')";

        $efetuarLogin = mysqli_query($conn, $buscarLogin);

        if ($registro = mysqli_fetch_assoc($efetuarLogin)) {
            $idUsuario    = $registro['idUsuario'];
            $fotoUsuario  = $registro['fotoUsuario'];
            $emailUsuario = $registro['emailUsuario'];
            $nomeUsuario  = $registro['nomeUsuario'];

            $_SESSION['idUsuario']    = $idUsuario;
            $_SESSION['fotoUsuario']  = $fotoUsuario;
            $_SESSION['emailUsuario'] = $emailUsuario;
            $_SESSION['nomeUsuario']  = $nomeUsuario;
            $_SESSION['logado']       = true;
    
            header('Location: ../index.php');
            exit();
        }
        else {
            header('Location: ../view/UsuarioView/formLogin.php?erroLogin=dadosInvalidos');
            exit();
        }
    }
    else {
        header('Location: ../view/UsuarioView/formLogin.php');
        exit();
    }

?>