<?php include ("../app/header.php"); ?>
<div class="container" style="margin-left: -10px; padding-top: 10px;">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Lista de Usuarios</h2>
        <a href="/Projeto_Extensao/controller/UsuarioController.php?acao=formCadastrar" class="btn btn-success"><i class="fas fa-plus"></i> Novo Usuario</a>
    </div>

    <form action="/Projeto_Extensao/controller/UsuarioController.php?acao=buscar" method="GET" class="mb-3">
        <div class="input-group">
            <input type="text" name="busca" class="form-control" placeholder="Pesquisar usuario...">
            <button class="btn btn-primary" type="submit" name="acao" value="buscar">
                <i class="fas fa-search"></i>
            </button>
        </div>
    </form>

<div class='table-responsive'>
    <table class='table table-striped align-middle'>
        <thead class='table-dark'>
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
    <?php
    while ($registro = mysqli_fetch_assoc($usuarios)){
        $idUsuario = $registro['idUsuario'];
        echo "
            <tbody>
                <tr>
                    <td>{$registro['idUsuario']}</td>
                    <td>{$registro['nomeUsuario']}</td>
                    <td>{$registro['telefoneUsuario']}</td>
                    <td>{$registro['emailUsuario']}</td>
                    <td>{$registro['tipoUsuario']}</td>
                    <td>{$registro['statusUsuario']}</td>
                    <td class='text-center'>
                    <a class='btn btn-warning btn-sm' href='../controller/UsuarioController.php?acao=ver&id=$idUsuario'>
                        <i class='fas fa-edit'></i>
                    </a>
                    <a class='btn btn-danger btn-sm' href='../controller/UsuarioController.php?acao=excluir&id=$idUsuario' onclick=\"return confirm('Tem certeza que deseja excluir?')\">
                        <i class='fas fa-trash'></i>
                    </a>
                </td>
                </tr>
        ";
    }
    ?>
    </tbody>
</table>

<div class="col-md-12 text-center">
    <button onclick="history.back()" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Voltar
    </button>
</div>


<?php include("../app/footer.php"); ?>
