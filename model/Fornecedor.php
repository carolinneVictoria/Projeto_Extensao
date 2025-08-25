<?php

class Fornecedor{
private $conn;

    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
    }

    public function cadastrarFornecedor($telefone, $cnpj, $razaoSocial, $endereco){
        $cadastrar = "INSERT INTO Fornecedor (telefone, cnpj, razaoSocial, endereco)
                            VALUES ('$telefone', '$cnpj', '$razaoSocial', '$endereco')";
        $res = mysqli_query($this->conn, $cadastrar);
        if(!$res) {
            echo "Erro MYSQL: " . mysqli_error($this->conn);
        }
        return $res;
    }

    public function listarFornecedores(){
        $listar = "SELECT * FROM Fornecedor";
        $res = mysqli_query($this->conn, $listar);
        return $res;
    }

    public function atualizarFornecedor($idFornecedor, $telefone, $cnpj, $razaoSocial, $endereco) {
        $atualizar = "UPDATE Fornecedor
                        SET  telefone       = '$telefone',
                             cnpj           = '$cnpj',
                             razaoSocial    = '$razaoSocial',
                             endereco       = '$endereco'
                             
                            WHERE idFornecedor = '$idFornecedor'
                        ";
        $res = mysqli_query($this->conn, $atualizar);
        return $res;
    }

    public function excluirFornecedor($idFornecedor) {
        $excluir = "DELETE FROM Fornecedor WHERE idFornecedor=?";
        $stmt = $this->conn->prepare($excluir);
        if ($stmt === false) {
            echo "Erro na preparação de consulta.";
            return false;
        }
        $stmt->bind_param("i", $idFornecedor);
        return ($stmt->execute());
    }

    public function buscarPorNome($termo) {
        $buscar = "SELECT * FROM Fornecedor WHERE razaoSocial LIKE ?";
        $stmt = $this->conn->prepare($buscar);
        $like = "%" . $termo . "%";
        $stmt->bind_param("s", $like);
        $stmt->execute();
        $res = $stmt->get_result();
        return $res;
    }

    public function buscarFornecedorPorId($idFornecedor) {
    $stmt = $this->conn->prepare("SELECT * FROM Fornecedor WHERE idFornecedor = ?");
    $stmt->bind_param("i", $idFornecedor);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        return $row;
    } else {
        return null;
    }
}
    public function listarFornecedoresPaginados($limite, $offset) {
            $sql = "SELECT * FROM Fornecedor LIMIT ? OFFSET ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("ii", $limite, $offset);
            $stmt->execute();
            return $stmt->get_result();
        }

    public function contarFornecedores() {
            $sql = "SELECT COUNT(*) as total FROM Fornecedor";
            $resultado = $this->conn->query($sql);
            $row = $resultado->fetch_assoc();
            return $row['total'];
        }
    }

?>