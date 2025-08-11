<?php
include_once "../config/conexaoBD.php";
include_once "../model/Estoque.php";
include_once "../model/Fornecedor.php";
include_once "../model/Usuario.php";
include_once "../model/Produto.php";
include_once "../model/CompraProduto.php";

$compraModel = new Estoque($conn);
$produtoModel = new Produto($conn);
$compraProdutoModel = new CompraProduto($conn);
$fornecedorModel = new Fornecedor($conn);
$usuarioModel = new Usuario($conn);

function cadastrarCompra($compraModel, $usuarioModel, $fornecedorModel) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $idFornecedor   = $_POST['idFornecedor'];
        $idUsuario      = $_POST['idUsuario'];
        $data           = $_POST['data'];
        $valorTotal     = $_POST['valorTotal'];
        $descricao      = $_POST['descricao'];

        $idCompra = $compraModel->cadastrarCompra($idFornecedor, $idUsuario, $data, $valorTotal, $descricao);

        if ($idCompra) {
            include('../app/header.php');
            listarCompras($compraModel, $usuarioModel, $fornecedorModel);
            exit();
        } else {
            echo "Erro ao cadastrar compra!";
        }
    }
}
// Função para listar
function listarCompras($compraModel, $usuarioModel, $fornecedorModel) {
    $compras      = $compraModel->listarCompras();
    $fornecedores = $fornecedorModel->listarFornecedores();
    $usuarios     = $usuarioModel->listarUsuarios();
    include('../view/CompraView/estoque.php');
}

/// Função para processar a atualização
function atualizarCompra($compraModel, $usuarioModel, $fornecedorModel) {
    include('../app/header.php');
    if (isset($_GET['id'])) {
        $idCompra = $_GET['id'];
        $compra = $compraModel->buscarCompraPorId($idCompra);
        $fornecedores = $fornecedorModel->listarFornecedores();
        $usuarios = $usuarioModel->listarUsuarios();

        include('../view/CompraView/formAtualizarCompra.php');
    } else {
        echo "ID não informado.";
    }
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['idCompra'])) {
        $idCompra       = $_POST['idCompra'];
        $idFornecedor   = $_POST['idFornecedor'];
        $idUsuario      = $_POST['idUsuario'];
        $data           = $_POST['data'];
        $valorTotal     = $_POST['valorTotal'];
        $descricao      = $_POST['descricao'];

        if ($compraModel->atualizarCompra($idCompra, $idFornecedor, $idUsuario, $data, $valorTotal, $descricao)) {
            listarCompras($compraModel, $usuarioModel, $fornecedorModel);
        } else {
            global $conn;
            echo "Erro ao atualizar a Compra! " . mysqli_error($conn);

        }
    }
}
function excluirCompra($compraModel, $usuarioModel, $fornecedorModel){
    $idCompra = $_GET['id'];
    $resultado = $compraModel->excluirCompra($idCompra);
    if($resultado) {
        include('../app/header.php');
        listarCompras($compraModel, $usuarioModel, $fornecedorModel);
    } else {
        echo "ERRO AO EXCLUIR!";
    }
}

function buscarCompra($compraModel, $compraProdutoModel, $usuarioModel) {
    if (isset($_GET['busca'])) {
        $termo = $_GET['busca'];
        $compras  = $compraModel->buscarPorNome($termo);
        $produtos = $compraProdutoModel->listarProdutosCompra();
        $usuarios = $usuarioModel->listarUsuarios();

        include('../view/CompraController/verBuscaCompra.php');
    } else {
        echo "Nenhum termo de busca informado.";
    }
}

function adicionarProduto($compraProdutoModel) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $idProduto = $_POST['idProduto'];
            $idCompra  = $_POST['idCompra'];
            $quantidade = $_POST['quantidade'];
            $valorUnitario = $_POST['valorUnitario'];

            $resultado = $compraProdutoModel->adicionarProdutoCompra($idProduto, $idCompra, $quantidade, $valorUnitario);

            if ($resultado) {
                header("Location: ../view/CompraView/produtoCompra.php?id=$idCompra");
                exit();
            } else {
                echo "Erro ao adicionar o produto a compra! " . mysqli_error($compraProdutoModel->getConnection());
            }
    }
}

function atualizarProduto($compraProdutoModel) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        
    $idCompra   = $_POST['idCompra'];
    $idProduto  = $_POST['idProduto'];
    $quantidade = $_POST['quantidade'];

    // limpa o "R$" e formata pra ponto decimal
    $novoValor = str_replace(['R$', '.', ' '], ['', '', ''], $_POST['valorUnitario']);
    $novoValor = str_replace(',', '.', $novoValor);
    $valorUnitario = $novoValor;

    $resultado = $compraProdutoModel->atualizarProdutoCompra($idCompra, $idProduto, $quantidade, $valorUnitario);
    if ($resultado) {
        header("Location: ../view/CompraView/formAtualizarCompra.php?id=$idCompra");
        exit;
    } else {
        echo "Erro ao atualizar o produto na compra: " . mysqli_error($compraProdutoModel->getConnection());
        exit;
    }
}
}
function excluirProduto($compraProdutoModel){
    $idCompra = $_GET['idCompra'];
    $idProduto = $_GET['id'];
    $resultado = $compraProdutoModel->excluirProdutoCompra($idCompra, $idProduto);
    if ($resultado) {
        include('../app/header.php');
        echo "Produto excluído com sucesso!";
        header("Location: ../view/CompraView/produtoCompra.php?id=$idCompra");
        exit();
    } else {
        echo "Erro ao excluir o produto: " . mysqli_error($compraProdutoModel->getConnection());
        exit();
    }
}
function verCompra($compraModel) {
    include('../app/header.php');
    if (isset($_GET['id'])) {
        $idCompra = $_GET['id'];
        $compra = $compraModel->buscarCompraPorId($idCompra);
        include('../view/CompraView/verCompra.php');
    } else {
        echo "ID não informado.";
    }
}

// Determina qual ação chamar com base na URL ou método
if (isset($_GET['acao'])) {
    $acao = $_GET['acao'];

    // Chamando a ação de acordo com a URL
    if ($acao == 'cadastrar') {
        cadastrarCompra($compraModel, $usuarioModel, $fornecedorModel);
    } elseif ($acao == 'listar') {
        listarCompras($compraModel, $usuarioModel, $fornecedorModel);
    } elseif ($acao == 'atualizar') {
        atualizarCompra($compraModel, $usuarioModel, $fornecedorModel); // Se o formulário for enviado, processa a atualização
    } elseif ($acao == 'excluir') {
        excluirCompra($compraModel, $usuarioModel, $fornecedorModel );
    } elseif($acao == 'buscar') {
        buscarServico($compraModel, $compraProdutoModel, $usuarioModel);
    } elseif($acao == 'adicionarProduto'){
        adicionarProduto($compraProdutoModel);
    } elseif($acao == 'atualizarProduto'){
        atualizarProduto($compraProdutoModel);
    } elseif($acao == 'excluirProduto'){
        excluirProduto($compraProdutoModel);
    } elseif($acao == 'verCompra'){
        verCompra($compraModel);
    }
} else {
    // Caso nenhuma ação seja especificada, exibe a listagem
    include('../app/header.php');
    listarCompras($compraModel, $usuarioModel, $fornecedorModel);
}
?>