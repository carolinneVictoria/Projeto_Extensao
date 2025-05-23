<?php 
include("../../app/header.php");
include_once('../../config/conexaoBD.php');
include_once('../../model/Cliente.php');
include_once('../../model/Usuario.php');

session_start();

$clienteModel = new Cliente($conn);
$clientes = $clienteModel->listarClientes();

$usuarioModel = new Usuario($conn);
$usuarios = $usuarioModel->listarUsuarios();


?>

<div class="container-fluid">
    <h4>Cadastro de Serviço:</h4>
    <div class="col-sm-12">

        <form id="formServico" action="/Projeto_Extensao/controller/ServicoController.php?acao=cadastrar" method="POST" class="was-validated">
            <div class="row mt-4">
                <div class="col-md-6 mb-3">
                    <div class="form-floating">
                        <select class="form-control" id="cliente" name="idCliente" required>
                            <?php foreach ($clientes as $cliente): ?>
                                <option value="<?= $cliente['idCliente']; ?>"><?= $cliente['nome']; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <label for="cliente">Cliente:</label>
                    </div>
                </div>

                <!-- Usuário -->
                <div class="col-md-6 mb-3">
                    <div class="form-floating">
                        <select class="form-control" id="usuario" name="idUsuario" required>
                            <?php foreach ($usuarios as $usuario): ?>
                                <option value="<?= $usuario['idUsuario']; ?>"><?= $usuario['nomeUsuario']; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <label for="usuario">Usuário:</label>
                    </div>
                </div>

                <!-- Descrição -->
                <div class="col-md-6 mb-3">
                    <div class="form-floating">
                        <input type="text" class="form-control" id="descricao" name="descricao">
                        <label for="descricao">Descrição:</label>
                    </div>
                </div>

                <!-- Data de Entrada -->
                <div class="col-md-6 mb-3">
                    <div class="form-floating">
                        <input type="date" class="form-control" id="dataEntrada" name="dataEntrada" required>
                        <label for="dataEntrada">Data de Entrada:</label>
                    </div>
                </div>

                <!-- Entregue -->
                <div class="col-md-6 mb-3">
                    <div class="form-floating">
                        <select class="form-select" id="entrega" name="entrega" required>
                            <option value="1">Não</option>
                            <option value="0">Sim</option>
                        </select>
                        <label for="entrega">Entregue:</label>
                    </div>
                </div>

                <!-- Valor Total -->
                <div class="col-md-6 mb-3">
                    <div class="form-floating">
                        <input type="text" class="form-control" id="valorTotal" name="valorTotal" required>
                        <label for="valorTotal">Valor Total:</label>
                    </div>
                </div>

                <div class="col-md-12 text-end mt-3">
                    <button type="submit" class="btn btn-primary">Cadastrar Serviço</button>
                </div>
            </div>
        </form>
    </div>
</div>
