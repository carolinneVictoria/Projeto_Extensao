<?php
include_once "../config/conexaoBD.php";
include_once "../model/Financeiro.php";

$financeiroModel = new Financeiro($conn);

function listarContas($financeiroModel) {
    $contas = $financeiroModel->listarContas();
    include('../view/FinanceiroView/contas.php');
    include ('../../app/footer.php');
}

function filtrarContas($financeiroModel) {
    include('../app/header.php');
    $mes = isset($_GET['mes']) && $_GET['mes'] !== '' ? (int)$_GET['mes'] : null;
    $ano = isset($_GET['ano']) && $_GET['ano'] !== '' ? (int)$_GET['ano'] : null;

    $contas = $financeiroModel->listarContasPorMesEAno($mes, $ano);
    include('../view/FinanceiroView/contas.php');
}


function cadastrarConta($financeiroModel) {
    include('../app/header.php');
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
    include('../app/header.php');
    if (isset($_GET['id'])) {
        $idConta = $_GET['id'];
        $conta = $financeiroModel->buscarContaPorId($idConta);
        include('../view/FinanceiroView/formAtualizarConta.php');
    } else {
        echo "ID não informado.";
    }

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
    include('../app/header.php');
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
        include('../app/header.php');
        listarContas($financeiroModel);
    } else {
        echo "ERRO AO EXCLUIR!";
    }
}

function buscarConta($financeiroModel) {
    if (isset($_GET['busca'])) {
        $termo = $_GET['busca'];
        $fornecedores = $financeiroModel->buscarPorNome($termo);
        include('../view/FinanceiroView/verBuscaConta.php');
    } else {
        echo "NENHUM TERMO DE BUSCA INFORMADO.";
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
    } elseif ($acao == 'verConta') {
    verConta($financeiroModel);
}

} else {
    include('../app/header.php');
    listarContas($financeiroModel);
}
?>
