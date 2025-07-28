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

}

?>