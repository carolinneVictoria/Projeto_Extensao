<?php

class Servico {
    private $conn;

    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
    }

    public function getConnection() {
        return $this->conn;
    }

    // Método para listar 
    public function listarServicos() {
        $listarServicos = "SELECT Servico.*, Cliente.nome, Usuario.nomeUsuario 
                            FROM Servico 
                            INNER JOIN Cliente ON Servico.idCliente = Cliente.idCliente 
                            INNER JOIN Usuario ON Servico.idUsuario = Usuario.idUsuario 
                            ORDER BY idServico";
        $res = mysqli_query($this->conn, $listarServicos);
        return $res;
    }

    public function listarEntregues() {
        $listarServicos = "SELECT Servico.*, Cliente.nome, Usuario.nomeUsuario 
                            FROM Servico 
                            INNER JOIN Cliente ON Servico.idCliente = Cliente.idCliente 
                            INNER JOIN Usuario ON Servico.idUsuario = Usuario.idUsuario 
                            WHERE entrega = 0
                            ORDER BY idServico";
        $res = mysqli_query($this->conn, $listarServicos);
        return $res;
    }

    public function listarPendentes() {
        $listarServicos = "SELECT Servico.*, Cliente.nome, Usuario.nomeUsuario 
                            FROM Servico 
                            INNER JOIN Cliente ON Servico.idCliente = Cliente.idCliente 
                            INNER JOIN Usuario ON Servico.idUsuario = Usuario.idUsuario 
                            WHERE entrega = 1
                            ORDER BY idServico";
        $res = mysqli_query($this->conn, $listarServicos);
        return $res;
    }


    // Método para cadastrar 
    public function cadastrarServico($idCliente, $idUsuario, $descricao, $dataEntrada, $entrega, $valorTotal) {
        $cadastrarServico = "INSERT INTO Servico (idCliente, idUsuario, descricao, dataEntrada, entrega, valorTotal)
                            VALUES ('$idCliente', '$idUsuario', '$descricao', '$dataEntrada', '$entrega', '$valorTotal')";

        $res = mysqli_query($this->conn, $cadastrarServico);
        return $res;
    }

    public function cadastrarProduto($idServico, $idProduto, $quantidade, $valorUnitario) {
        $cadastrarProduto = "INSERT INTO produtoServico (idServico, idProduto, quantidade, valorUnitario)
                            VALUES ('$idServico', '$idProduto', '$quantidade', '$valorUnitario')";

        $res = mysqli_query($this->conn, $cadastrarProduto);
        return $res;
    }


    //Metódo para atualizar 
    public function atualizarServico($idServico, $idCliente, $idUsuario, $descricao, $dataEntrada, $entrega, $valorTotal){
        $atualizarServico = "UPDATE Servico 
                                SET idCliente       = '$idCliente',
                                    idUsuario       = '$idUsuario',
                                    descricao       = '$descricao',
                                    dataEntrada     = '$dataEntrada',
                                    entrega         = '$entrega',
                                    valorTotal      = '$valorTotal'

                                WHERE idServico     = '$idServico'
                                ";
        
        $res = mysqli_query($this->conn, $atualizarServico);
        return $res;
    }

    public function excluirServico($idServico){
        $query = "DELETE FROM Servico WHERE idServico=?";
        $stmt = $this->conn->prepare($query);
        if ($stmt === false) {
            echo "Erro na preparação da consulta.";
        return false;
    }
    $stmt->bind_param("i", $idServico);
    return ($stmt->execute());
    }

    public function buscarPorNome($termo) {
    $buscarPorNome = "SELECT Servico.*, Cliente.nome, Usuario.nomeUsuario 
                            FROM Servico 
                            INNER JOIN Cliente ON Servico.idCliente = Cliente.idCliente 
                            INNER JOIN Usuario ON Servico.idUsuario = Usuario.idUsuario 
                            WHERE descricao LIKE ?";
    $stmt = $this->conn->prepare($buscarPorNome);
    $like = "%" . $termo . "%";
    $stmt->bind_param("s", $like);
    $stmt->execute();
    $res = $stmt->get_result();
    return $res;
}

// Método para buscar os detalhes 
    public function buscarServicoPorId($idServico) {
    $stmt = $this->conn->prepare("SELECT Servico.*, Cliente.nome, Usuario.nomeUsuario 
                                    FROM Servico 
                                    INNER JOIN Cliente ON Servico.idCliente = Cliente.idCliente 
                                    INNER JOIN Usuario ON Servico.idUsuario = Usuario.idUsuario 
                                    WHERE Servico.idServico = ?");
    $stmt->bind_param("i", $idServico);
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
