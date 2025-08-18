<?php include(__DIR__ ."/../../app/header.php"); ?>

<div class="container" style="margin-left: -10px; padding-top: 10px;">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Lista de Clientes</h2>
        <a href="/Projeto_Extensao/controller/VendaController.php?acao=formCadastrar" class="btn btn-success"><i class="fas fa-plus"></i> Nova Venda</a>
    </div>

    <form action="/Projeto_Extensao/controller/VendaController.php?acao=buscar" method="GET" class="mb-3">
        <div class="input-group">
            <input type="text" name="busca" class="form-control" placeholder="Pesquisar venda...">
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
                <th>PRODUTO/SERVIÇO</th>
                <th>DATA</th>
                <th>VALOR</th>
                <th>PAGAMENTO</th>
                <th>AÇÕES</th>
            </tr>
        </thead>
        <tbody>
        <?php
        while ($registro = mysqli_fetch_assoc($vendas)) {
            $idVenda = $registro['idVenda'];
            echo "
            <tr>
                <td>{$registro['idVenda']}</td>
                <td>{$registro['nomeProduto']}</td>
                <td>{$registro['data']}</td>
                <td>R$ " . number_format($registro['valorTotal'], 2, ',', '.') . "</td>
                <td>{$registro['formaPagamento']}</td>
                <td class='text-center'>
                    <a class='btn btn-warning btn-sm' href='../controller/VendaController.php?acao=ver&id={$idVenda}'>
                        <i class='fas fa-edit'></i>
                    </a>
                    <a class='btn btn-danger btn-sm' href='../controller/VendaController.php?acao=excluir&id={$idVenda}' onclick=\"return confirm('Tem certeza que deseja excluir?')\">
                        <i class='fas fa-trash'></i>
                    </a>
                </td>
            </tr>
            ";
        }
echo "</table>"; ?>

<div class="col-md-12">
    <a href="/Projeto_Extensao/controller/VendaController.php?acao=listar" class="btn btn-secondary mt-3" style="width: 100px; margin-left: 515px; position: fixed;">Voltar</a>
</div>

<?php include(__DIR__ ."/../../app/footer.php"); ?>
