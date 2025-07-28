<?php

class Financeiro{
private $conn;

    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
    }
    public function getConnection() {
    return $this->conn;
}


    public function cadastrarConta($descricao, $valorTotal, $dataVencimento, $status){
        $cadastrar = "INSERT INTO Financeiro (descricao, valorTotal, dataVencimento, status)
                            VALUES ('$descricao', '$valorTotal', '$dataVencimento', '$status')";
        $res = mysqli_query($this->conn, $cadastrar);
        if(!$res) {
            echo "Erro MYSQL: " . mysqli_error($this->conn);
        }
        return $res;
    }

    public function listarContas(){
        $listar = "SELECT * FROM Financeiro";
        $res = mysqli_query($this->conn, $listar);
        return $res;
    }

    public function atualizarConta($idConta, $descricao, $valorTotal, $dataVencimento, $status){
        $atualizar = "UPDATE Financeiro
                        SET descricao       = '$descricao',
                            valorTotal      = '$valorTotal',
                            dataVencimento  = '$dataVencimento',
                            status          = '$status'

                        WHERE idConta = '$idConta'
                    ";
        $res = mysqli_query($this->conn, $atualizar);
        return $res;
    }

    public function excluirConta($idConta) {
        $excluir = "DELETE FROM Financeiro WHERE idConta=?";
        $stmt = $this->conn->prepare($excluir);
        if ($stmt === false) {
            echo "Erro na preparação de consulta.";
            return false;
        }
        $stmt->bind_param("i", $idConta);
        return ($stmt->execute());
    }

    public function buscarPorNome($termo) {
        $buscar = "SELECT * FROM Financeiro WHERE descricao LIKE ?";
        $stmt = $this->conn->prepare($buscar);
        $like = "%" . $termo . "%";
        $stmt->bind_param("s", $like);
        $stmt->execute();
        $res = $stmt->get_result();
        return $res;
    }

    public function buscarContaPorId($idConta) {
    $stmt = $this->conn->prepare("SELECT * FROM Financeiro WHERE idConta = ?");
    $stmt->bind_param("i", $idConta);
    $stmt->execute();
    $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            return $row;
        } else {
            return null;
        }
    }

}

?>