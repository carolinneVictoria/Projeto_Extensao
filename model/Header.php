<?php
class Header {
    public function verificarSessao() {
        
        if (isset($_SESSION['logado']) && $_SESSION['logado'] === true) {
            return [
                'idUsuario'    => $_SESSION["idUsuario"],
                'tipoUsuario'  => $_SESSION["tipoUsuario"],
                'fotoUsuario'  => $_SESSION["fotoUsuario"],
                'nomeUsuario'  => $_SESSION["nomeUsuario"],
                'emailUsuario' => $_SESSION["emailUsuario"]
            ];
        }
        return null; // Se não estiver logado
    }
    public function sair() {
        session_start();
        session_unset();
        session_destroy();
    }
}
?>