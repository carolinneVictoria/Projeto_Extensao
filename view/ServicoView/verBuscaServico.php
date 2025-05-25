<?php include(__DIR__ ."/../../app/header.php"); ?>

<h5>Resultado da busca por: "<?= htmlspecialchars($_GET['busca']) ?>"</h5>

<table class="table table-hover table-bordered">
    <thead class="thead-light">
        <tr>
            <th>ID</th>
            <th>CLIENTE</th>
            <th>USUARIO</th>
            <th>DESCRIÇÃO</th>
            <th>DATA DE ENTRADA</th>
            <th>ENTREGA</th>
            <th>VALOR</th>
            <th>AÇÕES</th>
        </tr>
    </thead>
    <tbody>
    <?php while ($registro = mysqli_fetch_assoc($servicos)) : ?>
        <tr>
            <td><?= $registro['idServico'] ?></td>
            <td><?= $registro['nome'] ?></td>
            <td><?= $registro['nomeUsuario'] ?></td>
            <td><?= $registro['descricao'] ?></td>
            <td><?= $registro['dataEntrada'] ?></td>
            <td><?= ($registro['entrega'] == 0 ? 'Sim' : 'Não') ?></td>
            <td>R$ <?= number_format($registro['valorTotal'], 2, ',', '.') ?></td>
            <td>
                <a href='formAtualizarServico.php?id=$idServico' class='btn btn-primary btn-sm'>Atualizar</a>
                <a href='../../controller/ServicoController.php?acao=excluir&id=$idServico' class='btn btn-danger btn-sm' onclick='return confirm(\"Tem certeza que deseja excluir?\")'>Excluir</a>
                <a href='verServico.php?id=$idServico' class='btn btn-primary brn-sm'>Ver</a>
            </td>
        </tr>
    <?php endwhile; ?>
    </tbody>
</table>

<div class="col-md-12">
    <a href="/Projeto_Extensao/view/ServicoView/servicos.php" class="btn btn-secondary mt-3" style="width: 100px; margin-left: 515px; position: fixed;">Voltar</a>
</div>

<?php include(__DIR__ . "../../app/footer.php"); ?>
