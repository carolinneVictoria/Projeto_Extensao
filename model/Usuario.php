<?php
class Usuario {
    private $conn;

    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
    }

    public function getConnection() {
        return $this->conn;
    }

    public function verificarLogin($emailUsuario, $senhaUsuario) {
        $query = "SELECT * FROM Usuario WHERE emailUsuario = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $emailUsuario);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
        $usuario = $result->fetch_assoc();
            if (password_verify($senhaUsuario, $usuario['senhaUsuario'])) {
                return $usuario;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function cadastrarUsuario($fotoUsuario, $nomeUsuario, $telefoneUsuario, $emailUsuario, $senhaUsuario) {
        

        $query = "INSERT INTO Usuario (fotoUsuario, nomeUsuario, telefoneUsuario, emailUsuario, senhaUsuario, tipoUsuario, statusUsuario)
                    VALUES ('$fotoUsuario', '$nomeUsuario', '$telefoneUsuario', '$emailUsuario', '$senhaUsuario', 'padrao', 'ativo')";

        $res = mysqli_query($this->conn, $query);
        if (!$res) {
        echo "Erro MySQL: " . mysqli_error($this->conn);
        }
        return $res;
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
        $query = "UPDATE Usuario SET fotoUsuario=?, nomeUsuario=?, telefoneUsuario=?, emailUsuario=?, senhaUsuario=? WHERE idUsuario=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("sssssi", $fotoUsuario, $nomeUsuario, $telefoneUsuario, $emailUsuario, $senhaUsuario, $idUsuario);
        return $stmt->execute();
    }

    public function excluirUsuario($idUsuario) {
        $excluir = "DELETE FROM Usuario WHERE idUsuario=?";
        $stmt = $this->conn->prepare($excluir);
        if ($stmt === false) {
            echo "Erro na preparação de consulta.";
            return false;
        }
        $stmt->bind_param("i", $idUsuario);
        return ($stmt->execute());
    }

    public function buscarPorNome($termo) {
    $buscarUsuario = "SELECT *
                        FROM Usuario
                        WHERE nomeUsuario LIKE ?";
    $stmt = $this->conn->prepare($buscarUsuario);
    $like = "%" . $termo . "%";
    $stmt->bind_param("s", $like);
    $stmt->execute();
    $res = $stmt->get_result();
    return $res;
    }

    public function listarUsuariosPaginados($limite, $offset) {
                $sql = "SELECT * FROM Usuario LIMIT ? OFFSET ?";
                $stmt = $this->conn->prepare($sql);
                $stmt->bind_param("ii", $limite, $offset);
                $stmt->execute();
                return $stmt->get_result();
    }

    public function contarUsuarios() {
            $sql = "SELECT COUNT(*) as total FROM Usuario";
            $resultado = $this->conn->query($sql);
            $row = $resultado->fetch_assoc();
            return $row['total'];
    }

}
?>
