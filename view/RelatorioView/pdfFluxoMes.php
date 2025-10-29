<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Fluxo de Caixa - <?= str_pad($mes,2,'0',STR_PAD_LEFT) ?>/<?= $ano ?></title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        h2 { text-align: center; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #333; padding: 5px; text-align: left; }
        th { background-color: #ddd; }
        .total { font-weight: bold; }
    </style>
</head>
<body>

<h2>Fluxo de Caixa - <?= str_pad($mes,2,'0',STR_PAD_LEFT) ?>/<?= $ano ?></h2>

<?php
$totalServicos = 0;
$totalVendas   = 0;
$totalContas   = 0;
?>

<!-- Serviços -->
<h3>Serviços</h3>
<?php if($servicos && mysqli_num_rows($servicos) > 0): ?>
<table>
    <thead>
        <tr>
            <th>ID Serviço</th>
            <th>Cliente</th>
            <th>Data Entrada</th>
            <th>Valor Total</th>
        </tr>
    </thead>
    <tbody>
    <?php while($s = mysqli_fetch_assoc($servicos)): 
        $totalServicos += $s['valorTotal'];
    ?>
        <tr>
            <td><?= $s['idServico'] ?></td>
            <td><?= htmlspecialchars($s['nomeCliente']) ?></td>
            <td><?= $s['dataEntrada'] ?></td>
            <td>R$ <?= number_format($s['valorTotal'],2,',','.') ?></td>
        </tr>
    <?php endwhile; ?>
    </tbody>
</table>
<?php else: ?>
<p>Nenhum serviço registrado neste mês.</p>
<?php endif; ?>

<!-- Vendas -->
<h3>Vendas de Produtos</h3>
<?php if($vendas && mysqli_num_rows($vendas) > 0): ?>
<table>
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
    <?php while($v = mysqli_fetch_assoc($vendas)):
        $totalItem = $v['quantidade'] * $v['valorUnitario'];
        $totalVendas += $totalItem;
    ?>
        <tr>
            <td><?= $v['idVenda'] ?></td>
            <td><?= htmlspecialchars($v['nomeProduto']) ?></td>
            <td><?= $v['quantidade'] ?></td>
            <td>R$ <?= number_format($v['valorUnitario'],2,',','.') ?></td>
            <td>R$ <?= number_format($totalItem,2,',','.') ?></td>
        </tr>
    <?php endwhile; ?>
    </tbody>
</table>
<?php else: ?>
<p>Nenhuma venda registrada neste mês.</p>
<?php endif; ?>

<!-- Contas -->
<h3>Contas</h3>
<?php if($contas && mysqli_num_rows($contas) > 0): ?>
<table>
    <thead>
        <tr>
            <th>ID Conta</th>
            <th>Descrição</th>
            <th>Status</th>
            <th>Valor</th>
        </tr>
    </thead>
    <tbody>
    <?php while($c = mysqli_fetch_assoc($contas)):
        $totalContas += $c['valorTotal'];
    ?>
        <tr>
            <td><?= $c['idConta'] ?></td>
            <td><?= htmlspecialchars($c['descricao']) ?></td>
            <td><?= ($c['status'] == 1) ? 'Pago' : 'Não Pago' ?></td>
            <td>R$ <?= number_format($c['valorTotal'],2,',','.') ?></td>
        </tr>
    <?php endwhile; ?>
    </tbody>
</table>
<?php else: ?>
<p>Nenhuma conta registrada neste mês.</p>
<?php endif; ?>

<!-- Total Geral -->
<h3>Total Geral</h3>
<table>
    <tbody>
        <tr>
            <td>Total Serviços + Vendas</td>
            <td>R$ <?= number_format($totalServicos + $totalVendas,2,',','.') ?></td>
        </tr>
        <tr>
            <td>Total Contas</td>
            <td>R$ <?= number_format($totalContas,2,',','.') ?></td>
        </tr>
        <tr class="total">
            <td>Saldo Final (Receitas - Despesas)</td>
            <td>R$ <?= number_format(($totalServicos + $totalVendas) - $totalContas,2,',','.') ?></td>
        </tr>
    </tbody>
</table>

</body>
</html>
