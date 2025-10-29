<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Serviço #<?= htmlspecialchars($servico['idServico']); ?></title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        h2, h3 { text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #333; padding: 6px; text-align: left; }
        th { background-color: #f0f0f0; }
        .info { margin-bottom: 15px; }
    </style>
</head>
<body>
    <h2>Relatório de Serviço</h2>
    <h3>Serviço #<?= htmlspecialchars($servico['idServico']); ?></h3>

    <div class="info">
        <p><strong>Cliente:</strong> <?= htmlspecialchars($servico['nome']); ?></p>
        <p><strong>Usuário Responsável:</strong> <?= htmlspecialchars($servico['nomeUsuario']); ?></p>
        <p><strong>Data de Entrada:</strong> <?= htmlspecialchars($servico['dataEntrada']); ?></p>
        <p><strong>Mão de Obra:</strong> R$ <?= number_format($servico['maodeObra'], 2, ',', '.'); ?></p>
        <p><strong>Valor Total:</strong> R$ <?= number_format($servico['valorTotal'], 2, ',', '.'); ?></p>
        <p><strong>Descrição:</strong> <?= htmlspecialchars($servico['descricao']); ?></p>
    </div>

    <h4>Produtos Usados</h4>
    <?php if (!empty($produtosAssociados)): ?>
        <table>
            <thead>
                <tr>
                    <th>Produto</th>
                    <th>Quantidade</th>
                    <th>Valor Unitário</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($produtosAssociados as $registro): ?>
                    <?php $total = $registro['quantidade'] * $registro['valorUnitario']; ?>
                    <tr>
                        <td><?= htmlspecialchars($registro['nomeProduto']); ?></td>
                        <td><?= htmlspecialchars($registro['quantidade']); ?></td>
                        <td>R$ <?= number_format($registro['valorUnitario'], 2, ',', '.'); ?></td>
                        <td>R$ <?= number_format($total, 2, ',', '.'); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Nenhum produto associado ao serviço.</p>
    <?php endif; ?>
</body>
</html>
