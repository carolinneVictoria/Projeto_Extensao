<?php
include_once "../config/conexaoBD.php";
include_once "../model/Financeiro.php";

$financeiroModel = new Financeiro($conn);

function listarContas($financeiroModel) {
    $contas = $financeiroModel->listarContas();
    include('../view/FinanceiroView/contas.php');
}

function filtrarContas($financeiroModel) {
    $mes = $_GET['mes'] ?? null;
    $ano = $_GET['ano'] ?? null;

    $contas = $financeiroModel->listarContasPorMesEAno($mes, $ano);
    include('../view/FinanceiroView/contas.php');
}

function cadastrarConta($financeiroModel) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $descricao      = $_POST['descricao'];
        $valorTotal     = $_POST['valorTotal'];
        $dataVencimento = $_POST['dataVencimento'];
        $status         = $_POST['status'];

        if ($financeiroModel->cadastrarConta($descricao, $valorTotal, $dataVencimento, $status)){
            header("Location: ../view/FinanceiroView/contas.php");
            exit();
        } else {
            echo "ERRO AO CADASTRAR CONTA.";
        }
    }
}

function atualizarConta($financeiroModel) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['idConta'])) {
        $idConta           = $_POST['idConta'];
        $descricao         = $_POST['descricao'];
        $valorTotal        = $_POST['valorTotal'];
        $dataVencimento    = $_POST['dataVencimento'];
        $status            = $_POST['status'];

        if ($financeiroModel->atualizarConta($idConta, $descricao, $valorTotal, $dataVencimento, $status)) {
            header("Location: ../view/FinanceiroView/contas.php");
            exit();
        } else {
            global $conn;
            echo "Erro ao atualizar a conta! " . mysqli_error($conn);
        }
    }
}

function excluirConta($financeiroModel) {
    $idConta = $_GET['id'];
    $resultado = $financeiroModel->excluirConta($idConta);
    if($resultado) {
        header('Location: ../view/FinanceiroView/contas.php');
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
    }
} else {
    listarContas($financeiroModel);
}
?>
