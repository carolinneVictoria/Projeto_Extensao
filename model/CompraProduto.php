<?php
class CompraProduto {
    private $conn;

    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
    }
    public function getConnection() {
        return $this->conn;
    }
    public function adicionarProdutoCompra($idProduto, $idCompra, $quantidade, $valorUnitario) {
        $adicionarProduto = "INSERT INTO compraProduto (idProduto, idCompra, quantidade, valorUnitario)
                                VALUES ('$idProduto', '$idCompra', '$quantidade', '$valorUnitario')";

        $res = mysqli_query($this->conn, $adicionarProduto);
        
        if (!$res) {
            echo "Erro SQL: " . mysqli_error($this->conn);
        }
        return $res;
    }
    public function atualizarProdutoCompra($idCompra, $idProduto, $quantidade, $valorUnitario) {
        $sql = "UPDATE compraProduto
                SET quantidade    = ?,
                    valorUnitario = ?
                WHERE idCompra      = ?
                AND idProduto     = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("diii", $quantidade, $valorUnitario, $idCompra, $idProduto);
        return $stmt->execute();
    }
    public function excluirProdutoCompra($idCompra, $idProduto){
        $query = "DELETE FROM CompraProduto WHERE idCompra=? AND idProduto=?";
        $stmt = $this->conn->prepare($query);
        if ($stmt === false) {
            echo "Erro na preparação da consulta.";
        return false;
    }
    $stmt->bind_param("ii", $idCompra, $idProduto);
    return ($stmt->execute());
    }
    public function listarProdutosCompra($idCompra) {
    $sql = "SELECT compraProduto.*, Produto.nomeProduto
            FROM compraProduto
            INNER JOIN Produto ON compraProduto.idProduto = Produto.idProduto
            WHERE compraProduto.idCompra = ?
            ORDER BY Produto.nomeProduto";
    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param("i", $idCompra);
    $stmt->execute();
    return $stmt->get_result();
    }
    public function buscarProdutoCompra($idCompra, $idProduto) {
            $query = "SELECT * FROM compraProduto WHERE idCompra = ? AND idProduto = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("ii", $idCompra, $idProduto);
            $stmt->execute();
            $resultado = $stmt->get_result();
            return $resultado->fetch_assoc();
    }
}
?>