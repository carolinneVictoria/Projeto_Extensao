<?php

    session_start();

    $inatividade = 600; //600 segundos = 10 minutos

    if(!isset($_SESSION['logado']) || $_SESSION['logado'] == false){
        header('location:formLogin.php&erroLogin=naoLogado');
    }
    else{
        $tipoUsuario = $_SESSION['tipoUsuario'];
        if($_SESSION['tipoUsuario'] != "administrador"){
            header('location:formLogin.php&erroLogin=acessoProibido');
        }
    }
?>