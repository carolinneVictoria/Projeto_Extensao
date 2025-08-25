<?php
include_once "../config/conexaoBD.php";
include_once "../model/Fornecedor.php";

$fornecedorModel = new Fornecedor($conn);

function listarFornecedores($fornecedorModel) {
    $paginaAtual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
    $limite = 5;
    $offset = ($paginaAtual - 1) * $limite;

    $fornecedores = $fornecedorModel->listarFornecedoresPaginados($limite, $offset);

    $totalFornecedores = $fornecedorModel->contarFornecedores();
    $totalPaginas = ceil($totalFornecedores / $limite);
    include('../view/FornecedorView/fornecedores.php');
}
function cadastrarFornecedor($fornecedorModel) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $telefone       = $_POST['telefone'];
        $cnpj           = $_POST['cnpj'];
        $razaoSocial    = $_POST['razaoSocial'];
        $endereco       = $_POST['endereco'];

        if ($fornecedorModel->cadastrarFornecedor($telefone, $cnpj, $razaoSocial, $endereco)){
            listarFornecedores($fornecedorModel);
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
            listarFornecedores($fornecedorModel);
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
        listarFornecedores($fornecedorModel);
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
function verFornecedor($fornecedorModel){
    if (isset($_GET['id'])) {
        $idFornecedor = $_GET['id'];
        $fornecedor = $fornecedorModel->buscarFornecedorPorId($idFornecedor);

        if ($fornecedor) {
            include_once '../view/FornecedorView/verFornecedor.php';
        } else {
            header('Location: ../view/FornecedorView/fornecedores.php&erro=naoencontrado');
            exit();
        }
    } else {
        header('Location: ../view/FornecedorView/fornecedores.php&erro=naoencontrado');
        exit();
    }
}
function formAtualizar($fornecedorModel){
    if (isset($_GET['id'])) {
        $idFornecedor = $_GET['id'];
        $fornecedor = $fornecedorModel->buscarFornecedorPorId($idFornecedor);

        if ($fornecedor) {
            include_once '../view/FornecedorView/formAtualizarFornecedor.php';
        } else {
            header('Location: ../view/FornecedorView/fornecedores.php&erro=naoencontrado');
            exit();
        }
    } else {
        header('Location: ../view/FornecedorView/fornecedores.php&erro=naoencontrado');
        exit();
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
    } elseif($acao == 'ver'){
        verFornecedor($fornecedorModel);
    } elseif($acao == 'formCadastrar'){
        include_once "../view/FornecedorView/formFornecedor.php";
    } elseif($acao == 'formAtualizar'){
        formAtualizar($fornecedorModel);
    }
} else {
    // Caso nenhuma ação seja especificada, exibe a listagem
    listarFornecedores($fornecedorModel);
}

?>