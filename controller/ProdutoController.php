<?php
include_once "../model/Produto.php";
include_once "../config/conexaoBD.php";
include_once '../model/Categoria.php';

// Instanciando o Model
$produtoModel = new Produto($conn);
$categoriaModel = new Categoria($conn);

// Função para cadastrar o produto
function cadastrarProduto($produtoModel) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nomeProduto = $_POST['nomeProduto'];
        $descricaoProduto = $_POST['descricaoProduto'];
        $quantidadeProduto = $_POST['quantidadeProduto'];
        $valorProduto = $_POST['valorProduto'];
        $idCategoria = $_POST['idCategoria'];

        if ($produtoModel->cadastrarProduto($nomeProduto, $descricaoProduto, $quantidadeProduto, $valorProduto, $idCategoria)) {
            header("Location: ../view/ProdutoView/produtos.php");
            exit();
        } else {
            echo "Erro ao cadastrar produto!";
        }
    }
}
// Função para listar os produtos
function listarProdutos($produtoModel, $categoriaModel) {
    $produtos = $produtoModel->listarProdutos();
    $categorias = $categoriaModel->listarCategoria();
    include('../view/ProdutoView/produtos.php');
}

// Função para processar a atualização do produto
function atualizarProduto($produtoModel) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['idProduto'])) {
        $idProduto = $_POST['idProduto'];
        $nomeProduto = $_POST['nomeProduto'];
        $descricaoProduto = $_POST['descricaoProduto'];
        $quantidadeProduto = $_POST['quantidadeProduto'];
        $valorProduto = $_POST['valorProduto'];
        $idCategoria = $_POST['categoriaProduto']; //uso o mesmo name que o do formulario

        if ($produtoModel->atualizarProduto($idProduto, $nomeProduto, $descricaoProduto, $quantidadeProduto, $valorProduto, $idCategoria)) {
            header("Location: ../view/ProdutoView/produtos.php");
            exit();
        } else {
            echo "Erro ao atualizar o produto!" . mysqli_error($produtoModel->getConnection());
        }
    }
}

function excluirProduto($produtoModel){
    $idProduto = $_GET['id'];
    $resultado = $produtoModel->excluirProduto($idProduto);
    if ($resultado) {
    echo "Produto excluído com sucesso!";
    header('Location: ../view/ProdutoView/produtos.php');
    exit();
    } else {
    echo "Erro ao excluir o Produto.";
    }
}

function buscarProdutos($produtoModel, $categoriaModel) {
    if (isset($_GET['busca'])) {
        $termo = $_GET['busca'];
        $produtos = $produtoModel->buscarPorNome($termo);
        $categorias = $categoriaModel->listarCategoria();

        include('../view/ProdutoView/verBuscaProduto.php'); // Mostra os resultados da busca
    } else {
        echo "Nenhum termo de busca informado.";
    }
}

// Determina qual ação chamar com base na URL ou método
if (isset($_GET['acao'])) {
    $acao = $_GET['acao'];

    // Chamando a ação de acordo com a URL
    if ($acao == 'cadastrar') {
        cadastrarProduto($produtoModel);
    } elseif ($acao == 'listar') {
        listarProdutos($produtoModel, $categoriaModel);
    } elseif ($acao == 'atualizar') {
        atualizarProduto($produtoModel); // Se o formulário for enviado, processa a atualização
    } elseif ($acao == 'excluir') {
        excluirProduto($produtoModel);
    } elseif($acao == 'buscar') {
        buscarProdutos($produtoModel, $categoriaModel);
    }
} else {
    // Caso nenhuma ação seja especificada, exibe a listagem
    listarProdutos($produtoModel, $categoriaModel);
}
?>
