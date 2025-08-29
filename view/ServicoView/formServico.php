<?php include("../app/header.php");?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white text-center">
                    <h4 class="mb-0">Cadastro de Serviço</h4>
                </div>
                <div class="card-body">
                    <form id="formServico" action="/Projeto_Extensao/controller/ServicoController.php?acao=cadastrar" method="POST" enctype="multipart/form-data" class="was-validated">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select class="form-select" id="cliente" name="idCliente" required>
                                        <option value="" selected disabled>-- Selecione um Cliente --</option>
                                        <?php foreach ($clientes as $cliente): ?>
                                            <option value="<?= htmlspecialchars($cliente['idCliente']); ?>"><?= htmlspecialchars($cliente['nome']); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <label for="cliente">Cliente:</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select class="form-select" id="usuario" name="idUsuario" required>
                                        <option value="" selected disabled>-- Selecione um Usuário --</option>
                                        <?php foreach ($usuarios as $usuario): ?>
                                            <option value="<?= htmlspecialchars($usuario['idUsuario']); ?>"><?= htmlspecialchars($usuario['nomeUsuario']); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <label for="usuario">Usuário:</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="date" class="form-control" id="dataEntrada" name="dataEntrada" required>
                                    <label for="dataEntrada">Data de Entrada:</label>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="maodeObra" name="maodeObra" placeholder="Valor da Mão de Obra">
                                    <label for="maodeObra">Mão de Obra:</label>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <textarea class="form-control" id="descricao" name="descricao" placeholder="Descrição"></textarea>
                                    <label for="descricao">Descrição:</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select class="form-select" id="entrega" name="entrega" required>
                                        <option value="" selected disabled>-- Status de Entrega --</option>
                                        <option value="1">Não</option>
                                        <option value="0">Sim</option>
                                    </select>
                                    <label for="entrega">Entregue:</label>
                                </div>
                            </div>
                            
                            <input type="hidden" name="valorTotal" id="valorTotal">
                            
                            <div class="col-12 d-flex justify-content-between">
                                <a href="javascript:history.back()" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Voltar
                                </a>
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-save"></i> Cadastrar Serviço
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include("../app/footer.php");?>