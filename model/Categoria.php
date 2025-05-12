<?php
    class Categoria{

    private $conn;

    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
    }

    public function listarCategorias(){

        $sql = "SELECT * FROM Categoria ";
        $result = $this->conn->query($sql);

        $categorias = [];
        while ($row = $result->fetch_assoc()) {
            $categorias[] = $row;
        }

        return $categorias;
    }

    }
?>