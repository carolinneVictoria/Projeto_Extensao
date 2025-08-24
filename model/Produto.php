<?php

class Produto {
    private $conn;

    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
    }

    public function getConnection() {
        return $this->conn;
    }

    public function listarProdutos() {
        $listarProdutos = "SELECT Produto.*, Categoria.descricao FROM Produto INNER JOIN Categoria ON Produto.idCategoria = Categoria.idCategoria ORDER BY Produto.nomeProduto ASC";
        $res = mysqli_query($this->conn, $listarProdutos);
        return $res;
    }

    // Método para cadastrar um novo produto
    public function cadastrarProduto($nomeProduto, $descricaoProduto, $quantidadeProduto, $valorProduto, $idCategoria) {
    $sql = "INSERT INTO Produto (nomeProduto, descricaoProduto, quantidadeProduto, valorProduto, idCategoria)
            VALUES (?, ?, ?, ?, ?)";
    
    $stmt = $this->conn->prepare($sql);
    
    if (!$stmt) {
        die("Erro ao preparar statement: " . $this->conn->error);
    }

    $stmt->bind_param("ssids", $nomeProduto, $descricaoProduto, $quantidadeProduto, $valorProduto, $idCategoria);
    
    $resultado = $stmt->execute();
    
    if (!$resultado) {
        die("Erro ao executar: " . $stmt->error);
    }

    $stmt->close();
    return $this->conn->insert_id; // retorna o ID do novo produto inserido
}


    //Metódo para atualizar os detalhes de um produto./
    public function atualizarProduto($idProduto, $nomeProduto, $descricaoProduto, $quantidadeProduto, $valorProduto, $idCategoria){
        $atualizarProduto = "UPDATE Produto
                                SET nomeProduto       = '$nomeProduto',
                                    descricaoProduto  = '$descricaoProduto',
                                    quantidadeProduto = '$quantidadeProduto',
                                    valorProduto      = '$valorProduto',
                                    idCategoria       = '$idCategoria'

                                WHERE idProduto       = '$idProduto'
                                ";
        
        $res = mysqli_query($this->conn, $atualizarProduto);
        return $res;
    }

    public function excluirProduto($idProduto){
        $query = "DELETE FROM Produto WHERE idProduto=?";
        $stmt = $this->conn->prepare($query);
        if ($stmt === false) {
            echo "Erro na preparação da consulta.";
        return false;
    }
    $stmt->bind_param("i", $idProduto);
    return ($stmt->execute());
    }

    public function buscarPorNome($termo) {
    $buscarProduto = "SELECT Produto.*, Categoria.descricao
                      FROM Produto
                      INNER JOIN Categoria ON Produto.idCategoria = Categoria.idCategoria
                      WHERE nomeProduto LIKE ? OR Categoria.descricao Like ?";
    $stmt = $this->conn->prepare($buscarProduto);
    $like = "%" . $termo . "%";
    $stmt->bind_param("ss", $like, $like);
    $stmt->execute();
    $res = $stmt->get_result();
    return $res;
}

// Método para buscar os detalhes de um produto específico
    public function buscarProdutoporId($idProduto) {
    $stmt = $this->conn->prepare("SELECT Produto.*, Categoria.descricao FROM Produto INNER JOIN Categoria ON Produto.idCategoria = Categoria.idCategoria WHERE Produto.idProduto = ?");
    $stmt->bind_param("i", $idProduto);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        return $row; 
    } else {
        return null;
    }
}
public function reduzirEstoque($idProduto, $quantidade) {
    $sql = "UPDATE Produto SET quantidadeProduto = quantidadeProduto - ? WHERE id = ?";
    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param("ii", $quantidade, $idProduto);
    return $stmt->execute();
}
public function listarProdutosPaginados($limite, $offset) {
        $sql = "SELECT Produto.*, Categoria.descricao
                    FROM Produto
                    INNER JOIN Categoria ON Produto.idCategoria = Categoria.idCategoria
                    ORDER BY nomeProduto ASC
                    LIMIT ? OFFSET ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $limite, $offset);
        $stmt->execute();
        return $stmt->get_result();
    }
    public function contarProdutos() {
        $sql = "SELECT COUNT(*) as total FROM Produto";
        $resultado = $this->conn->query($sql);
        $row = $resultado->fetch_assoc();
        return $row['total'];
    }

}
?>
