<?php include("../app/header.php"); ?>

< class="container" style="margin-left: -10px; padding-top: 10px;">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Lista de Contas</h2>
        <a href="/Projeto_Extensao/controller/FinanceiroController.php?acao=formCadastrar" class="btn btn-success"><i class="fas fa-plus"></i> Nova Conta</a>
    </div>

    <form action="/Projeto_Extensao/controller/FinanceiroController.php?acao=buscar" method="GET" class="mb-3">
        <div class="input-group">
            <input type="text" name="busca" class="form-control" placeholder="Pesquisar conta...">
            <button class="btn btn-primary" type="submit" name="acao" value="buscar">
                <i class="fas fa-search"></i>
            </button>
        </div>
    </form>
    
    <div class="row g-2 align-items-end mb-4">
        <form method="GET" action="/Projeto_Extensao/controller/FinanceiroController.php" class="col-md-auto d-flex align-items-end">
            <input type="hidden" name="acao" value="filtrar">

            <div class="me-2">
                <label class="form-label">Mês</label>
                <select name="mes" class="form-select">
                <option value="">Todos</option>
                <?php
                for ($i = 1; $i <= 12; $i++) {
                    $mesSelecionado = (isset($_GET['mes']) && $_GET['mes'] == $i) ? 'selected' : '';
                    echo "<option value='$i' $mesSelecionado>" . str_pad($i, 2, '0', STR_PAD_LEFT) . "</option>";
                }
                ?>
                </select>
            </div>

            <div class="me-2">
                <label class="form-label">Ano</label>
                <input type="number" name="ano" class="form-control" value="<?= $_GET['ano'] ?? date('Y') ?>">
            </div>

            <div>
                <button type="submit" class="btn btn-primary">Filtrar</button>
            </div>
        </form>

        <div class="col-md-auto d-flex align-items-end">
            <a href="/Projeto_Extensao/controller/FinanceiroController.php?acao=listar" class="btn btn-success me-2">Todos</a>
            <a href="/Projeto_Extensao/controller/FinanceiroController.php?acao=listarPagos" class="btn btn-success me-2">Contas Pagas</a>
            <a href="/Projeto_Extensao/controller/FinanceiroController.php?acao=listarPendentes" class="btn btn-success">Contas a Pagar</a>
        </div>
    </div>
    
<?php
echo "
    <div class='table-responsive'>
        <table class='table table-striped align-middle'>
            <thead class='table-dark'>
                <tr>
                    <th>ID</th>
                    <th>DESCRIÇÃO</th>
                    <th>VALOR</th>
                    <th>DATA DE VENCIMENTO</th>
                    <th>STATUS</th>
                    <th>AÇÕES</th>
                </tr>
            </thead>
        <tbody>";

while ($registro = mysqli_fetch_assoc($contas)) {
    $idConta = $registro['idConta'];
    $status = $registro['status'] == 0 ? 'A pagar' : 'Pago!';
    $valor = number_format($registro['valorTotal'], 2, ',', '.');

    echo "
    <tr>
        <td>{$registro['idConta']}</td>
        <td>{$registro['descricao']}</td>
        <td>R$ $valor</td>
        <td>{$registro['dataVencimento']}</td>
        <td>$status</td>
        <td class='text-center'>
            <a class='btn btn-warning btn-sm' href='../controller/FinanceiroController.php?acao=ver&id=$idConta'>
                <i class='fas fa-edit'></i>
            </a>
            <a class='btn btn-danger btn-sm' href='../controller/FinanceiroController.php?acao=excluir&id=$idConta' onclick=\"return confirm('Tem certeza que deseja excluir?')\">
                <i class='fas fa-trash'></i>
            </a>
        </td>
    </tr>";
}
echo "
</tbody>
</table>";
?>

<!-- Paginação -->
    <nav>
        <ul class="pagination justify-content-center">
            <li class="page-item <?= ($paginaAtual <= 1) ? 'disabled' : '' ?>">
                <a class="page-link" href="?acao=listar&pagina=<?= $paginaAtual - 1 ?>">Anterior</a>
            </li>

            <?php
            $limiteLinks = 5;
            $primeiroLink = max(1, $paginaAtual - floor($limiteLinks / 2));
            $ultimoLink = min($totalPaginas, $primeiroLink + $limiteLinks - 1);

            if ($ultimoLink - $primeiroLink + 1 < $limiteLinks) {
                $primeiroLink = max(1, $ultimoLink - $limiteLinks + 1);
            }

            if ($primeiroLink > 1) {
                echo '<li class="page-item"><a class="page-link" href="?acao=listar&pagina=1">1</a></li>';
                if ($primeiroLink > 2) {
                    echo '<li class="page-item disabled"><a class="page-link">...</a></li>';
                }
            }

            for ($i = $primeiroLink; $i <= $ultimoLink; $i++) {
                ?>
                <li class="page-item <?= ($i == $paginaAtual) ? 'active' : '' ?>">
                    <a class="page-link" href="?acao=listar&pagina=<?= $i ?>"><?= $i ?></a>
                </li>
            <?php }

            if ($ultimoLink < $totalPaginas) {
                if ($ultimoLink < $totalPaginas - 1) {
                    echo '<li class="page-item disabled"><a class="page-link">...</a></li>';
                }
                echo '<li class="page-item"><a class="page-link" href="?acao=listar&pagina=' . $totalPaginas . '">' . $totalPaginas . '</a></li>';
            }
            ?>

            <li class="page-item <?= ($paginaAtual >= $totalPaginas) ? 'disabled' : '' ?>">
                <a class="page-link" href="?acao=listar&pagina=<?= $paginaAtual + 1 ?>">Próximo</a>
            </li>
        </ul>
    </nav>
</div>

<?php include("../app/footer.php"); ?>