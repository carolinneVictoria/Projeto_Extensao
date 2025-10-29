<?php
class Servico {
    private $conn;

    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
    }
    public function getConnection() {
        return $this->conn;
    }
    public function listarServicos() {
        $listarServicos = "SELECT Servico.*, Cliente.nome, Usuario.nomeUsuario
                            FROM Servico
                            INNER JOIN Cliente ON Servico.idCliente = Cliente.idCliente
                            INNER JOIN Usuario ON Servico.idUsuario = Usuario.idUsuario
                            ORDER BY idServico DESC";
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
    public function cadastrarServico($idCliente, $idUsuario, $descricao, $dataEntrada, $entrega, $valorTotal, $maodeObra) {
        $cadastrarServico = "INSERT INTO Servico (idCliente, idUsuario, descricao, dataEntrada, entrega, valorTotal, maodeObra)
                            VALUES ('$idCliente', '$idUsuario', '$descricao', '$dataEntrada', '$entrega', '$valorTotal', '$maodeObra')";

        $res = mysqli_query($this->conn, $cadastrarServico);
        return $res;
    }
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
    public function totalServicosPorMes($mes, $ano) {
        $sql = "SELECT SUM(valorTotal) AS totalServicos FROM servico WHERE entrega = '0' AND MONTH(dataEntrada) = ? AND YEAR(dataEntrada) = ?";
        
        $stmt = $this->conn->prepare($sql);
        
        if (!$stmt) {
            return 0;
        }

        $stmt->bind_param("ii", $mes, $ano);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $row = $resultado->fetch_assoc();
        
        return $row['totalServicos'] ?? 0;
    }
    public function listarServicosPaginados($limite, $offset) {
        $sql = "SELECT Servico.*, Cliente.nome, Usuario.nomeUsuario
                            FROM Servico
                            INNER JOIN Cliente ON Servico.idCliente = Cliente.idCliente
                            INNER JOIN Usuario ON Servico.idUsuario = Usuario.idUsuario
                            ORDER BY dataEntrada DESC
                            LIMIT ? OFFSET ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $limite, $offset);
        $stmt->execute();
        return $stmt->get_result();
    }
    public function listarServicosPaginadosEntregues($limite, $offset) {
        $sql = "SELECT Servico.*, Cliente.nome, Usuario.nomeUsuario
                            FROM Servico
                            INNER JOIN Cliente ON Servico.idCliente = Cliente.idCliente
                            INNER JOIN Usuario ON Servico.idUsuario = Usuario.idUsuario
                            WHERE entrega = 0
                            ORDER BY dataEntrada DESC
                            LIMIT ? OFFSET ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $limite, $offset);
        $stmt->execute();
        return $stmt->get_result();
    }
    public function listarServicosPaginadosPendentes($limite, $offset) {
        $sql = "SELECT Servico.*, Cliente.nome, Usuario.nomeUsuario
                            FROM Servico
                            INNER JOIN Cliente ON Servico.idCliente = Cliente.idCliente
                            INNER JOIN Usuario ON Servico.idUsuario = Usuario.idUsuario
                            WHERE entrega = 1
                            ORDER BY dataEntrada DESC
                            LIMIT ? OFFSET ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $limite, $offset);
        $stmt->execute();
        return $stmt->get_result();
    }
    public function contarServicos() {
        $sql = "SELECT COUNT(*) as total FROM Servico";
        $resultado = $this->conn->query($sql);
        $row = $resultado->fetch_assoc();
        return $row['total'];
    }
    public function contarServicosEntregues() {
        $sql = "SELECT COUNT(*) as total FROM Servico WHERE entrega = 0";
        $resultado = $this->conn->query($sql);
        $row = $resultado->fetch_assoc();
        return $row['total'];
    }
    public function contarServicosPendentes() {
        $sql = "SELECT COUNT(*) as total FROM Servico WHERE entrega = 1";
        $resultado = $this->conn->query($sql);
        $row = $resultado->fetch_assoc();
        return $row['total'];
    }
    public function buscarServicosPorMes($mes, $ano) {
    $sql = "SELECT Servico.*, Cliente.nome AS nomeCliente, Usuario.nomeUsuario
            FROM Servico
            INNER JOIN Cliente ON Servico.idCliente = Cliente.idCliente
            INNER JOIN Usuario ON Servico.idUsuario = Usuario.idUsuario
            WHERE MONTH(dataEntrada) = ? AND YEAR(dataEntrada) = ? AND entrega = '0'
            ORDER BY dataEntrada ASC";

    $stmt = $this->conn->prepare($sql);
    if (!$stmt) {
        echo "Erro na preparação da consulta: " . $this->conn->error;
        return false;
    }

    $stmt->bind_param("ii", $mes, $ano);
    $stmt->execute();
    return $stmt->get_result();
    }


}
?>
