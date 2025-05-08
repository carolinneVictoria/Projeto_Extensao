<?php
class Usuario {
    private $conn;

    // Construtor para a conexão com o banco de dados
    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
    }

    // Método para verificar o login
    public function verificarLogin($emailUsuario, $senhaUsuario) {
        $emailUsuario = mysqli_real_escape_string($this->conn, $emailUsuario);
        $senhaUsuario = mysqli_real_escape_string($this->conn, $senhaUsuario);
        $query = "SELECT * FROM Usuario WHERE emailUsuario = '{$emailUsuario}' AND senhaUsuario = MD5('{$senhaUsuario}')";
        
        // Executa a query e retorna o resultado
        $resultado = mysqli_query($this->conn, $query);
        return $resultado;
    }

    // Método para cadastrar um novo usuário
    public function cadastrarUsuario($fotoUsuario, $nomeUsuario, $telefoneUsuario, $emailUsuario, $senhaUsuario) {
        $query = "INSERT INTO Usuario (fotoUsuario, nomeUsuario, telefoneUsuario, emailUsuario, senhaUsuario, tipoUsuario, statusUsuario)
                  VALUES ('$fotoUsuario', '$nomeUsuario', '$telefoneUsuario', '$emailUsuario', '$senhaUsuario', 'admin', 'ativo')";

        // Executa a consulta de inserção no banco de dados
        $result = mysqli_query($this->conn, $query);
        return $result;
    }
}
?>