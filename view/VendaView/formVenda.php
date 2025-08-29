<?php include("../app/header.php");?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white text-center">
                    <h4 class="mb-0">Dados da Venda</h4>
                </div>
                <div class="card-body">
                    <form id="formServico" action="/Projeto_Extensao/controller/VendaController.php?acao=cadastrar" method="POST" class="was-validated">
                        <div class="row g-3">
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
                                    <input type="date" class="form-control" id="data" name="data" required>
                                    <label for="data">Data da Venda:</label>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select class="form-select" id="formaPagamento" name="formaPagamento" required>
                                        <option value="" selected disabled>-- Selecione uma Forma de Pagamento --</option>
                                        <option value="Pix">Pix</option>
                                        <option value="Dinheiro">Dinheiro</option>
                                        <option value="Cartão de Débito">Cartão de Débito</option>
                                        <option value="Cartão de Crédito">Cartão de Crédito</option>
                                    </select>
                                    <label for="formaPagamento">Forma de Pagamento:</label>
                                </div>
                            </div>
                            
                            <input type="hidden" id="descontoVenda" name="descontoVenda" value="0.00">
                            <input type="hidden" id="valorTotal" name="valorTotal" value="0.00">
                        </div>
                        
                        <hr class="my-4">
                        
                        <div class="d-flex justify-content-between">
                            <a href="javascript:history.back()" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Voltar
                            </a>
                            <button type="submit" class="btn btn-success">Próximo <i class="fas fa-arrow-right"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include("../../app/footer.php");?>