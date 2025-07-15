
<?php

include_once "../config/conexaoBD.php";
include_once "../model/Venda.php";
include_once "../model/Cliente.php";
include_once "../model/Usuario.php";
include_once "../model/Produto.php";
include_once "../model/VendaProduto.php";

$vendaModel = new Venda($conn);
$produtoModel = new Produto($conn);
$vendaProdutoModel = new VendaProduto($conn);
$clienteModel = new Cliente($conn);
$usuarioModel = new Usuario($conn);

function cadastrarVenda($vendaModel) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $idUsuario      = $_POST['idUsuario'];
        $data           = $_POST['data'];
        $desconto       = $_POST['descontoVenda'];
        $valorTotal     = $_POST['valorTotal'];
        $formaPagamento = $_POST['formaPagamento'];

        $idVenda = $vendaModel->cadastrarVenda($idUsuario, $data, $desconto, $valorTotal, $formaPagamento);

        if ($idVenda) {
            header("Location: ../view/VendaView/formAtualizarVenda.php?id=$idVenda");
            exit();
        } else {
            echo "Erro ao cadastrar venda!";
        }
    }
}


// Função para listar
function listarVendas($vendaModel, $usuarioModel) {
    $vendas   = $vendaModel->listarVendas();
    $usuarios = $usuarioModel->listarUsuarios();
    include('../view/VendaView/vendas.php');
}

// Função para processar a atualização
function atualizarVenda($vendaModel) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['idVenda'])) {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $idVenda      = $_POST['idServico'];
        $idUsuario      = $_POST['idUsuario'];
        $data           = $_POST['data'];
        $descontoVenda  = $_POST['descontoVenda'];
        $valorTotal     = $_POST['valorTotal'];
        $formaPagamento = $_POST['formaPagamento'];

        if ($vendaModel->atualizarVenda($idVenda, $idUsuario, $data, $descontoVenda, $valorTotal, $formaPagamento)) {
            header("Location: ../view/VendaView/vendas.php");
            exit();
        } else {
            echo "Erro ao atualizar a venda!" . mysqli_error($vendaModel->getConnection());
        }
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
function excluirProduto($servicoProdutoModel){
    $idServico = $_GET['idServico'];
    $idProduto = $_GET['id'];
    $resultado = $servicoProdutoModel->excluirProdutoServico($idServico, $idProduto);
    if ($resultado) {
    echo "Produto excluído com sucesso!";
    header("Location: ../view/ServicoView/formAtualizarServico.php?id=$idServico");
    exit();
    } else {
    echo "Erro ao excluir o produto: " . mysqli_error($servicoProdutoModel->getConnection());
    exit();
    }
}


// Determina qual ação chamar com base na URL ou método
if (isset($_GET['acao'])) {
    $acao = $_GET['acao'];

    // Chamando a ação de acordo com a URL
    if ($acao == 'cadastrar') {
        cadastrarVenda($vendaModel);
    } elseif ($acao == 'listar') {
        listarVendas($vendaModel,  $usuarioModel);
    } elseif ($acao == 'atualizar') {
        atualizarVenda($vendaModel); // Se o formulário for enviado, processa a atualização
    } elseif ($acao == 'excluir') {
        excluirVenda($vendaModel);
    } elseif($acao == 'buscar') {
        buscarServico($servicoModel, $clienteModel, $usuarioModel);
    } elseif($acao == 'adicionarProduto'){
        adicionarProduto($vendaProdutoModel);
    } elseif($acao == 'atualizarProduto'){
        atualizarProduto($servicoProdutoModel);
    } elseif($acao == 'excluirProduto'){
        excluirProduto($servicoProdutoModel);
    }
} else {
    // Caso nenhuma ação seja especificada, exibe a listagem
    listarVendas($vendaModel, $usuarioModel);
}
?>