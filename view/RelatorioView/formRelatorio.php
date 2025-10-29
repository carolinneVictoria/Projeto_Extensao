<?php include("../app/header.php"); ?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white text-center">
                    <h4>Gerar Relatório de Fluxo de Caixa</h4>
                </div>
                <div class="card-body">
                    <form action="../controller/RelatorioController.php" method="get">
                        <input type="hidden" name="acao" id="acao" value="exportarFluxoMes">

                        <div class="mb-3">
                            <label for="mes" class="form-label">Mês</label>
                            <select name="mes" id="mes" class="form-select" required>
                                <?php for($m=1; $m<=12; $m++): ?>
                                    <option value="<?= $m ?>" <?= ($m == date('m') ? 'selected' : '') ?>>
                                        <?= str_pad($m, 2, '0', STR_PAD_LEFT) ?>
                                    </option>
                                <?php endfor; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="ano" class="form-label">Ano</label>
                            <select name="ano" id="ano" class="form-select" required>
                                <?php for($a=date('Y'); $a>=2020; $a--): ?>
                                    <option value="<?= $a ?>"><?= $a ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="javascript:history.back()" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Voltar
                            </a>

                            <!-- Botão Exportar PDF -->
                            <button type="submit" class="btn btn-primary" onclick="document.getElementById('acao').value='exportarFluxoMes'">
                                <i class="fas fa-file-pdf"></i> Exportar PDF
                            </button>

                            <!-- Botão Visualizar -->
                            <button type="submit" class="btn btn-success" onclick="document.getElementById('acao').value='visualizarFluxoMes'">
                                <i class="fas fa-eye"></i> Visualizar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include("../app/footer.php"); ?>
