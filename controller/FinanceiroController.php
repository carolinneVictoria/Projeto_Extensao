<?php
include_once "../config/conexaoBD.php";
include_once "../model/Financeiro.php";

$financeiroModel = new Financeiro($conn);
function listarContas($financeiroModel) {
    $paginaAtual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
    $limite = 5;
    $offset = ($paginaAtual - 1) * $limite;

    $contas = $financeiroModel->listarContasPaginadas($limite, $offset);

    $totalContas = $financeiroModel->contarContas();
    $totalPaginas = ceil($totalContas / $limite);
    include('../view/FinanceiroView/contas.php');
    
}
function listarContasPagas($financeiroModel) {
    $paginaAtual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
    $limite = 5;
    $offset = ($paginaAtual - 1) * $limite;

    $contas = $financeiroModel->listarContasPaginadasPagas($limite, $offset);

    $totalContas = $financeiroModel->contarContas();
    $totalPaginas = ceil($totalContas / $limite);
    include('../view/FinanceiroView/contasPagas.php');
    
}
function listarContasPendentes($financeiroModel) {
    $paginaAtual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
    $limite = 5;
    $offset = ($paginaAtual - 1) * $limite;

    $contas = $financeiroModel->listarContasPaginadasPendentes($limite, $offset);

    $totalContas = $financeiroModel->contarContas();
    $totalPaginas = ceil($totalContas / $limite);
    include('../view/FinanceiroView/contasPendentes.php');
    
}
function filtrarContas($financeiroModel) {
    $mes = isset($_GET['mes']) && $_GET['mes'] !== '' ? (int)$_GET['mes'] : null;
    $ano = isset($_GET['ano']) && $_GET['ano'] !== '' ? (int)$_GET['ano'] : null;

    $contas = $financeiroModel->listarContasPorMesEAno($mes, $ano);
    include('../view/FinanceiroView/verFiltroContas.php');
}
function cadastrarConta($financeiroModel) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $descricao      = $_POST['descricao'];
        $valorTotal     = $_POST['valorTotal'];
        $dataVencimento = $_POST['dataVencimento'];
        $status         = $_POST['status'];

        if ($financeiroModel->cadastrarConta($descricao, $valorTotal, $dataVencimento, $status)){
            listarContas($financeiroModel);
            return;
        } else {
            echo "ERRO AO CADASTRAR CONTA.";
        }
    }
}
function atualizarConta($financeiroModel) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['idConta'])) {
        $idConta           = $_POST['idConta'];
        $descricao         = $_POST['descricao'];
        $valorTotal        = $_POST['valorTotal'];
        $dataVencimento    = $_POST['dataVencimento'];
        $status            = $_POST['status'];

        if ($financeiroModel->atualizarConta($idConta, $descricao, $valorTotal, $dataVencimento, $status)) {
            listarContas($financeiroModel);
            exit();
        } else {
            global $conn;
            echo "Erro ao atualizar a conta! " . mysqli_error($conn);
        }
    }

    include ('../../app/footer.php');
}
function verConta($financeiroModel) {
    if (isset($_GET['id'])) {
        $idConta = $_GET['id'];
        $conta = $financeiroModel->buscarContaPorId($idConta);
        include('../view/FinanceiroView/verConta.php');
    } else {
        echo "ID não informado.";
    }
}
function excluirConta($financeiroModel) {
    $idConta = $_GET['id'];
    $resultado = $financeiroModel->excluirConta($idConta);
    if($resultado) {
        listarContas($financeiroModel);
    } else {
        echo "ERRO AO EXCLUIR!";
    }
}
function buscarConta($financeiroModel) {
    if (isset($_GET['busca'])) {
        $termo = $_GET['busca'];
        $contas = $financeiroModel->buscarPorNome($termo);
        include('../view/FinanceiroView/verBuscaConta.php');
    } else {
        echo "NENHUM TERMO DE BUSCA INFORMADO.";
    }
}
function formAtualizarConta($financeiroModel){
    if (isset($_GET['id'])) {
        $idConta = $_GET['id'];
        $conta = $financeiroModel->buscarContaPorId($idConta);

        if ($conta) {
            include_once '../view/FinanceiroView/formAtualizarConta.php';
        } else {
            header('Location: ../view/FinanceiroView/contas.php&erro=naoencontrado');
            exit();
        }
    } else {
        header('Location: ../view/FinanceiroView/contas.php&erro=naoencontrado');
        exit();
    }
}
// Controle das rotas (ações)
if (isset($_GET['acao'])) {
    $acao = $_GET['acao'];

    if ($acao == 'cadastrar') {
        cadastrarConta($financeiroModel);
    } elseif ($acao == 'listar') {
        listarContas($financeiroModel);
    } elseif ($acao == 'atualizar') {
        atualizarConta($financeiroModel);
    } elseif ($acao == 'excluir') {
        excluirConta($financeiroModel);
    } elseif ($acao == 'buscar') {
        buscarConta($financeiroModel);
    } elseif ($acao == 'filtrar') {
        filtrarContas($financeiroModel);
    } elseif ($acao == 'ver') {
        verConta($financeiroModel);
    } elseif ($acao == 'listarPagos') {
        listarContasPagas($financeiroModel);
    } elseif ($acao == 'listarPendentes') {
        listarContasPendentes($financeiroModel);
    } elseif ($acao == 'formCadastrar') {
        include_once "../view/FinanceiroView/formConta.php";
    } elseif ($acao == 'formAtualizar') {
        formAtualizarConta($financeiroModel);
    }
else {
    listarContas($financeiroModel);
}
}
?>
