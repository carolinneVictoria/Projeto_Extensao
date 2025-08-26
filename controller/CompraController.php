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
            listarCompras($compraModel);
            exit();
        } else {
            echo "Erro ao cadastrar compra!";
        }
    }
}
function listarCompras($compraModel) {
    $paginaAtual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
    $limite = 5;
    $offset = ($paginaAtual - 1) * $limite;

    $compras = $compraModel->listarComprasPaginadas($limite, $offset);

    $totalCompras = $compraModel->contarCompras();
    $totalPaginas = ceil($totalCompras / $limite);
    include('../view/CompraView/estoque.php');
}
function atualizarCompra($compraModel, $usuarioModel, $fornecedorModel) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['idCompra'])) {
        $idCompra       = $_POST['idCompra'];
        $idFornecedor   = $_POST['idFornecedor'];
        $idUsuario      = $_POST['idUsuario'];
        $data           = $_POST['data'];
        $valorTotal     = $_POST['valorTotal'];
        $descricao      = $_POST['descricao'];

        if ($compraModel->atualizarCompra($idCompra, $idFornecedor, $idUsuario, $data, $valorTotal, $descricao)) {
            listarCompras($compraModel);
        } else {
            global $conn;
            echo "Erro ao atualizar a Compra! " . mysqli_error($conn);

        }
    }
}
function excluirCompra($compraModel){
    $idCompra = $_GET['id'];
    $resultado = $compraModel->excluirCompra($idCompra);
    if($resultado) {
        listarCompras($compraModel);
    } else {
        echo "ERRO AO EXCLUIR!";
    }
}
function buscarCompra($compraModel) {
    if (isset($_GET['busca'])) {
        $termo = $_GET['busca'];
        $compras  = $compraModel->buscarPorNome($termo);

        include('../view/CompraView/verBuscaCompra.php');
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
                header("Location: ../controller/CompraController.php?acao=formProdutoCompra&id=$idCompra");
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
        header("Location: ../controller/CompraController.php?acao=formAtualizar&id=$idCompra");
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
        header("Location: ../controller/CompraController.php?acao=formAtualizar&id=$idCompra");
        exit();
    } else {
        echo "Erro ao excluir o produto: " . mysqli_error($compraProdutoModel->getConnection());
        exit();
    }
}
function verCompra($compraModel) {
    if (isset($_GET['id'])) {
        $idCompra = $_GET['id'];
        $compra = $compraModel->buscarCompraPorId($idCompra);
        include('../view/CompraView/verCompra.php');
    } else {
        header('Location: ../view/CompraView/compras.php&erro=naoencontrado');
        exit();
    }
}
function formAtualizar($compraModel, $compraProdutoModel, $usuarioModel){
    if (isset($_GET['id'])) {
        $idCompra = $_GET['id'];
        $compra = $compraModel->buscarCompraPorId($idCompra);
        $usuarios = $usuarioModel->buscarUsuarioPorId($compra['idUsuario']);

        if ($compra) {
            $valorTotal = 0;
            $produtosAssociados = $compraProdutoModel->listarProdutosCompra($idCompra);

            if ($produtosAssociados) {
                while ($registro = mysqli_fetch_assoc($produtosAssociados)) {
                    $valorTotal += ($registro['quantidade'] * $registro['valorUnitario']);
                }
            } else {
                $produtosAssociados = [];
            }
            include_once '../view/CompraView/formAtualizarCompra.php';
        } else {
            header('Location: ../view/CompraView/compras.php&erro=naoencontrado');
            exit();
        }
    } else {
        header('Location: ../view/CompraView/compras.php&erro=naoencontrado');
        exit();
    }
}
function formCompra($compraModel, $usuarioModel, $fornecedorModel){
    $usuarios = $usuarioModel->listarUsuarios();
    $fornecedores = $fornecedorModel->listarFornecedores();
    include_once '../view/CompraView/formCompra.php';
}
function formProdutoCompra($compraModel, $compraProdutoModel, $produtoModel){
    if (isset($_GET['id'])) {
        $idCompra = $_GET['id'];

        if (!is_numeric($idCompra) || $idCompra <= 0) {
            echo "ID de compra inválido.";
            exit();
        }
        $compra = $compraModel->buscarCompraPorId($idCompra);

        if ($compra === null) {
            echo "Compra não encontrado.";
            exit();
            }
    } else {
        echo "ID da compra não foi fornecido.";
        exit();
    }
    $produtos = $produtoModel->listarProdutos();
    include_once '../view/CompraView/produtoCompra.php';
}
function formAtualizarProduto($compraModel, $compraProdutoModel, $produtoModel){
    if (!isset($_GET['idProduto'], $_GET['idCompra'])) {
        echo "ID da compra ou do produto não informado!";
        exit;
    }

    $idCompra = (int) $_GET['idCompra'];
    $idProduto = (int) $_GET['idProduto'];

    $compra  = $compraModel->buscarCompraPorId($idCompra);
    $produto  = $produtoModel->buscarProdutoPorId($idProduto);
    $registro = $compraProdutoModel->buscarProdutoCompra($idCompra, $idProduto);
    $produtosAssociados = $compraProdutoModel->listarProdutosCompra($idCompra);
    if (!$registro) {
        echo "Registro de produto na compra não encontrado!";
        exit;
    }
    $produtos = $produtoModel->listarProdutos();
    include_once '../view/CompraView/atualizarProdutoCompra.php';
}

// Determina qual ação chamar com base na URL ou método
if (isset($_GET['acao'])) {
    $acao = $_GET['acao'];

    // Chamando a ação de acordo com a URL
    if ($acao == 'cadastrar') {
        cadastrarCompra($compraModel, $usuarioModel, $fornecedorModel);
    } elseif ($acao == 'listar') {
        listarCompras($compraModel);
    } elseif ($acao == 'atualizar') {
        atualizarCompra($compraModel, $usuarioModel, $fornecedorModel); // Se o formulário for enviado, processa a atualização
    } elseif ($acao == 'excluir') {
        excluirCompra($compraModel);
    } elseif($acao == 'buscar') {
        buscarCompra($compraModel);
    } elseif($acao == 'adicionarProduto'){
        adicionarProduto($compraProdutoModel);
    } elseif($acao == 'atualizarProduto'){
        atualizarProduto($compraProdutoModel);
    } elseif($acao == 'excluirProduto'){
        excluirProduto($compraProdutoModel);
    } elseif($acao == 'ver'){
        verCompra($compraModel);
    } elseif($acao == 'formCadastrar'){ //a partir daqui
        formCompra($compraModel, $usuarioModel, $fornecedorModel);
    } elseif($acao == 'formAtualizar'){
        formAtualizar($compraModel, $compraProdutoModel, $usuarioModel);
    } elseif($acao == 'formProdutoCompra'){
        formProdutoCompra($compraModel, $compraProdutoModel, $produtoModel);
    } elseif($acao == 'formAtualizarProduto'){
        formAtualizarProduto($compraModel, $compraProdutoModel, $produtoModel);
    }
} else {
    // Caso nenhuma ação seja especificada, exibe a listagem
    listarCompras($compraModel);
}
?>