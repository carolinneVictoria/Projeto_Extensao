<?php

class Cliente{
private $conn;

    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
    }
    public function getConnection() {
    return $this->conn;
}


    public function cadastrarCliente($nome, $telefone, $cpf, $dataNascimento, $endereco, $bicicleta){
        $cadastrar = "INSERT INTO Cliente (nome, telefone, cpf, dataNascimento, endereco, bicicleta)
                            VALUES ('$nome', '$telefone', '$cpf', '$dataNascimento', '$endereco', '$bicicleta')";
        $res = mysqli_query($this->conn, $cadastrar);
        if(!$res) {
            echo "Erro MYSQL: " . mysqli_error($this->conn);
        }
        return $res;
    }

    public function listarClientes(){
        $listar = "SELECT * FROM Cliente";
        $res = mysqli_query($this->conn, $listar);
        return $res;
    }

    public function atualizarCliente($idCliente, $nome, $telefone, $cpf, $dataNascimento, $endereco, $bicicleta) {
        $atualizar = "UPDATE Cliente
                        SET  nome           = '$nome',
                             telefone       = '$telefone',
                             cpf            = '$cpf',
                             dataNascimento = '$dataNascimento',
                             endereco       = '$endereco',
                             bicicleta      = '$bicicleta'

                            WHERE idCliente = '$idCliente'
                        ";
        $res = mysqli_query($this->conn, $atualizar);
        return $res;
    }

    public function excluirCliente($idCliente) {
        $excluir = "DELETE FROM Cliente WHERE idCliente=?";
        $stmt = $this->conn->prepare($excluir);
        if ($stmt === false) {
            echo "Erro na preparação de consulta.";
            return false;
        }
        $stmt->bind_param("i", $idCliente);
        return ($stmt->execute());
    }


    public function buscarPorNome($termo) {
        $buscar = "SELECT * FROM Cliente WHERE nome LIKE ?";
        $stmt = $this->conn->prepare($buscar);
        $like = "%" . $termo . "%";
        $stmt->bind_param("s", $like);
        $stmt->execute();
        $res = $stmt->get_result();
        return $res;
    }

    public function buscarClientePorId($idCliente) {
        $stmt = $this->conn->prepare("SELECT * FROM Cliente WHERE idCliente = ?");
        $stmt->bind_param("i", $idCliente);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            return $row;
        } else {
            return null;
        }
    }

    public function listarClientesPaginados($limite, $offset) {
        $sql = "SELECT * FROM Cliente LIMIT ? OFFSET ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $limite, $offset);
        $stmt->execute();
        return $stmt->get_result();
    }

    // Conta o total de registros
    public function contarClientes() {
        $sql = "SELECT COUNT(*) as total FROM Cliente";
        $resultado = $this->conn->query($sql);
        $row = $resultado->fetch_assoc();
        return $row['total'];
    }

}

?>