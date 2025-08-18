<?php
include_once "../config/conexaoBD.php";
include_once "../model/Cliente.php";

$clienteModel = new Cliente($conn);

function listarClientes($clienteModel) {
    $paginaAtual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
    $limite = 5; // clientes por página
    $offset = ($paginaAtual - 1) * $limite;

    // Busca clientes
    $clientes = $clienteModel->listarClientesPaginados($limite, $offset);

    // Conta total
    $totalClientes = $clienteModel->contarClientes();
    $totalPaginas = ceil($totalClientes / $limite);
    include('../view/ClienteView/clientes.php');
}

function cadastrarCliente($clienteModel) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nomeCliente = $_POST['nome'];
        $telefoneCliente = $_POST['telefone'];
        $cpfCliente = $_POST['cpf'];
        $dataNascimento = $_POST['dataNascimento'];
        $endereco = $_POST['endereco'];
        $bicicleta = $_POST['bicicleta'];

        if ($clienteModel->cadastrarCliente($nomeCliente, $telefoneCliente, $cpfCliente, $dataNascimento, $endereco, $bicicleta)){
            listarClientes($clienteModel);
            exit();
        } else {
            echo "ERRO AO CADASTRAR CLIENTE.";
        }
    }
}

function atualizarCliente($clienteModel) {
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['idCliente'])) {
        $idCliente = $_POST['idCliente'];
        $nome = $_POST['nome'];
        $telefone = $_POST['telefone'];
        $cpf = $_POST['cpf'];
        $dataNascimento = $_POST['dataNascimento'];
        $endereco = $_POST['endereco'];
        $bicicleta = $_POST['bicicleta'];

        if ($clienteModel->atualizarCliente($idCliente, $nome, $telefone, $cpf, $dataNascimento, $endereco, $bicicleta)) {
            listarClientes($clienteModel);
            exit();
        } else {
            echo "Erro ao atualizar o cliente!" . mysqli_error($clienteModel->getConnection());
        }
    }
}
function excluirCliente($clienteModel) {
    $idCliente = $_GET['id'];
    $resultado = $clienteModel->excluirCliente($idCliente);
    if($resultado) {
        listarClientes($clienteModel);
        exit();
    } else {
        echo "Erro ao excluir. Possivelmente tem associações " ;
    }
}

function buscarCliente($clienteModel) {
    if (isset($_GET['busca'])) {
            $termo = $_GET['busca'];
            $clientes = $clienteModel->buscarPorNome($termo);
            include('../view/ClienteView/verBuscaCliente.php');
    } else {
        echo "NENHUM TERMO DE BUSCA INFORMADO.";
    }
}

function verCliente($clienteModel){
    if (isset($_GET['id'])) {
        $idCliente = $_GET['id'];
        $cliente = $clienteModel->buscarClientePorId($idCliente);

        if ($cliente) {
            include_once '../view/ClienteView/verCliente.php';
        } else {
            header('Location: ../view/ClienteView/clientes.php&erro=naoencontrado');
            exit();
        }
    } else {
        header('Location: ../view/ClienteView/clientes.php&erro=naoencontrado');
        exit();
    }
}

function formAtualizar($clienteModel){
    if (isset($_GET['id'])) {
        $idCliente = $_GET['id'];
        $cliente = $clienteModel->buscarClientePorId($idCliente);

        if ($cliente) {
            include_once '../view/ClienteView/formAtualizarCliente.php';
        } else {
            header('Location: ../view/ClienteView/clientes.php&erro=naoencontrado');
            exit();
        }
    } else {
        header('Location: ../view/ClienteView/clientes.php&erro=naoencontrado');
        exit();
    }
}

if (isset($_GET['acao'])) {
    $acao = $_GET['acao'];

    // Chamando a ação de acordo com a URL
    if ($acao == 'cadastrar') {
        cadastrarCliente($clienteModel);
    } elseif ($acao == 'listar') {
        listarClientes($clienteModel);
    } elseif ($acao == 'atualizar') {
        atualizarCliente($clienteModel); // Se o formulário for enviado, processa a atualização
    } elseif ($acao == 'excluir') {
        excluirCliente($clienteModel);
    } elseif($acao == 'buscar') {
        buscarCliente($clienteModel);
    } elseif($acao == 'ver'){
        verCliente($clienteModel);
    } elseif ($acao == 'formAtualizar'){
        formAtualizar($clienteModel);
    } elseif ($acao == 'formCadastrar'){
        include_once '../view/ClienteView/formCliente.php';
    }
} else {
    // Caso nenhuma ação seja especificada, exibe a listagem
    listarCategorias($clienteModel);
}


?>