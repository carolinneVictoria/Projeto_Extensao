<?php
include_once "../config/conexaoBD.php";
include_once '../model/Categoria.php';

$categoriaModel = new Categoria($conn);

function listarCategorias($categoriaModel) {
    $categorias = $categoriaModel->listarCategoria();
    include('../view/CategoriaView/categorias.php');
}

function cadastrarCategoria($categoriaModel) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $descricaoCategoria = $_POST['descricao'];

        if ($categoriaModel->cadastrarCategoria($descricaoCategoria)) {
            header("Location: ../view/CategoriaView/categorias.php");
            exit();
        } else {
            echo "Erro ao cadastrar categoria!";
        }
    }
}

function atualizarCategoria($categoriaModel) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['idCategoria'])) {
        $idCategoria = $_POST['idCategoria'];
        $descricaoCategoria = $_POST['descricao'];

        if ($categoriaModel->atualizarCategoria($idCategoria, $descricaoCategoria)) {
            header("Location: ../view/CategoriaView/categorias.php");
            exit();
        } else {
            echo "Erro ao atualizar a categoria!" . mysqli_error($categoriaModel->getConnection());
        }
    }
}

function excluirCategoria($categoriaModel) {
    $idCategoria = $_GET['id'];
    $resultado = $categoriaModel->excluirCategoria($idCategoria);
    if ($resultado) {
    echo "Categoria excluída com sucesso!";
    header('Location: ../view/CategoriaView/categorias.php');
    exit();
    } else {
    echo "Erro ao excluir a Categoria.";
    }
}

function buscarCategoria($categoriaModel) {
    if (isset($_GET['busca'])) {
            $termo = $_GET['busca'];
            $categorias = $categoriaModel->buscarPorNome($termo);

            include('../view/CategoriaView/verBuscaCategoria.php'); // Mostra os resultados da busca
        } else {
            echo "Nenhum termo de busca informado.";
        }
}


if (isset($_GET['acao'])) {
    $acao = $_GET['acao'];

    // Chamando a ação de acordo com a URL
    if ($acao == 'cadastrar') {
        cadastrarCategoria($categoriaModel);
    } elseif ($acao == 'listar') {
        listarCategorias($categoriaModel);
    } elseif ($acao == 'atualizar') {
        atualizarCategoria($categoriaModel); // Se o formulário for enviado, processa a atualização
    } elseif ($acao == 'excluir') {
        excluirCategoria($categoriaModel);
    } elseif($acao == 'buscar') {
        buscarCategoria($categoriaModel);
    }
} else {
    // Caso nenhuma ação seja especificada, exibe a listagem
    listarCategorias($categoriaModel);
}
?>
