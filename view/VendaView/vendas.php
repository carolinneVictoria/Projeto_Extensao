<?php include ("../app/header.php"); ?>

<div class="container" style="margin-left: -10px; padding-top: 10px;">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Histórico de Vendas</h2>
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


<!-- Paginação -->
    <nav>
        <ul class="pagination justify-content-center">
            <li class="page-item <?= ($paginaAtual <= 1) ? 'disabled' : '' ?>">
                <a class="page-link" href="?acao=listar&pagina=<?= $paginaAtual - 1 ?>">Anterior</a>
            </li>

            <?php for ($i = 1; $i <= $totalPaginas; $i++) { ?>
                <li class="page-item <?= ($i == $paginaAtual) ? 'active' : '' ?>">
                    <a class="page-link" href="?acao=listar&pagina=<?= $i ?>"><?= $i ?></a>
                </li>
            <?php } ?>

            <li class="page-item <?= ($paginaAtual >= $totalPaginas) ? 'disabled' : '' ?>">
                <a class="page-link" href="?acao=listar&pagina=<?= $paginaAtual + 1 ?>">Próximo</a>
            </li>
        </ul>
    </nav>
<?php include "../app/footer.php"; ?>

</div>