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

<div class="container-fluid"><p></p>
    <h4>Insira os dados:</h4>
    <div class="col-sm-12">

        <form id="formServico" action="/Projeto_Extensao/controller/VendaController.php?acao=cadastrar" method="POST" class="was-validated">
            <div class="row mt-4">

                <!-- Usuário -->
                <div class="col-md-4 mb-3">
                    <div class="form-floating">
                        <select class="form-control" id="usuario" name="idUsuario" required>
                            <?php foreach ($usuarios as $usuario): ?>
                                <option value="<?= $usuario['idUsuario']; ?>"><?= $usuario['nomeUsuario']; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <label for="usuario">Usuário:</label>
                    </div>
                </div>

                <!-- Data de Entrada -->
                <div class="col-md-4 mb-3">
                    <div class="form-floating">
                        <input type="date" class="form-control" id="data" name="data" required>
                        <label for="data">Data da venda:</label>
                    </div>
                </div>

                <!-- Desconto -->
                <div class="col-md-4 mb-3 d-none">
                    <div class="form-floating">
                        <input type="text" class="form-control" id="descontoVenda" name="descontoVenda" >
                        <label for="descontoVenda">Desconto:</label>
                    </div>
                </div>

                <!-- Valor Total -->
                <div class="col-md-4 mb-3 d-none">
                    <div class="form-floating">
                        <input type="text" class="form-control" id="valorTotal" name="valorTotal" >
                        <label for="valorTotal">ValorTotal:</label>
                    </div>
                </div>
                
                <div class="col-md-4 mb-3">
                    <div class="form-floating">
                        <select class="form-control" id="formaPagamento" name="formaPagamento" required>
                            <option value="">-- Selecione uma forma de Pagamento --</option>
                            <option value="Pix">Pix</option>
                            <option value="Dinheiro">Dinheiro</option>
                            <option value="Cartão de Débito">Cartão de Débito</option>
                            <option value="Cartão de Crédito">Cartão de Crédito</option>
                        </select>
                        <label for="formaPagamento">Forma de Pagamento:</label>
                    </div>
                </div>


                <div class="d-flex justify-content-end mt-3">
                    <button type="submit" class="btn btn-primary">Próximo</button>
                </div>
            </div>
        </form>
    </div>
</div>
