<?php
include_once 'C:/xampp/htdocs/Projeto_Extensao/model/Header.php';

class HeaderController {
    public function carregarHeader() {
        $header = new Header();
        $dadosUsuario = $header->verificarSessao();

        // Caso o usuário esteja logado, passa os dados para a view
        if ($dadosUsuario) {
            return $dadosUsuario; 
        } else {
            return null; // Se não estiver logado
        }
    }

    public function sair() {
        $header = new Header();
        $header->sair();
        header("Location: formLogin.php");
    }
}
?>
