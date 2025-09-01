<?php
class VendaProduto {
    private $conn;

    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
    }
    public function getConnection() {
        return $this->conn;
    }
    public function adicionarProdutoVenda($idProduto, $idVenda, $quantidade, $valorUnitario) {
        $adicionarProduto = "INSERT INTO VendaProduto (idProduto, idVenda, quantidade, valorUnitario)
                                VALUES ('$idProduto', '$idVenda', '$quantidade', '$valorUnitario')";

        $res = mysqli_query($this->conn, $adicionarProduto);
        
        if (!$res) {
            echo "Erro SQL: " . mysqli_error($this->conn);
        }
        return $res;
    }
    public function atualizarProdutoVenda($idVenda, $idProduto, $quantidade, $valorUnitario) {
        $sql = "UPDATE vendaProduto
                SET quantidade    = ?,
                        valorUnitario = ?
                    WHERE idVenda       = ?
                    AND idProduto     = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("diii", $quantidade, $valorUnitario, $idVenda, $idProduto);
        return $stmt->execute();
    }
    public function excluirProdutoVenda($idVenda, $idProduto){
        $query = "DELETE FROM VendaProduto WHERE idVenda=? AND idProduto=?";
        $stmt = $this->conn->prepare($query);
        if ($stmt === false) {
            echo "Erro na preparação da consulta.";
        return false;
        }
        $stmt->bind_param("ii", $idVenda, $idProduto);
        return ($stmt->execute());
    }
    public function listarProdutosVenda($idVenda) {
        $sql = "SELECT vendaProduto.*, Produto.nomeProduto
                FROM vendaProduto
                INNER JOIN Produto ON vendaProduto.idProduto = Produto.idProduto
                WHERE vendaProduto.idVenda = ?
                ORDER BY Produto.nomeProduto";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $idVenda);
        $stmt->execute();
        return $stmt->get_result();
    }
    public function buscarProdutoVenda($idVenda, $idProduto) {
        $query = "SELECT vp.*, p.nomeProduto
                    FROM vendaProduto AS vp
                    INNER JOIN produto AS p ON vp.idProduto = p.idProduto
                    WHERE vp.idVenda = ? AND vp.idProduto = ?";
        $stmt = $this->conn->prepare($query);
        if (!$stmt) {
            die("Erro no prepare: " . $this->conn->error);
        }
        $stmt->bind_param("ii", $idVenda, $idProduto);
        $stmt->execute();
        $resultado = $stmt->get_result();
        return $resultado->fetch_assoc();
    }
}
?>