<?php
include_once "../model/Produto.php";
include_once "../conexaoBD.php";

// Instanciando o Model
$produtoModel = new Produto($conn);

// Função para cadastrar o produto
function cadastrarProduto($produtoModel) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nomeProduto = $_POST['nomeProduto'];
        $descricaoProduto = $_POST['descricaoProduto'];
        $quantidadeProduto = $_POST['quantidadeProduto'];
        $valorProduto = $_POST['valorProduto'];
        $categoriaProduto = $_POST['categoriaProduto'];

        if ($produtoModel->cadastrarProduto($nomeProduto, $descricaoProduto, $quantidadeProduto, $valorProduto, $categoriaProduto)) {
            header("Location: ../view/produtos.php");
            exit();
        } else {
            echo "Erro ao cadastrar produto!";
        }
    }
}
// Função para listar os produtos
function listarProdutos($produtoModel) {
    $produtos = $produtoModel->listarProdutos();
    include('../view/produtos.php');
}

// Função para exibir o formulário de atualização de produto
function exibirFormAtualizarProduto($produtoModel) {
    if (isset($_GET['id'])) {
        $idProduto = $_GET['id'];

        echo "ID do produto recebido: " . $idProduto . "<br>";


        $produto = $produtoModel->buscarProdutoPorId($idProduto);
        if ($produto) {
            include '../view/formAtualizarProdutos.php';
        } else {
            echo "Produto não encontrado!";
        } 
    }
        else {
            echo"Id do produto nao especificado";
        }
}

// Função para processar a atualização do produto
function atualizarProduto($produtoModel) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
        $idProduto = $_POST['idProduto'];
        $nomeProduto = $_POST['nomeProduto'];
        $descricaoProduto = $_POST['descricaoProduto'];
        $quantidadeProduto = $_POST['quantidadeProduto'];
        $valorProduto = $_POST['valorProduto'];
        $categoriaProduto = $_POST['categoriaProduto'];

        if ($produtoModel->atualizarProduto($idProduto, $nomeProduto, $descricaoProduto, $quantidadeProduto, $valorProduto, $categoriaProduto)) {
            header("Location: produtos.php");
            exit();
        } else {
            echo "Erro ao atualizar o produto!";
        }
    }
}
// Determina qual ação chamar com base na URL ou método
if (isset($_GET['acao'])) {
    $acao = $_GET['acao'];

    // Chamando a ação de acordo com a URL
    if ($acao == 'cadastrar') {
        cadastrarProduto($produtoModel);
    } elseif ($acao == 'listar') {
        listarProdutos($produtoModel);
    } elseif ($acao == 'atualizar') {
        exibirFormAtualizarProduto($produtoModel);
        atualizarProduto($produtoModel); // Se o formulário for enviado, processa a atualização
    }
} else {
    // Caso nenhuma ação seja especificada, exibe a listagem
    listarProdutos($produtoModel);
}
?>
