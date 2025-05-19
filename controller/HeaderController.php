<?php
include_once 'C:/xampp/htdocs/Projeto_Extensao/model/Header.php';
include_once 'C:/xampp/htdocs/Projeto_Extensao/config/conexaoBD.php';

class HeaderController {
    public function carregarHeader() {
        session_start(); 
        if (isset($_SESSION['usuario'])) {
            return $_SESSION['usuario'];
        }
        return null;
    }

    
    public function sair() {
        $header = new Header();
        $header->sair();
        header("Location: formLogin.php");
    }
}
?>
