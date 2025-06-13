<?php include(__DIR__ ."/../../app/header.php"); ?>

<h5>Resultado da busca por: "<?= htmlspecialchars($_GET['busca']) ?>"</h5>

<table class="table table-hover table-bordered">
    <thead class="thead-light">
        <tr>
            <th>ID</th>
            <th>NOME</th>
            <th>TELEFONE</th>
            <th>CPF</th>
            <th>DATA DE NASCIMENTO</th>
            <th>ENDEREÇO</th>
            <th>BICICLETA</th>
            <th>ACÕES</th>
        </tr>
    </thead>
    <tbody>
    <?php while ($registro = mysqli_fetch_assoc($clientes)) : ?>
        <tr>
            <td><?= $registro['idCliente'] ?></td>
            <td><?= $registro['nome'] ?></td>
            <td><?= $registro['telefone'] ?></td>
            <td><?= $registro['cpf'] ?></td>
            <td><?= $registro['dataNascimento'] ?></td>
            <td><?= $registro['endereco'] ?></td>
            <td><?= $registro['bicicleta'] ?></td>
            <td>
                <a href='../view/ClienteView/verCliente.php?id=<?= $registro['idCliente'] ?>' class='btn btn-primary btn-sm'>Ver Detalhes</a>
            </td>
        </tr>
    <?php endwhile; ?>
    </tbody>
</table>

<div class="col-md-12">
    <a href="/Projeto_Extensao/view/ClienteView/clientes.php" class="btn btn-secondary mt-3" style="width: 100px; margin-left: 515px; position: fixed;">Voltar</a>
</div>

<?php include(__DIR__ ."/../../app/footer.php"); ?>
