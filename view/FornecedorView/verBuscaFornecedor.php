<?php include("../app/header.php"); ?>
<div class="container" style="margin-left: -10px; padding-top: 10px;">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Lista de Fornecedores</h2>
        <a href="/Projeto_Extensao/controller/FornecedorController.php?acao=formCadastrar" class="btn btn-success"><i class="fas fa-plus"></i> Novo Fornecedor</a>
    </div>

    <form action="/Projeto_Extensao/controller/FornecedorController.php?acao=buscar" method="GET" class="mb-3">
        <div class="input-group">
            <input type="text" name="busca" class="form-control" placeholder="Pesquisar fornecedor...">
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
                <th>CNPJ</th>
                <th>RAZÃO SOCIAL</th>
                <th>ENDEREÇO</th>
                <th>TELEFONE</th>
                <th>ACÕES</th>
            </tr>
    </thead>
    <tbody>
    <?php
        while ($registro = mysqli_fetch_assoc($fornecedores)){
            $idFornecedor = $registro['idFornecedor'];
            echo "
                <tr>
                <td>{$registro['idFornecedor']}</td>
                <td>{$registro['cnpj']}</td>
                <td>{$registro['razaoSocial']}</td>
                <td>{$registro['endereco']}</td>
                <td>{$registro['telefone']}</td>
                <td class='text-center'>
                    <a class='btn btn-warning btn-sm' href='../controller/FornecedorController.php?acao=ver&id=$idFornecedor'>
                        <i class='fas fa-edit'></i>
                    </a>
                    <a class='btn btn-danger btn-sm' href='../controller/FornecedorController.php?acao=excluir&id=$idFornecedor' onclick=\"return confirm('Tem certeza que deseja excluir?')\">
                        <i class='fas fa-trash'></i>
                    </a>
                </td>
            </tr>
        </tbody> ";
    }
        echo "</table>";
        ?>
    </tbody>
</table>

<div class="col-md-12">
    <a href="/Projeto_Extensao/controller/FornecedorController.php?acao=listar" class="btn btn-secondary mt-3" style="width: 100px; margin-left: 515px; position: fixed;">Voltar</a>
</div>

<?php include("../app/footer.php"); ?>
