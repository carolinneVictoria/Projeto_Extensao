<?php
    class Categoria{
    private $conn;

    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
    }
    public function listarCategoria() {
        $listarCategoria = "SELECT * FROM Categoria";
        $res = mysqli_query($this->conn, $listarCategoria);
        return $res;
    }
    public function cadastrarCategoria ($descricaoCategoria){
        $cadastrar = "INSERT INTO Categoria (descricao)
                        VALUES ('$descricaoCategoria')";
        $res = mysqli_query($this->conn, $cadastrar);
        if (!$res) {
        echo "Erro MySQL: " . mysqli_error($this->conn);
        }
        return $res;
    }
    public function atualizarCategoria ($idCategoria, $descricaoCategoria) {
        $atualizar = "UPDATE Categoria SET descricao=? WHERE idCategoria=?";
        $stmt = $this->conn->prepare($atualizar);
        $stmt->bind_param("si", $descricaoCategoria, $idCategoria);
        return $stmt->execute();
    }
    public function excluirCategoria ($idCategoria){
        $apagar = "DELETE FROM Categoria WHERE idCategoria=?";
        $stmt = $this->conn->prepare($apagar);
        if ($stmt === false) {
            echo "Erro na preparação da consulta.";
        return false;
        }
        $stmt->bind_param("i", $idCategoria);
        return ($stmt->execute());
    }
    public function buscarPorNome ($termo) {
        $buscarCategoria = "SELECT *
                      FROM Categoria 
                      WHERE descricao LIKE ?";
        $stmt = $this->conn->prepare($buscarCategoria);
        $like = "%" . $termo . "%";
        $stmt->bind_param("s", $like);
        $stmt->execute();
        $res = $stmt->get_result();
        return $res;
    }
}
?>