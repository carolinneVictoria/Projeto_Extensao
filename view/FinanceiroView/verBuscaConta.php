<?php include("../app/header.php"); ?>
<div class="container" style="margin-left: -10px; padding-top: 10px;">
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
        while ($registro = mysqli_fetch_assoc($contas)){
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

<div class="col-md-12">
    <a href="/Projeto_Extensao/controller/FinanceiroController.php?acao=listar" class="btn btn-secondary mt-3" style="width: 100px; margin-left: 515px; position: fixed;">Voltar</a>
</div>

</div>
<?php include("../app/footer.php"); ?>
