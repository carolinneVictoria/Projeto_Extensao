<?php

class Estoque {
    private $conn;

    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
    }

    public function getConnection() {
        return $this->conn;
    }

    // Método para cadastrar
    public function cadastrarCompra( $idFornecedor, $idUsuario, $data, $valorTotal, $descricao) {
        // Prepara a query com parâmetros
        $stmt = $this->conn->prepare("INSERT INTO Compra (idFornecedor, idUsuario, data, valorTotal, descricao)
                                    VALUES (?, ?, ?, ?, ?)");
        if (!$stmt) {
            die("Erro ao preparar: " . $this->conn->error);
        }
        $stmt->bind_param("iisds", $idFornecedor, $idUsuario, $data, $valorTotal, $descricao);
        if ($stmt->execute()) {
            return $this->conn->insert_id;
        } else {
            return false;
        }
    }

    //Metodo para listar
    public function listarCompras(){
        $listar = "SELECT Compra.idCompra, Compra.data, Compra.descricao, Compra.valorTotal, Fornecedor.razaoSocial
                    FROM Compra
                    INNER JOIN Fornecedor ON Compra.idFornecedor = Fornecedor.idFornecedor
                    ORDER BY Compra.idCompra";
        $res = mysqli_query($this->conn, $listar);
        return $res;
    }

}

?>