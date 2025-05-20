<?php

    session_start();
    session_unset();
    session_destroy();

    header('location:../view/UsuarioView/formLogin.php');
    exit();

?>