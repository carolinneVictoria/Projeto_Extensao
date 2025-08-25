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
            listarServicos($servicoModel);
            exit();
        } else {
            echo "Erro ao cadastrar serviço!";
        }
    }
}
function listarServicos($servicoModel) {
    $paginaAtual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
    $limite = 5;
    $offset = ($paginaAtual - 1) * $limite;

    $servicos = $servicoModel->listarServicosPaginados($limite, $offset);

    // Conta total
    $totalServicos = $servicoModel->contarServicos();
    $totalPaginas = ceil($totalServicos / $limite);

    include('../view/ServicoView/servicos.php');
}
function listarServicosEntregues($servicoModel) {
    $paginaAtual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
    $limite = 5;
    $offset = ($paginaAtual - 1) * $limite;

    $servicos = $servicoModel->listarServicosPaginadosEntregues($limite, $offset);
    
    // Conta total
    $totalServicos = $servicoModel->contarServicosEntregues();
    $totalPaginas = ceil($totalServicos / $limite);

    include('../view/ServicoView/servicos.php');
}
function listarServicosPendentes($servicoModel) {
    $paginaAtual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
    $limite = 5;
    $offset = ($paginaAtual - 1) * $limite;

    $servicos = $servicoModel->listarServicosPaginadosPendentes($limite, $offset);
    
    // Conta total
    $totalServicos = $servicoModel->contarServicosPendentes();
    $totalPaginas = ceil($totalServicos / $limite);

    include('../view/ServicoView/servicos.php');
}
function atualizarServico($servicoModel, $servicoProdutoModel) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['idServico'])) {
        $idServico    = $_POST['idServico'];
        $idCliente    = $_POST['idCliente'];
        $idUsuario    = $_POST['idUsuario'];
        $descricao    = $_POST['descricao'];
        $dataEntrada  = $_POST['dataEntrada'];
        $entrega      = $_POST['entrega'];

        $maodeObra = str_replace('R$', '', $_POST['maodeObra']);
        $maodeObra = str_replace('.', '', $maodeObra);
        $maodeObra = str_replace(',', '.', $maodeObra);
        $maodeObra = (float)$maodeObra;

        $valorTotalProdutos = 0;
        $produtos = $servicoProdutoModel->listarProdutosServico($idServico);
        if ($produtos) {
            while ($produto = mysqli_fetch_assoc($produtos)) {
                $valorTotalProdutos += $produto['quantidade'] * $produto['valorUnitario'];
            }
        }
        $valorTotal = $valorTotalProdutos + $maodeObra;

        if ($servicoModel->atualizarServico($idServico, $idCliente, $idUsuario, $descricao, $dataEntrada, $entrega, $valorTotal, $maodeObra)
        ) {
            listarServicos($servicoModel);
            exit();
        } else {
            echo "Erro ao cadastrar serviço!";
        }
    }
}
function excluirServico($servicoModel){
    $idServico = $_GET['id'];
    $resultado = $servicoModel->excluirServico($idServico);
    if ($resultado) {
    listarServicos($servicoModel);
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
                header("Location: ../controller/ServicoController.php?acao=formAtualizar&id=$idServico");
                exit();
            } else {
                echo "Erro ao adicionar o produto ao servico! " . mysqli_error($servicoProdutoModel->getConnection());
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
        header("Location: ../controller/ServicoController.php?acao=formAtualizar&id=$idServico");
        exit();
    } else {
        echo "Erro ao atualizar o produto no servico! " . mysqli_error($servicoProdutoModel->getConnection());
    }
}
}
function excluirProduto($servicoProdutoModel){
    $idServico = $_GET['idServico'];
    $idProduto = $_GET['id'];
    $resultado = $servicoProdutoModel->excluirProdutoServico($idServico, $idProduto);
    if ($resultado) {
        header("Location: ../controller/ServicoController.php?acao=formAtualizar&id=$idServico");
        exit();
    } else {
        echo "Erro ao excluir o produto do servico! " . mysqli_error($servicoProdutoModel->getConnection());
    }
}
function verServico($servicoModel, $servicoProdutoModel){
    if (isset($_GET['id'])) {
        $idServico = $_GET['id'];
        $servico = $servicoModel->buscarServicoPorId($idServico);

        if ($servico) {
            $valorProdutos = 0;
            $produtosAssociados = $servicoProdutoModel->listarProdutosServico($idServico);
            $maoDeObra = $servico['maodeObra'];
            $valorTotal = $servico['valorTotal'];
            
            include_once '../view/ServicoView/verServico.php';
        } else {
            header('Location: ../view/ServicoView/servicos.php&erro=naoencontrado');
            exit();
        }
    } else {
        header('Location: ../view/ServicoView/servicos.php&erro=naoencontrado');
        exit();
    }
}
function formCadastro($servicoModel, $usuarioModel, $clienteModel){
    $usuarios = $usuarioModel->listarUsuarios();
    $clientes = $clienteModel->listarClientes();
    include_once '../view/ServicoView/formServico.php';
}
function formAtualizar($servicoModel, $usuarioModel, $clienteModel, $servicoProdutoModel){
    if (isset($_GET['id'])) {
        $idServico = $_GET['id'];
        $servico =  $servicoModel->buscarServicoPorId($idServico);
        $usuarios = $usuarioModel->buscarUsuarioPorId($servico['idUsuario']);
        $clientes = $clienteModel->buscarClientePorId($servico['idUsuario']);

        if ($servico) {
            $valorTotal = 0;
            $produtosAssociados = $servicoProdutoModel->listarProdutosServico($idServico);
            $maodeObra = $servico['maodeObra'];

            if ($produtosAssociados) {
                while ($registro = mysqli_fetch_assoc($produtosAssociados)) {
                    $valorTotal += ($registro['quantidade'] * $registro['valorUnitario']);
                    
                }
                if (!$servicoModel->atualizarValorTotalServico($idServico, $valorTotal)) {
                    echo "Erro ao atualizar o valor total no banco de dados!";
                    exit();
                }
            } else {
                $produtosAssociados = [];
            }
            include_once '../view/ServicoView/formAtualizarServico.php';
        } else {
            header('Location: ../view/ServicoView/formAtualizarServico.php&erro=naoencontrado');
            exit();
        }
    } else {
        header('Location: ../view/ServicoView/formAtualizarServico.php&erro=naoencontrado');
        exit();
    }
}
function formProdutoServico($servicoModel, $servicoProdutoModel, $produtoModel){
    if (isset($_GET['id'])) {
        $idServico = $_GET['id'];

        if (!is_numeric($idServico) || $idServico <= 0) {
            echo "ID de servico inválido.";
            exit();
        }

        $servico = $servicoModel->buscarServicoPorId($idServico);
        
        if ($servico === null) {
            echo "Servico não encontrado.";
            exit();
            }
    } else {
        echo "ID do servico não foi fornecido.";
        exit();
    }
    $produtos = $produtoModel->listarProdutos();
    include_once '../view/ServicoView/produtoServico.php';
}
function formAtualizarProduto($servicoModel, $servicoProdutoModel, $produtoModel){
    // Verifica se os IDs foram passados corretamente
    if (!isset($_GET['idProduto'], $_GET['idServico'])) {
        echo "ID do servico ou do produto não informado!";
        exit;
    }

    $idServico = (int) $_GET['idServico'];
    $idProduto = (int) $_GET['idProduto'];
    // Busca os dados necessários
    $servico  = $servicoModel->buscarServicoPorId($idServico);
    $produto  = $produtoModel->buscarProdutoPorId($idProduto);
    $registro = $servicoProdutoModel->buscarProdutoServico($idServico, $idProduto);
    $produtosAssociados = $servicoProdutoModel->listarProdutosServico($idServico);
    if (!$registro) {
        echo "Registro de produto no serviço não encontrado!";
        exit;
    }
    $produtos = $produtoModel->listarProdutos();
    include_once '../view/ServicoView/atualizarProdutoServico.php';
}

// Determina qual ação chamar com base na URL ou método
if (isset($_GET['acao'])) {
    $acao = $_GET['acao'];

    // Chamando a ação de acordo com a URL
    if ($acao == 'cadastrar') {
        cadastrarServico($servicoModel);
    } elseif ($acao == 'listar') {
        listarServicos($servicoModel);
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
    } elseif($acao == 'listarPendentes'){
        listarServicosPendentes($servicoModel);
    } elseif($acao == 'listarEntregues'){
        listarServicosEntregues($servicoModel);
    } elseif($acao == 'ver'){
        verServico($servicoModel, $servicoProdutoModel);
    } elseif($acao == 'formCadastro'){
        formCadastro($servicoModel, $usuarioModel, $clienteModel);
    } elseif($acao == 'formAtualizar'){
        formAtualizar($servicoModel, $usuarioModel, $clienteModel, $servicoProdutoModel);
    } elseif($acao == 'formProdutoServico'){
        formProdutoServico($servicoModel, $servicoProdutoModel, $produtoModel);
    } elseif($acao == 'formAtualizarProduto'){
        formAtualizarProduto($servicoModel, $servicoProdutoModel, $produtoModel);
    }
} else {
    // Caso nenhuma ação seja especificada, exibe a listagem
    listarServicos($servicoModel);
}
?>