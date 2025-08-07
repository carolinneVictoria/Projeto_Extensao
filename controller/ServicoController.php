
<?php

include_once "../config/conexaoBD.php";
include_once "../model/Servico.php";
include_once "../model/Cliente.php";
include_once "../model/Usuario.php";
include_once "../model/Produto.php";
include_once "../model/ServicoProduto.php";

$servicoModel = new Servico($conn);
$produtoModel = new Produto($conn);
$servicoProdutoModel = new ServicoProduto($conn);
$clienteModel = new Cliente($conn);
$usuarioModel = new Usuario($conn);

function cadastrarServico($servicoModel) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $idCliente      = $_POST['idCliente'];
        $idUsuario      = $_POST['idUsuario'];
        $descricao      = $_POST['descricao'];
        $dataEntrada    = $_POST['dataEntrada'];
        $entrega        = $_POST['entrega'];
        $valorTotal     = $_POST['valorTotal'];
        $maodeObra      = $_POST['maodeObra'];

        if ($servicoModel->cadastrarServico($idCliente, $idUsuario, $descricao, $dataEntrada, $entrega, $valorTotal, $maodeObra)) {
            header("Location: ../view/ServicoView/servicos.php");
            exit();
        } else {
            echo "Erro ao cadastrar serviço!";
        }
    }
}

// Função para listar
function listarServicos($servicoModel, $clienteModel, $usuarioModel) {
    $servicos = $servicoModel->listarServicos();
    $clientes = $clienteModel->listarClientes();
    $usuarios = $usuarioModel->listarUsuarios();
    include('../view/ServicoView/servicos.php');
}

// Função para processar a atualização
function atualizarServico($servicoModel, $servicoProdutoModel) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['idServico'])) {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $idServico      = $_POST['idServico'];
        $idCliente      = $_POST['idCliente'];
        $idUsuario      = $_POST['idUsuario'];
        $descricao      = $_POST['descricao'];
        $dataEntrada    = $_POST['dataEntrada'];
        $entrega        = $_POST['entrega'];
        $valorTotal     = $_POST['valorTotal'];
        $maodeObra      = $_POST['maodeObra'];

        if ($servicoModel->atualizarServico($idServico, $idCliente, $idUsuario, $descricao, $dataEntrada, $entrega, $valorTotal, $maodeObra)) {
            $produtos = $servicoProdutoModel->listarProdutosServico($idServico);
            $valorProdutos = 0;
            if ($produtos) {
                while ($produto = mysqli_fetch_assoc($produtos)) {
                    $valorProdutos += $produto['quantidade'] * $produto['valorUnitario'];
                }
            }
            $valorTotal = $valorProdutos + $maodeObra;
            $servicoModel->atualizarValorTotalServico($idServico, $valorTotal);
            header("Location: ../view/ServicoView/servicos.php");
            exit();
        } else {
            echo "Erro ao atualizar o servico!" . mysqli_error($servicoModel->getConnection());
        }
    }
}
}

function excluirServico($servicoModel){
    $idServico = $_GET['id'];
    $resultado = $servicoModel->excluirServico($idServico);
    if ($resultado) {
    echo "Serviço excluído com sucesso!";
    header('Location: ../view/ServicoView/servicos.php');
    exit();
    } else {
    echo "Erro ao excluir o serviço: " . mysqli_error($servicoModel->getConnection());
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

function adicionarProduto($servicoProdutoModel) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $idProduto = $_POST['idProduto'];
            $idServico = $_POST['idServico'];
            $quantidade = $_POST['quantidade'];
            $valorUnitario = $_POST['valorUnitario'];

            $resultado = $servicoProdutoModel->adicionarProdutoServico($idProduto, $idServico, $quantidade, $valorUnitario);

            if ($resultado) {
                header("Location: ../view/ServicoView/produtoServico.php?id=$idServico");
                exit();
            } else {
                echo "Erro ao adicionar o produto ao serviço! " . mysqli_error($servicoProdutoModel->getConnection());
            }
    }
}

function atualizarProduto($servicoProdutoModel) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        
    $idServico  = $_POST['idServico'];
    $idProduto  = $_POST['idProduto'];
    $quantidade = $_POST['quantidade'];

    // limpa o "R$" e formata pra ponto decimal
    $novoValor = str_replace(['R$', '.', ' '], ['', '', ''], $_POST['valorUnitario']);
    $novoValor = str_replace(',', '.', $novoValor);
    $valorUnitario = $novoValor;

    $resultado = $servicoProdutoModel->atualizarProdutoServico($idServico, $idProduto, $quantidade, $valorUnitario);
    if ($resultado) {
        header("Location: ../view/ServicoView/formAtualizarServico.php?id=$idServico");
        exit;
    } else {
        echo "Erro ao atualizar o produto no serviço: "
           . mysqli_error($servicoProdutoModel->getConnection());
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
        cadastrarServico($servicoModel);
    } elseif ($acao == 'listar') {
        listarServicos($servicoModel, $clienteModel, $usuarioModel);
    } elseif ($acao == 'atualizar') {
        atualizarServico($servicoModel, $servicoProdutoModel); // Se o formulário for enviado, processa a atualização
    } elseif ($acao == 'excluir') {
        excluirServico($servicoModel);
    } elseif($acao == 'buscar') {
        buscarServico($servicoModel, $clienteModel, $usuarioModel);
    } elseif($acao == 'adicionarProduto'){
        adicionarProduto($servicoProdutoModel);
    } elseif($acao == 'atualizarProduto'){
        atualizarProduto($servicoProdutoModel);
    } elseif($acao == 'excluirProduto'){
        excluirProduto($servicoProdutoModel);
    }
} else {
    // Caso nenhuma ação seja especificada, exibe a listagem
    listarServicos($servicoModel, $clienteModel, $usuarioModel);
}
?>