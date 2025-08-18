<?php include(__DIR__ ."/../../app/header.php"); ?>

<div class="container" style="margin-left: -10px; padding-top: 10px;">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Lista de Clientes</h2>
        <a href="/Projeto_Extensao/controller/ClienteController.php?acao=formCadastrar" class="btn btn-success"><i class="fas fa-plus"></i> Novo Cliente</a>
    </div>

    <form action="/Projeto_Extensao/controller/ClienteController.php?acao=buscar" method="GET" class="mb-3">
        <div class="input-group">
            <input type="text" name="busca" class="form-control" placeholder="Pesquisar cliente...">
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
                <th>CPF</th>
                <th>DATA DE NASCIMENTO</th>
                <th>ENDEREÇO</th>
                <th>BICICLETA</th>
                <th>ACÕES</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($registro = mysqli_fetch_assoc($clientes)){
                $idCliente = $registro['idCliente'];
                echo "
                        <tbody>
                        <tr>
                            <td>{$registro['idCliente']}</td>
                            <td>{$registro['nome']}</td>
                            <td>{$registro['telefone']}</td>
                            <td>{$registro['cpf']}</td>
                            <td>{$registro['dataNascimento']}</td>
                            <td>{$registro['endereco']}</td>
                            <td>{$registro['bicicleta']}</td>
                            <td class='text-center'>
                            <a class='btn btn-warning btn-sm' href='../controller/ClienteController.php?acao=ver&id=$idCliente'>
                                <i class='fas fa-edit'></i>
                            </a>
                            <a class='btn btn-danger btn-sm' href='../controller/ClienteController.php?acao=excluir&id=$idCliente' onclick=\"return confirm('Tem certeza que deseja excluir?')\">
                                <i class='fas fa-trash'></i>
                            </a>
                            </td>
                        </tr>
                    </tbody> ";
            }
            echo " </table>";
            ?>
    </tbody>
</table>

<div class="col-md-12">
    <a href="/Projeto_Extensao/controller/ClienteController.php?acao=listar" class="btn btn-secondary mt-3" style="width: 100px; margin-left: 515px; position: fixed;">Voltar</a>
</div>

<?php include(__DIR__ ."/../../app/footer.php"); ?>
