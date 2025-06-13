<?php include(__DIR__ ."/../../app/header.php"); ?>

<h5>Resultado da busca por: "<?= htmlspecialchars($_GET['busca']) ?>"</h5>

<table class="table table-hover table-bordered">
    <thead class="thead-light">
        <tr>
            <th>ID</th>
            <th>CNPJ</th>
            <th>RAZÃO SOCIAL</th>
            <th>ENDEREÇO</th>
            <th>TELEFONE</th>
            <th>ACÕES</th>
        </tr>
    </thead>
    <tbody>
    <?php while ($registro = mysqli_fetch_assoc($fornecedores)) : ?>
        <tr>
            <td><?= $registro['idFornecedor'] ?></td>
            <td><?= $registro['cnpj'] ?></td>
            <td><?= $registro['razaoSocial'] ?></td>
            <td><?= $registro['endereco'] ?></td>
            <td><?= $registro['telefone'] ?></td>
            <td>
                <a href='../view/FornecedorView/verFornecedor.php?id=<?= $registro['idFornecedor'] ?>' class='btn btn-primary brn-sm'>Ver</a>
            </td>
        </tr>
    <?php endwhile; ?>
    </tbody>
</table>

<div class="col-md-12">
    <a href="/Projeto_Extensao/view/FornecedorView/fornecedores.php" class="btn btn-secondary mt-3" style="width: 100px; margin-left: 515px; position: fixed;">Voltar</a>
</div>

<?php include(__DIR__ ."/../../app/footer.php"); ?>
