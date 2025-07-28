<?php
include_once "../config/conexaoBD.php";
include_once "../model/Financeiro.php";

$financeiroModel = new Financeiro($conn);

function listarContas($financeiroModel) {
    $contas = $financeiroModel->listarContas();
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



if (isset($_GET['acao'])) {
    $acao = $_GET['acao'];

    // Chamando a ação de acordo com a URL
    if ($acao == 'cadastrar') {
        cadastrarConta($financeiroModel);
    } elseif ($acao == 'listar') {
        listarContas($financeiroModel);
    } elseif ($acao == 'atualizar') {
        atualizarConta($financeiroModel); // Se o formulário for enviado, processa a atualização
    } elseif ($acao == 'excluir') {
        excluirConta($financeiroModel);
    } elseif($acao == 'buscar') {
        buscarConta($financeiroModel);
    }
} else {
    // Caso nenhuma ação seja especificada, exibe a listagem
    listarContas($financeiroModel);
}

?>