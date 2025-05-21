<?php
include_once "../config/conexaoBD.php";
include_once "../model/Fornecedor.php";

$fornecedorModel = new Fornecedor($conn);

function listarFornecedores($fornecedorModel) {
    $fornecedores = $fornecedorModel->listarFornecedores();
    include('../view/FornecedorView/fornecedores.php');
}

function cadastrarFornecedor($fornecedorModel) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $telefone       = $_POST['telefone'];
        $cnpj           = $_POST['cnpj'];
        $razaoSocial    = $_POST['razaoSocial'];
        $endereco       = $_POST['endereco'];

        if ($fornecedorModel->cadastrarFornecedor($telefone, $cnpj, $razaoSocial, $endereco)){
            header("Location: ../view/FornecedorView/fornecedores.php");
            exit();
        } else {
            echo "ERRO AO CADASTRAR Fornecedor.";
        }
    }
}

function atualizarFornecedor($fornecedorModel) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['idFornecedor'])) {
        $idFornecedor   = $_POST['idFornecedor'];
        $telefone       = $_POST['telefone'];
        $cnpj           = $_POST['cnpj'];
        $razaoSocial    = $_POST['razaoSocial'];
        $endereco       = $_POST['endereco'];

        if ($fornecedorModel->atualizarFornecedor($idFornecedor, $telefone, $cnpj, $razaoSocial, $endereco)) {
            header("Location: ../view/FornecedorView/fornecedores.php");
            exit();
        } else {
           global $conn;
           echo "Erro ao atualizar o fornecedor! " . mysqli_error($conn);

        }
    }
}

function excluirFornecedor($fornecedorModel) {
    $idFornecedor = $_GET['id'];
    $resultado = $fornecedorModel->excluirFornecedor($idFornecedor);
    if($resultado) {
        header('Location: ../view/FornecedorView/fornecedores.php');
    } else {
        echo "ERRO AO EXCLUIR!";
    }
}

function buscarFornecedor($fornecedorModel) {
    if (isset($_GET['busca'])) {
            $termo = $_GET['busca'];
            $fornecedores = $fornecedorModel->buscarPorNome($termo);
            include('../view/FornecedorView/verBuscaFornecedor.php');
    } else {
        echo "NENHUM TERMO DE BUSCA INFORMADO.";
    }
}

if (isset($_GET['acao'])) {
    $acao = $_GET['acao'];

    // Chamando a ação de acordo com a URL
    if ($acao == 'cadastrar') {
        cadastrarFornecedor($fornecedorModel);
    } elseif ($acao == 'listar') {
        listarFornecedores($fornecedorModel);
    } elseif ($acao == 'atualizar') {
        atualizarFornecedor($fornecedorModel); // Se o formulário for enviado, processa a atualização
    } elseif ($acao == 'excluir') {
        excluirFornecedor($fornecedorModel);
    } elseif($acao == 'buscar') {
        buscarFornecedor($fornecedorModel);
    }
} else {
    // Caso nenhuma ação seja especificada, exibe a listagem
    listarFornecedores($fornecedorModel);
}

?>