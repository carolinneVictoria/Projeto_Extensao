<?php
include_once "../model/Produto.php";
include_once "../conexaoBD.php";

// Instanciando o Model
$produtoModel = new Produto($conn);

// Verificando o método POST do formulário
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nomeProduto = $_POST['nomeProduto'];
    $descricaoProduto = $_POST['descricaoProduto'];
    $quantidadeProduto = $_POST['quantidadeProduto'];
    $valorProduto = $_POST['valorProduto'];
    $categoriaProduto = $_POST['categoriaProduto'];

    // Chamando o método para cadastrar o produto
    if ($produtoModel->cadastrarProduto($nomeProduto, $descricaoProduto, $quantidadeProduto, $valorProduto, $categoriaProduto)) {
        header("Location: ../view/produtos.php");
    } else {
        echo "Erro ao cadastrar produto!";
    }

// Caso contrário, exibe a lista de produtos
$produtos = $produtoModel->listarProdutos();
include('../view/produtos.php');

}
?>
