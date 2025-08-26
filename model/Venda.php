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
                        ORDER BY Venda.idVenda DESC; ";
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

                                WHERE idVenda       = '$idVenda'
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

    public function buscarPorNome($termo, $limite, $offset) {
    $buscarPorNome = "SELECT Venda.*, Usuario.nomeUsuario, Produto.nomeProduto
                        FROM Venda
                        INNER JOIN Usuario ON Venda.idUsuario = Usuario.idUsuario
                        INNER JOIN VendaProduto ON Venda.idVenda = VendaProduto.idVenda
                        INNER JOIN Produto ON VendaProduto.idProduto = Produto.idProduto
                        WHERE Venda.valorTotal LIKE ?
                            OR Produto.nomeProduto LIKE ?
                            OR Usuario.nomeUsuario LIKE ?
                        LIMIT ? OFFSET ?";

    $stmt = $this->conn->prepare($buscarPorNome);

    if (!$stmt) {
        die("Erro na query: " . $this->conn->error);
    }

    $like = "%" . $termo . "%";
    $stmt->bind_param("sssii", $like, $like, $like, $limite, $offset);
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

    public function totalVendasPorMes($mes, $ano) {
        $sql = "SELECT SUM(valorTotal) AS totalVendas FROM venda WHERE MONTH(data) = ? AND YEAR(data) = ?";

        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            // Tratar erro aqui
            return 0;
        }
        $stmt->bind_param("ii", $mes, $ano);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $row = $resultado->fetch_assoc();

        return $row['totalVendas'] ?? 0;
    }

    public function listarVendasPaginadas($limite, $offset) {
    $sql = "SELECT Venda.*, Usuario.nomeUsuario, Produto.nomeProduto FROM Venda
                        INNER JOIN Usuario ON Venda.idUsuario = Usuario.idUsuario
                        INNER JOIN VendaProduto ON Venda.idVenda = VendaProduto.idVenda
                        INNER JOIN Produto ON VendaProduto.idProduto = Produto.idProduto
                        GROUP BY Venda.idVenda
                        ORDER BY data DESC
                        LIMIT ?, ?";
    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param("ii", $offset, $limite);
    $stmt->execute();
    return $stmt->get_result();
}


    // Conta o total de registros
    public function contarVendas() {
        $sql = "SELECT COUNT(*) as total FROM Venda";
        $resultado = $this->conn->query($sql);
        $row = $resultado->fetch_assoc();
        return $row['total'];
    }
}

?>
