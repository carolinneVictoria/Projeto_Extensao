<?php

class Venda {
    private $conn;

    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
    }

    public function getConnection() {
        return $this->conn;
    }
//Metodo para listar
public function listarVendas() {
    $listarVendas = "SELECT Venda.idVenda, Venda.data, Venda.valorTotal, Venda.formaPagamento, Usuario.nomeUsuario, Produto.nomeProduto
                        FROM Venda
                        INNER JOIN Usuario ON Venda.idUsuario = Usuario.idUsuario
                        INNER JOIN VendaProduto ON Venda.idVenda = VendaProduto.idVenda
                        INNER JOIN Produto ON VendaProduto.idProduto = Produto.idProduto
                        GROUP BY Venda.idVenda
                        ORDER BY Venda.idVenda; ";
    $res = mysqli_query($this->conn, $listarVendas);
    return $res;
}

    // Método para cadastrar
    public function cadastrarVenda( $idUsuario, $data, $descontoVenda, $valorTotal, $formaPagamento) {
    // Prepara a query com parâmetros
    $stmt = $this->conn->prepare("INSERT INTO Venda (idUsuario, data, descontoVenda, valorTotal, formaPagamento)
                                VALUES (?, ?, ?, ?, ?)");
    if (!$stmt) {
        die("Erro ao preparar: " . $this->conn->error);
    }
    $stmt->bind_param("issds", $idUsuario, $data, $descontoVenda, $valorTotal, $formaPagamento);
    if ($stmt->execute()) {
        return $this->conn->insert_id; // Retorna o ID da venda inserida
    } else {
        return false;
    }
}
    //Metódo para atualizar
    public function atualizarVenda($idVenda, $idUsuario, $data, $descontoVenda, $valorTotal, $formaPagamento){
        $atualizarVenda = "UPDATE Venda
                                SET idUsuario       = '$idUsuario',
                                    data            = '$data',
                                    descontoVenda   = '$descontoVenda',
                                    valorTotal      = '$valorTotal',
                                    formaPagamento  = '$formaPagamento'

                                WHERE idVenda     = '$idVenda'
                                ";
        
        $res = mysqli_query($this->conn, $atualizarVenda);
        return $res;
    }

    public function excluirVenda($idVenda){
        $query = "DELETE FROM Venda WHERE idVenda=?";
        $stmt = $this->conn->prepare($query);
        if ($stmt === false) {
            echo "Erro na preparação da consulta.";
        return false;
    }
    $stmt->bind_param("i", $idVenda);
    return ($stmt->execute());
    }

    public function buscarPorNome($termo) {
    $buscarPorNome = "SELECT Venda.*, Usuario.nomeUsuario, Produto.nomeProduto
                            FROM Venda
                            INNER JOIN Usuario ON Venda.idUsuario = Usuario.idUsuario
                            INNER JOIN Produto ON Venda.idProduto = Produto.idProduto
                            WHERE Venda.valorTotal LIKE ? OR Produto.nomeProduto LIKE ? OR Usuario.nomeUsuario LIKE ?";
    $stmt = $this->conn->prepare($buscarPorNome);
    $like = "%" . $termo . "%";
    $stmt->bind_param("sss", $like, $like, $like);
    $stmt->execute();
    $res = $stmt->get_result();
    return $res;
}

// Método para buscar os detalhes
    public function buscarVendaPorId($idVenda) {
    $stmt = $this->conn->prepare("SELECT Venda.*, Usuario.nomeUsuario
                                    FROM Venda
                                    INNER JOIN Usuario ON Venda.idUsuario = Usuario.idUsuario
                                    WHERE Venda.idVenda = ?");
    $stmt->bind_param("i", $idVenda);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        return $row;
    } else {
        return null;
    }
}

    public function atualizarValorTotalVenda($idVenda, $valorTotal) {
        $query = "UPDATE Venda SET valorTotal = ? WHERE idVenda = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("di", $valorTotal, $idVenda);
        return $stmt->execute();
    }

}

?>
