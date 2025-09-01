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
    public function atualizarProdutoServico($idServico, $idProduto, $quantidade, $valorUnitario) {
        $sql = "UPDATE servicoProduto
                SET quantidade    = ?,
                    valorUnitario = ?
                WHERE idServico     = ?
                AND idProduto     = ?";
        $stmt = $this->conn->prepare($sql);
        // d = double, i = integer
        $stmt->bind_param("iidi", $quantidade, $valorUnitario, $idServico, $idProduto);
        return $stmt->execute();
    }
    public function excluirProdutoServico($idServico, $idProduto){
        $query = "DELETE FROM servicoProduto WHERE idServico=? AND idProduto=?";
        $stmt = $this->conn->prepare($query);
        if ($stmt === false) {
            echo "Erro na preparação da consulta.";
        return false;
    }
    $stmt->bind_param("ii", $idServico, $idProduto);
    return ($stmt->execute());
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
    public function buscarProdutoServico($idServico, $idProduto) {
        $query = "SELECT servicoProduto.*, Produto.nomeProduto
            FROM servicoProduto
            INNER JOIN Produto ON servicoProduto.idProduto = Produto.idProduto
            WHERE servicoProduto.idServico = ? AND servicoProduto.idProduto = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $idServico, $idProduto);
        $stmt->execute();
        $resultado = $stmt->get_result();
        return $resultado->fetch_assoc();
    }
}
?>