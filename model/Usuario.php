<?php
class Usuario {
    private $conn;

    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
    }

    public function verificarLogin($emailUsuario, $senhaUsuario) {
        $query = "SELECT * FROM Usuario WHERE emailUsuario = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $emailUsuario);
        $stmt->execute();
        $result = $stmt->get_result();
        $usuario = $result->fetch_assoc();

        if ($usuario && password_verify($senhaUsuario, $usuario['senhaUsuario'])) {
            return $usuario;
        }

        return false;
    }

    public function cadastrarUsuario($fotoUsuario, $nomeUsuario, $telefoneUsuario, $emailUsuario, $senhaUsuario) {
        $senhaCriptografada = password_hash($senhaUsuario, PASSWORD_DEFAULT);

        $query = "INSERT INTO Usuario (fotoUsuario, nomeUsuario, telefoneUsuario, emailUsuario, senhaUsuario, tipoUsuario, statusUsuario)
                    VALUES (?, ?, ?, ?, ?, 'admin', 'ativo')";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("sssss", $fotoUsuario, $nomeUsuario, $telefoneUsuario, $emailUsuario, $senhaCriptografada);
        return $stmt->execute();
    }

    public function listarUsuarios() {
        $query = "SELECT * FROM Usuario";
        $res = mysqli_query($this->conn, $query);
        return $res;
    }

    public function buscarUsuarioPorId($idUsuario) {
    $stmt = $this->conn->prepare("SELECT * FROM Usuario WHERE idUsuario = ?");
    $stmt->bind_param("i", $idUsuario);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        return $row; // Retorna os dados do usuário
    } else {
        return null; // Caso o usuário não seja encontrado
    }
}
    public function atualizarUsuario($idUsuario, $fotoUsuario, $nomeUsuario, $telefoneUsuario, $emailUsuario, $senhaUsuario) {
        $senhaCriptografada = password_hash($senhaUsuario, PASSWORD_DEFAULT);
        $query = "UPDATE Usuario SET fotoUsuario=?, nomeUsuario=?, telefoneUsuario=?, emailUsuario=?, senhaUsuario=? WHERE idUsuario=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("sssssi", $fotoUsuario, $nomeUsuario, $telefoneUsuario, $emailUsuario, $senhaCriptografada, $idUsuario);
        return $stmt->execute();
    }
}
?>
