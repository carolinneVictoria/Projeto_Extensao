<?php
include_once "../config/conexaoBD.php";
include_once "../model/Cliente.php";

$clienteModel = new Cliente($conn);

function listarClientes($clienteModel) {
    $clientes = $clienteModel->listarClientes();
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
            header("Location: ../view/ClienteView/clientes.php");
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
            header("Location: ../view/ClienteView/clientes.php");
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
        header('Location: ../view/ClienteView/clientes.php');
    } else {
        echo "ERRO AO EXCLUIR!";
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
    }
} else {
    // Caso nenhuma ação seja especificada, exibe a listagem
    listarCategorias($clienteModel);
}


?>