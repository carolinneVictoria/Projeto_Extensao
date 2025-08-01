<?php
include_once "../config/conexaoBD.php";
include_once "../model/Estoque.php";
include_once "../model/Fornecedor.php";
include_once "../model/Usuario.php";
include_once "../model/Produto.php";
//include_once "../model/CompraProduto.php";

$compraModel = new Estoque($conn);
$produtoModel = new Produto($conn);
//$compraProdutoModel = new CompraProduto($conn);
$fornecedorModel = new Fornecedor($conn);
$usuarioModel = new Usuario($conn);

function cadastrarCompra($compraModel) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $idFornecedor   = $_POST['idFornecedor'];
        $idUsuario      = $_POST['idUsuario'];
        $data           = $_POST['data'];
        $valorTotal     = $_POST['valorTotal'];
        $descricao      = $_POST['descricao'];

        $idCompra = $compraModel->cadastrarCompra($idFornecedor, $idUsuario, $data, $valorTotal, $descricao);

        if ($idCompra) {
            header("Location: ../view/CompraView/estoque.php");
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
function atualizarVenda($vendaModel, $vendaProdutoModel) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['idVenda'])) {
        $idVenda        = $_POST['idVenda'];
        $idUsuario      = $_POST['idUsuario'];
        $data           = $_POST['data'];
        $formaPagamento = $_POST['formaPagamento'];
        $descontoVenda  = floatval(str_replace(',', '.', str_replace('.', '', $_POST['descontoVenda'])));

        if ($vendaModel->atualizarVenda($idVenda, $idUsuario, $data, $descontoVenda, 0, $formaPagamento)) {
            $produtos = $vendaProdutoModel->listarProdutosVenda($idVenda);
            $valorProdutos = 0;
            if ($produtos) {
                while ($produto = mysqli_fetch_assoc($produtos)) {
                    $valorProdutos += $produto['quantidade'] * $produto['valorUnitario'];
                }
            }
            $valorTotal = $valorProdutos - $descontoVenda;
            $vendaModel->atualizarValorTotalVenda($idVenda, $valorTotal);
            header("Location: ../view/VendaView/vendas.php");
            exit();

        } else {
            echo "Erro ao atualizar a venda: " . mysqli_error($vendaModel->getConnection());
        }
    }
}


function excluirVenda($vendaModel){
    $idVenda = $_GET['id'];
    $resultado = $vendaModel->excluirVenda($idVenda);
    if ($resultado) {
    echo "Venda excluído com sucesso!";
    header('Location: ../view/VendaView/vendas.php');
    exit();
    } else {
    echo "Erro ao excluir a venda: " . mysqli_error($vendaModel->getConnection());
    exit();
    }
}

function buscarServico($servicoModel, $clienteModel, $usuarioModel) {
    if (isset($_GET['busca'])) {
        $termo = $_GET['busca'];
        $servicos = $servicoModel->buscarPorNome($termo);
        $clientes = $clienteModel->listarClientes();
        $usuarios = $usuarioModel->listarUsuarios();

        include('../view/ServicoView/verBuscaServico.php'); 
    } else {
        echo "Nenhum termo de busca informado.";
    }
}

function adicionarProduto($vendaProdutoModel) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $idProduto = $_POST['idProduto'];
            $idVenda = $_POST['idVenda'];
            $quantidade = $_POST['quantidade'];
            $valorUnitario = $_POST['valorUnitario'];

            $resultado = $vendaProdutoModel->adicionarProdutoVenda($idProduto, $idVenda, $quantidade, $valorUnitario);

            if ($resultado) {
                header("Location: ../view/VendaView/produtoVenda.php?id=$idVenda");
                exit();
            } else {
                echo "Erro ao adicionar o produto a venda! " . mysqli_error($vendaProdutoModel->getConnection());
            }
    }
}

function atualizarProduto($vendaProdutoModel) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        
    $idVenda  = $_POST['idVenda'];
    $idProduto  = $_POST['idProduto'];
    $quantidade = $_POST['quantidade'];

    // limpa o "R$" e formata pra ponto decimal
    $novoValor = str_replace(['R$', '.', ' '], ['', '', ''], $_POST['valorUnitario']);
    $novoValor = str_replace(',', '.', $novoValor);
    $valorUnitario = $novoValor;

    $resultado = $vendaProdutoModel->atualizarProdutoVenda($idVenda, $idProduto, $quantidade, $valorUnitario);
    if ($resultado) {
        header("Location: ../view/VendaView/formAtualizarVenda.php?id=$idVenda");
        exit;
    } else {
        echo "Erro ao atualizar o produto na venda: "
           . mysqli_error($vendaProdutoModel->getConnection());
        exit;
    }
}
}
function excluirProduto($vendaProdutoModel){
    $idVenda = $_GET['idVenda'];
    $idProduto = $_GET['id'];
    $resultado = $vendaProdutoModel->excluirProdutoVenda($idVenda, $idProduto);
    if ($resultado) {
    echo "Produto excluído com sucesso!";
    header("Location: ../view/VendaView/formAtualizarVenda.php?id=$idVenda");
    exit();
    } else {
    echo "Erro ao excluir o produto: " . mysqli_error($vendaProdutoModel->getConnection());
    exit();
    }
}


// Determina qual ação chamar com base na URL ou método
if (isset($_GET['acao'])) {
    $acao = $_GET['acao'];

    // Chamando a ação de acordo com a URL
    if ($acao == 'cadastrar') {
        cadastrarCompra($compraModel);
    } elseif ($acao == 'listar') {
        listarCompras($compraModel, $usuarioModel, $fornecedorModel);
    } elseif ($acao == 'atualizar') {
        atualizarVenda($vendaModel, $vendaProdutoModel); // Se o formulário for enviado, processa a atualização
    } elseif ($acao == 'excluir') {
        excluirVenda($vendaModel);
    } elseif($acao == 'buscar') {
        buscarVenda($vendaModel, $vendaProdutoModel, $usuarioModel);
    } elseif($acao == 'adicionarProduto'){
        adicionarProduto($vendaProdutoModel);
    } elseif($acao == 'atualizarProduto'){
        atualizarProduto($vendaProdutoModel);
    } elseif($acao == 'excluirProduto'){
        excluirProduto($vendaProdutoModel);
    }
} else {
    // Caso nenhuma ação seja especificada, exibe a listagem
    listarCompras($compraModel, $usuarioModel, $fornecedorModel);
}
?>