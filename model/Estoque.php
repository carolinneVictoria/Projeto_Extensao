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

    public function atualizarCompra($idCompra, $idFornecedor, $idUsuario, $data, $valorTotal, $descricao) {
        $atualizar = "UPDATE Compra
                        SET  idFornecedor    = '$idFornecedor',
                             idUsuario       = '$idUsuario',
                             data            = '$data',
                             valorTotal      = '$valorTotal',
                             descricao       = '$descricao'
                             
                            WHERE idCompra = '$idCompra'
                        ";
        $res = mysqli_query($this->conn, $atualizar);
        return $res;
    }

    public function excluirCompra($idCompra) {
        $excluir = "DELETE FROM Compra WHERE idCompra=?";
        $stmt = $this->conn->prepare($excluir);
        if ($stmt === false) {
            echo "Erro na preparação de consulta.";
            return false;
        }
        $stmt->bind_param("i", $idCompra);
        return ($stmt->execute());
    }

    public function buscarPorNome($termo) {
        $buscar = "SELECT * FROM Compra WHERE descricao LIKE ?";
        $stmt = $this->conn->prepare($buscar);
        $like = "%" . $termo . "%";
        $stmt->bind_param("s", $like);
        $stmt->execute();
        $res = $stmt->get_result();
        return $res;
    }

    public function buscarCompraPorId($idCompra) {
    $stmt = $this->conn->prepare("SELECT Compra.*, Usuario.nomeUsuario, Fornecedor.razaoSocial
                                    FROM Compra
                                    INNER JOIN Fornecedor ON Compra.idFornecedor = Fornecedor.idFornecedor
                                    INNER JOIN Usuario ON Compra.idUsuario       = Usuario.idUsuario
                                    WHERE Compra.idCompra = ?");
    $stmt->bind_param("i", $idCompra);
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