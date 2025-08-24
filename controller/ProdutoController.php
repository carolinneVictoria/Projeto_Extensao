<?php
include_once "../model/Produto.php";
include_once "../config/conexaoBD.php";
include_once '../model/Categoria.php';
include_once '../model/CompraProduto.php';

$compraProdutoModel =new CompraProduto($conn);
$produtoModel = new Produto($conn);
$categoriaModel = new Categoria($conn);

function cadastrarProduto($produtoModel) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nomeProduto = $_POST['nomeProduto'];
        $descricaoProduto = $_POST['descricaoProduto'];
        $quantidadeProduto = $_POST['quantidadeProduto'];
        $valorProduto = $_POST['valorProduto'];
        $idCategoria = $_POST['idCategoria'];

        if ($produtoModel->cadastrarProduto($nomeProduto, $descricaoProduto, $quantidadeProduto, $valorProduto, $idCategoria)) {
            listarProdutos($produtoModel);
            exit();
        } else {
            echo "Erro ao cadastrar produto!";
        }
    }
}
function cadastrarProdutoCompra($produtoModel, $compraProdutoModel) {
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_GET['id'])) {
        $idCompra = $_GET['id'];

        $nomeProduto      = $_POST['nomeProduto'];
        $descricaoProduto = $_POST['descricaoProduto'];
        $quantidadeProduto= $_POST['quantidadeProduto'];
        $valorProduto     = $_POST['valorProduto'];
        $idCategoria      = $_POST['idCategoria'];

        // Cadastra o produto e recebe o ID dele
        $idProduto = $produtoModel->cadastrarProduto($nomeProduto,$descricaoProduto,$quantidadeProduto,$valorProduto,$idCategoria);

        if ($idProduto) {
            $compraProdutoModel->adicionarProdutoCompra($idProduto,$idCompra,$quantidadeProduto,$valorProduto
            );
            header("Location: /Projeto_Extensao/view/CompraView/produtoCompra.php?id=" . $idCompra);
            exit();
        } else {
            echo "Erro ao cadastrar produto!";
        }
    }
}
function listarProdutos($produtoModel) {
    $paginaAtual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
    $limite = 8; // produtos por página
    $offset = ($paginaAtual - 1) * $limite;

    $produtos = $produtoModel->listarProdutosPaginados($limite, $offset);

    $totalProdutos = $produtoModel->contarProdutos();
    $totalPaginas = ceil($totalProdutos / $limite);
    include('../view/ProdutoView/produtos.php');
}
function atualizarProduto($produtoModel) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['idProduto'])) {
        $idProduto = $_POST['idProduto'];
        $nomeProduto = $_POST['nomeProduto'];
        $descricaoProduto = $_POST['descricaoProduto'];
        $quantidadeProduto = $_POST['quantidadeProduto'];
        $valorProduto = $_POST['valorProduto'];
        $idCategoria = $_POST['categoriaProduto']; //uso o mesmo name que o do formulario

        if ($produtoModel->atualizarProduto($idProduto, $nomeProduto, $descricaoProduto, $quantidadeProduto, $valorProduto, $idCategoria)) {
            listarProdutos($produtoModel);
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
    listarProdutos($produtoModel);
    exit();
    } else {
    echo "Erro ao excluir o Produto. Possivelmente tem associações.";
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
function formCadastro($produtoModel, $categoriaModel){
    $categorias = $categoriaModel->listarCategoria();
    include_once '../view/ProdutoView/formProdutos.php';
}
function verProduto($produtoModel){
    if (isset($_GET['id'])) {
        $idProduto = $_GET['id'];
        $produto = $produtoModel->buscarProdutoPorId($idProduto);

        if ($produto) {
            include_once '../view/ProdutoView/verProduto.php';
        } else {
            header('Location: ../view/ProdutoView/produtos.php&erro=naoencontrado');
            exit();
        }
        } else {
            header('Location: ../view/ProdutoView/produtos.php&erro=naoencontrado');
            exit();
        }
}
function formAtualizar($produtoModel, $categoriaModel){
    if (isset($_GET['id'])) {
        $idProduto = $_GET['id'];
        $produto = $produtoModel->buscarProdutoPorId($idProduto);
        $categoria = $categoriaModel->listarCategoria();

        if ($produto) {
            include_once '../view/ProdutoView/formAtualizarProdutos.php';
        } else {
            header('Location: ../view/ProdutoView/produtos.php&erro=naoencontrado');
            exit();
        }
    } else {
        header('Location: ../view/ProdutoView/produtos.php&erro=naoencontrado');
        exit();
    }
}
function formCompraProduto($produtoModel, $categoriaModel){
    $categorias = $categoriaModel->listarCategoria();
    include_once '../view/ProdutoView/formProdutosCompra.php';
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
        atualizarProduto($produtoModel); // Se o formulário for enviado, processa a atualização
    } elseif ($acao == 'excluir') {
        excluirProduto($produtoModel);
    } elseif($acao == 'buscar') {
        buscarProdutos($produtoModel, $categoriaModel);
    } elseif($acao == 'cadastrarCompra'){
        cadastrarProdutoCompra($produtoModel, $compraProdutoModel);
    } elseif($acao == 'formCadastrar'){
        formCadastro($produtoModel, $categoriaModel);
    } elseif($acao == 'ver'){
        verProduto($produtoModel);
    } elseif($acao == 'formAtualizar'){
        formAtualizar($produtoModel, $categoriaModel);
    } elseif($acao == 'formCompraProduto'){
        formCompraProduto($produtoModel, $categoriaModel);
    }
} else {
    // Caso nenhuma ação seja especificada, exibe a listagem
    listarProdutos($produtoModel);
}
?>
