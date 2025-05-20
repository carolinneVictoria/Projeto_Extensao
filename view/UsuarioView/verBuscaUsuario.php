<?php include(__DIR__ ."/../../app/header.php"); ?>

<h5>Resultado da busca por: "<?= htmlspecialchars($_GET['busca']) ?>"</h5>

<table class="table table-hover table-bordered">
    <thead class="thead-light">
        <tr>
            <th>ID</th>
            <th>NOME</th>
            <th>TELEFONE</th>
            <th>EMAIL</th>
            <th>TIPO</th>
            <th>STATUS</th>
            <th>ACÕES</th>
        </tr>
    </thead>
    <tbody>
    <?php while ($registro = mysqli_fetch_assoc($usuarios)) : ?>
        <tr>
            <td><?= $registro['idUsuario'] ?></td>
            <td><?= $registro['nomeUsuario'] ?></td>
            <td><?= $registro['telefoneUsuario'] ?></td>
            <td><?= $registro['emailUsuario'] ?></td>
            <td><?= $registro['tipoUsuario'] ?></td>
            <td><?= $registro['statusUsuario'] ?></td>
            <td>
                <a href="/Projeto_Extensao/view/UsuarioView/formAtualizarUsuario.php?id=<?= $registro['idUsuario'] ?>" class="btn btn-primary btn-sm">Atualizar</a>
                <a href="/Projeto_Extensao/controller/UsuarioController.php?acao=excluir&id=<?= $registro['idUsuario'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</a>
            </td>
        </tr>
    <?php endwhile; ?>
    </tbody>
</table>

<div class="col-md-12">
    <a href="/Projeto_Extensao/view/UsuarioView/usuarios.php" class="btn btn-secondary mt-3" style="width: 100px; margin-left: 515px; position: fixed;">Voltar</a>
</div>

<?php include(__DIR__ ."/../../app/footer.php"); ?>
