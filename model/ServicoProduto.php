<?php

class ServicoProduto {
    private $conn;

    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
    }

    public function getConnection() {
        return $this->conn;
    }

public function adicionarProdutoServico($idProduto, $idServico, $quantidade, $valorUnitario) {
    $adicionarProduto = "INSERT INTO servicoProduto (idProduto, idServico, quantidade, valorUnitario)
                            VALUES ('$idProduto', '$idServico', '$quantidade', '$valorUnitario')";

    $res = mysqli_query($this->conn, $adicionarProduto);
    
    if (!$res) {
        echo "Erro SQL: " . mysqli_error($this->conn);
    }

    return $res;
}


    public function listarProdutosServico($idServico) {
    $sql = "SELECT servicoProduto.*, Produto.nomeProduto 
            FROM servicoProduto
            INNER JOIN Produto ON servicoProduto.idProduto = Produto.idProduto
            WHERE servicoProduto.idServico = ?
            ORDER BY Produto.nomeProduto";
    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param("i", $idServico);
    $stmt->execute();
    return $stmt->get_result();
}

}
?>