<?php include("../app/header.php"); ?>

<div class="container" style="margin-left: -10px; padding-top: 10px;">
    <h3>Resumo do Fluxo de Caixa - <?= str_pad($mes, 2, '0', STR_PAD_LEFT) ?>/<?= $ano ?></h3>

    <!-- Cards de resumo -->
    <div class="row my-4">
        <?php
        $lucro = ($totalVendas + $totalServicos) - $totalContas;

        $cards = [
            ['titulo' => 'Total Vendas', 'valor' => $totalVendas, 'cor' => 'success'],
            ['titulo' => 'Total Serviços', 'valor' => $totalServicos, 'cor' => 'info'],
            ['titulo' => 'Total Contas', 'valor' => $totalContas, 'cor' => 'danger'],
            ['titulo' => 'Lucro', 'valor' => $lucro, 'cor' => 'primary'],
        ];

        foreach($cards as $card): ?>
        <div class="col-md-3">
            <div class="card text-white bg-<?= $card['cor'] ?> mb-3" style="height: 100px;">
                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                    <h6 class="card-title mb-2"><?= $card['titulo'] ?></h6>
                    <p class="card-text fs-5 mb-0">R$ <?= number_format($card['valor'], 2, ',', '.') ?></p>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- Gráfico do Fluxo de Caixa -->
    <div class="row my-4">
        <div class="col">
            <canvas id="graficoFluxo" width="400" height="200"></canvas>
        </div>
    </div>

    <!-- Tabelas detalhadas -->
    <h3>Serviços</h3>
    <?php if(count($servicos) > 0): ?>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Descrição</th>
                <th>Cliente</th>
                <th>Data</th>
                <th>Valor</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($servicos as $s): ?>
            <tr>
                <td><?= $s['idServico'] ?></td>
                <td><?= htmlspecialchars($s['descricao']) ?></td>
                <td><?= htmlspecialchars($s['nome']) ?></td>
                <td><?= $s['dataEntrada'] ?></td>
                <td>R$ <?= number_format($s['valorTotal'],2,',','.') ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php else: ?>
        <p>Nenhum serviço registrado neste mês.</p>
    <?php endif; ?>

    <h3>Vendas</h3>
    <?php if(count($vendas) > 0): ?>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID Venda</th>
                <th>Produto</th>
                <th>Quantidade</th>
                <th>Valor Unitário</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($vendas as $v): ?>
            <tr>
                <td><?= $v['idVenda'] ?></td>
                <td><?= htmlspecialchars($v['nomeProduto']) ?></td>
                <td><?= $v['quantidade'] ?></td>
                <td>R$ <?= number_format($v['valorUnitario'], 2, ',', '.') ?></td>
                <td>R$ <?= number_format($v['totalItem'], 2, ',', '.') ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php else: ?>
        <p>Nenhuma venda registrada neste mês.</p>
    <?php endif; ?>

    <h3>Contas</h3>
    <?php if(count($contas) > 0): ?>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID Conta</th>
                <th>Descrição</th>
                <th>Status</th>
                <th>Valor</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($contas as $c): ?>
            <tr>
                <td><?= $c['idConta'] ?></td>
                <td><?= htmlspecialchars($c['descricao']) ?></td>
                <td><?= $c['statusText'] ?></td>
                <td>R$ <?= number_format($c['valorTotal'],2,',','.') ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php else: ?>
        <p>Nenhuma conta registrada neste mês.</p>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('graficoFluxo').getContext('2d');
    const graficoFluxo = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Vendas', 'Serviços', 'Contas', 'Lucro'],
            datasets: [{
                label: 'R$',
                data: [<?= $totalVendas ?>, <?= $totalServicos ?>, <?= $totalContas ?>, <?= $lucro ?>],
                backgroundColor: ['#28a745', '#17a2b8', '#dc3545', '#007bff']
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'R$ ' + value.toLocaleString('pt-BR', {minimumFractionDigits: 2});
                        }
                    }
                }
            }
        }
    });
</script>

<?php include("../app/footer.php"); ?>
