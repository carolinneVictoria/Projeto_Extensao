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
        $descontoVenda  = $_POST['descontoVenda'];
        $valorTotal     = $_POST['valorTotal'];
        $formaPagamento = $_POST['formaPagamento'];

        $idVenda = $vendaModel->cadastrarVenda($idUsuario, $data, $descontoVenda, $valorTotal, $formaPagamento);

        if ($idVenda) {
            header("Location: ../controller/VendaController.php?acao=formAtualizar&id=$idVenda");
            exit();
        } else {
            echo "Erro ao cadastrar venda!";
        }
    }
}

// Função para listar
function listarVendas($vendaModel, $usuarioModel) {
    $paginaAtual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
    $limite = 5; // vendas por página
    $offset = ($paginaAtual - 1) * $limite;

    // Busca vendas
    $vendas = $vendaModel->listarVendasPaginadas($limite, $offset);

    // Conta total
    $totalVendas = $vendaModel->contarVendas();
    $totalPaginas = ceil($totalVendas / $limite);
    include('../view/VendaView/vendas.php');
}

/// Função para processar a atualização
function atualizarVenda($vendaModel, $vendaProdutoModel, $usuarioModel) {
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
            listarVendas($vendaModel, $usuarioModel);
            exit();

        } else {
            echo "Erro ao atualizar a venda: " . mysqli_error($vendaModel->getConnection());
        }
    }
}

function excluirVenda($vendaModel, $usuarioModel){
    $idVenda = $_GET['id'];
    $resultado = $vendaModel->excluirVenda($idVenda);
    if ($resultado) {
    listarVendas($vendaModel, $usuarioModel);
    exit();
    } else {
    echo "Erro ao excluir a venda: " . mysqli_error($vendaModel->getConnection());
    exit();
    }
}
function buscarVenda($vendaModel, $vendaProdutoModel, $usuarioModel) {
    if (isset($_GET['busca'])) {
        $paginaAtual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
        $limite = 5; // vendas por página
        $offset = ($paginaAtual - 1) * $limite;
        // Conta total
        $totalVendas = $vendaModel->contarVendas();
        $totalPaginas = ceil($totalVendas / $limite);
        $termo = $_GET['busca'];
        $vendas   = $vendaModel->buscarPorNome($termo, $limite, $offset);
        $usuarios = $usuarioModel->listarUsuarios();

        include('../view/VendaView/verBuscaVenda.php');
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
                //$produtoModel->reduzirEstoque($idProduto, $quantidade);
                header("Location: ../controller/VendaController.php?acao=formProdutoVenda&id=$idVenda");
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
        header("Location: ../controller/VendaController.php?acao=formAtualizar&id=$idVenda");
        exit;
    } else {
        echo "Erro ao atualizar o produto na venda: " . mysqli_error($vendaProdutoModel->getConnection());
        header("Location: ../controller/VendaController.php?acao=formAtualizar&id=$idVenda");
        exit;
    }
}
}

function excluirProduto($vendaProdutoModel){
    $idVenda = $_GET['idVenda'];
    $idProduto = $_GET['id'];
    $resultado = $vendaProdutoModel->excluirProdutoVenda($idVenda, $idProduto);
    if ($resultado) {
        header("Location: ../controller/VendaController.php?acao=formAtualizar&id=$idVenda");
        exit();
    } else {
        echo "Erro ao excluir o produto: " . mysqli_error($vendaProdutoModel->getConnection());
        header("Location: ../controller/VendaController.php?acao=formAtualizar&id=$idVenda");
        exit();
    }
}

function verVenda($vendaModel, $vendaProdutoModel){
    if (isset($_GET['id'])) {
        $idVenda = $_GET['id'];
        $venda = $vendaModel->buscarVendaPorId($idVenda);

        if ($venda) {
            $valorProdutos = 0;
            $produtosAssociados = $vendaProdutoModel->listarProdutosVenda($idVenda);
            $descontoTotal = $venda['descontoVenda'];
            
            include_once '../view/VendaView/verVenda.php';
        } else {
            header('Location: ../view/VendaView/vendas.php&erro=naoencontrado');
            exit();
        }
    } else {
        header('Location: ../view/VendaView/vendas.php&erro=naoencontrado');
        exit();
    }
}

function formAtualizar($vendaModel, $vendaProdutoModel, $usuarioModel){
    if (isset($_GET['id'])) {
        $idVenda = $_GET['id'];
        $venda = $vendaModel->buscarVendaPorId($idVenda);
        $usuarios = $usuarioModel->buscarUsuarioPorId($venda['idUsuario']);

        if ($venda) {
            $valorTotal = 0;
            $produtosAssociados = $vendaProdutoModel->listarProdutosVenda($idVenda);
            $descontoTotal = $venda['descontoVenda'];

            if ($produtosAssociados) {
                while ($registro = mysqli_fetch_assoc($produtosAssociados)) {
                    $valorTotal += ($registro['quantidade'] * $registro['valorUnitario']);
                }
                if (!$vendaModel->atualizarValorTotalVenda($idVenda, $valorTotal)) {
                    echo "Erro ao atualizar o valor total no banco de dados!";
                    exit();
                }
            } else {
                $produtosAssociados = [];
            }
            include_once '../view/VendaView/formAtualizarVenda.php';
        } else {
            header('Location: ../view/VendaView/vendas.php&erro=naoencontrado');
            exit();
        }
    } else {
        header('Location: ../view/VendaView/vendas.php&erro=naoencontrado');
        exit();
    }
}

function formVenda($vendaModel, $usuarioModel){
    $usuarios = $usuarioModel->listarUsuarios();
    include_once '../view/VendaView/formVenda.php';
}

function formProdutoVenda($vendaModel, $vendaProdutoModel, $produtoModel){
    if (isset($_GET['id'])) {
        $idVenda = $_GET['id'];

        // Verifica se o idVenda é um valor válido (um número positivo)
        if (!is_numeric($idVenda) || $idVenda <= 0) {
            echo "ID de venda inválido.";
            exit();
        }

        // Buscando informações da venda
        $venda = $vendaModel->buscarVendaPorId($idVenda);
        
        // Verifica se o serviço foi encontrado
        if ($venda === null) {
            echo "Venda não encontrado.";
            exit();
            }
    } else {
        echo "ID da venda não foi fornecido.";
        exit();
    }
    $produtos = $produtoModel->listarProdutos();
    include_once '../view/VendaView/produtoVenda.php';
}

function formAtualizarProduto($vendaModel, $vendaProdutoModel, $produtoModel){
    // Verifica se os IDs foram passados corretamente
    if (!isset($_GET['idProduto'], $_GET['idVenda'])) {
        echo "ID da venda ou do produto não informado!";
        exit;
    }

    $idVenda = (int) $_GET['idVenda'];
    $idProduto = (int) $_GET['idProduto'];
    // Busca os dados necessários
    $venda  = $vendaModel->buscarVendaPorId($idVenda);
    $produto  = $produtoModel->buscarProdutoPorId($idProduto);
    $registro = $vendaProdutoModel->buscarProdutoVenda($idVenda, $idProduto);
    $produtosAssociados = $vendaProdutoModel->listarProdutosVenda($idVenda);
    if (!$registro) {
        echo "Registro de produto na venda não encontrado!";
        exit;
    }
    $produtos = $produtoModel->listarProdutos();
    include_once '../view/VendaView/atualizarProdutoVenda.php';
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
        atualizarVenda($vendaModel, $vendaProdutoModel, $usuarioModel); // Se o formulário for enviado, processa a atualização
    } elseif ($acao == 'excluir') {
        excluirVenda($vendaModel, $usuarioModel);
    } elseif($acao == 'buscar') {
        buscarVenda($vendaModel, $vendaProdutoModel, $usuarioModel);
    } elseif($acao == 'adicionarProduto'){
        adicionarProduto($vendaProdutoModel, $produtoModel);
    } elseif($acao == 'atualizarProduto'){
        atualizarProduto($vendaProdutoModel);
    } elseif($acao == 'excluirProduto'){
        excluirProduto($vendaProdutoModel);
    } elseif($acao == 'ver'){
        verVenda($vendaModel, $vendaProdutoModel);
    } elseif($acao == 'formCadastrar'){
        formVenda($vendaModel, $usuarioModel);
    } elseif($acao == 'formAtualizar'){
        formAtualizar($vendaModel, $vendaProdutoModel, $usuarioModel);
    } elseif($acao == 'formProdutoVenda'){
        formProdutoVenda($vendaModel, $vendaProdutoModel, $produtoModel);
    } elseif($acao == 'formAtualizarProduto'){
        formAtualizarProduto($vendaModel, $vendaProdutoModel, $produtoModel);
    }
} else {
    // Caso nenhuma ação seja especificada, exibe a listagem
    listarVendas($vendaModel, $usuarioModel);
}
?>