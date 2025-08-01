<?php 
include("../../app/header.php");
include_once('../../config/conexaoBD.php');
include_once('../../model/Fornecedor.php');
include_once('../../model/Usuario.php');

session_start();

$fornecedorModel = new Fornecedor($conn);
$fornecedores = $fornecedorModel->listarFornecedores();

$usuarioModel = new Usuario($conn);
$usuarios = $usuarioModel->listarUsuarios();

?>

<div class="container-fluid"><p></p>
    <h4>Insira os dados:</h4>
    <div class="col-sm-12">

        <form id="formServico" action="/Projeto_Extensao/controller/CompraController.php?acao=cadastrar" method="POST" class="was-validated">
            <div class="row mt-4">

                <!-- Usuário -->
                <div class="col-md-3 mb-3">
                    <div class="form-floating">
                        <select class="form-control" id="usuario" name="idUsuario" required>
                            <?php foreach ($usuarios as $usuario): ?>
                                <option value="<?= $usuario['idUsuario']; ?>"><?= $usuario['nomeUsuario']; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <label for="usuario">Usuário:</label>
                    </div>
                </div>

                <!-- Fornecedor -->
                <div class="col-md-3 mb-3">
                    <div class="form-floating">
                        <select class="form-control" id="idFornecedor" name="idFornecedor" required>
                            <?php foreach ($fornecedores as $fornecedor): ?>
                                <option value="<?= $fornecedor['idFornecedor']; ?>"><?= $fornecedor['razaoSocial']; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <label for="idFornecedor">Fornecedor:</label>
                    </div>
                </div>

                <!-- Data de Entrada -->
                <div class="col-md-3 mb-3">
                    <div class="form-floating">
                        <input type="date" class="form-control" id="data" name="data" required>
                        <label for="data">Data da compra:</label>
                    </div>
                </div>

                <!-- Valor Total -->
                <div class="col-md-3 mb-3">
                    <div class="form-floating">
                        <input type="text" class="form-control" id="valorTotal" name="valorTotal" >
                        <label for="valorTotal">Valor Total:</label>
                    </div>
                </div>

                <!-- Descrição -->
                <div class="col-md-12 mb-4">
                    <div class="form-floating">
                        <input type="text" class="form-control" id="descricao" name="descricao" >
                        <label for="descricao">Descrição:</label>
                    </div>
                </div>

                <div class="d-flex justify-content-end mt-3">
                    <button type="submit" class="btn btn-primary">Próximo</button>
                </div>
            </div>
        </form>
    </div>
</div>
