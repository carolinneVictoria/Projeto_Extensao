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
    public function listarPagos() {
        $listarContas = "SELECT *
                            FROM Financeiro
                            WHERE status = 1
                            ORDER BY dataVencimento";
        $res = mysqli_query($this->conn, $listarContas);
        return $res;
    }
    public function listarPendentes() {
        $listarContas = "SELECT *
                            FROM Financeiro
                            WHERE status = 0
                            ORDER BY dataVencimento";
        $res = mysqli_query($this->conn, $listarContas);
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

    public function listarContasPorMesEAno($mes, $ano) {
        $sql = "SELECT * FROM Financeiro WHERE 1=1";

        if (!empty($mes)) {
            $sql .= " AND MONTH(dataVencimento) = $mes";
        }
        if (!empty($ano)) {
            $sql .= " AND YEAR(dataVencimento) = $ano";
        }

        $result = $this->conn->query($sql);
        $contas = [];

        while ($row = $result->fetch_assoc()) {
            $contas[] = $row;
        }

        return $contas;
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
public function totalDespesasPorMes($mes, $ano) {
        $sql = "SELECT SUM(valorTotal) AS totalDespesas FROM financeiro WHERE MONTH(dataVencimento) = ? AND YEAR(dataVencimento) = ?";
        
        $stmt = $this->conn->prepare($sql);
        
        if (!$stmt) {
            // Logar o erro ou lidar com a falha na preparação
            return 0;
        }

        $stmt->bind_param("ii", $mes, $ano);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $row = $resultado->fetch_assoc();
        
        return $row['totalDespesas'] ?? 0;
    }

}

?>