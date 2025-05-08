<?php

    $servidorBD = "localhost"; 
    $usuarioBD  = "root"; 
    $senhaBD    = ""; 
    $nomeBD     = "bd_samukabikes";

    //Cria varíavel booleana para verificar o status da conexão
    $conn       = mysqli_connect($servidorBD, $usuarioBD, $senhaBD, $nomeBD);

    //Verifica se houve algum erro ao estabelecer a conexão com a base de dados e exibe mensagem caso sim
    if(!$conn){
        die ("<p>Erro ao tentar conectar à base de dados $nomeBD</p>" . mysqli_error($conn));
    }

//faz a conexao com meu BD

?>