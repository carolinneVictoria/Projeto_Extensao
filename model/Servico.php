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
    public function cadastrarServico($idCliente, $idUsuario, $descricao, $dataEntrada, $entrega, $valorTotal, $maodeObra) {
        $cadastrarServico = "INSERT INTO Servico (idCliente, idUsuario, descricao, dataEntrada, entrega, valorTotal, maodeObra)
                            VALUES ('$idCliente', '$idUsuario', '$descricao', '$dataEntrada', '$entrega', '$valorTotal', '$maodeObra')";

        $res = mysqli_query($this->conn, $cadastrarServico);
        return $res;
    }


    //Metódo para atualizar 
    public function atualizarServico($idServico, $idCliente, $idUsuario, $descricao, $dataEntrada, $entrega, $valorTotal, $maodeObra){
        $atualizarServico = "UPDATE Servico 
                                SET idCliente       = '$idCliente',
                                    idUsuario       = '$idUsuario',
                                    descricao       = '$descricao',
                                    dataEntrada     = '$dataEntrada',
                                    entrega         = '$entrega',
                                    valorTotal      = '$valorTotal',
                                    maodeObra       = '$maodeObra'

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
                            WHERE Servico.descricao LIKE ? OR Cliente.nome LIKE ? OR Usuario.nomeUsuario LIKE ?";
    $stmt = $this->conn->prepare($buscarPorNome);
    $like = "%" . $termo . "%";
    $stmt->bind_param("sss", $like, $like, $like);
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

    public function atualizarValorTotalServico($idServico, $valorTotal) {
        $query = "UPDATE Servico SET valorTotal = ? WHERE idServico = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("di", $valorTotal, $idServico);
        return $stmt->execute();
    }

}

?>
