<?php 
include("../../app/header.php");
include('../../config/conexaoBD.php');
include('../../model/Servico.php');
include('../../model/Cliente.php');
include('../../model/Usuario.php');
include('../../model/ServicoProduto.php');

$servicoModel = new Servico($conn);
$clienteModel = new Cliente($conn);
$usuarioModel = new Usuario($conn);
$servicoProdutoModel = new ServicoProduto($conn); 

if (isset($_GET['id'])) {
    $idServico = $_GET['id'];
    $servico = $servicoModel->buscarServicoPorId($idServico);
    $cliente = $clienteModel->buscarClientePorId($servico['idCliente']);
    $usuario = $usuarioModel->buscarUsuarioPorId($servico['idUsuario']);
} else {
    echo "ID do serviço não informado!";
    exit(); 
}

$valorTotal = 0;
$produtosAssociados = $servicoProdutoModel->listarProdutosServico($idServico);

if ($produtosAssociados) {
    while ($registro = mysqli_fetch_assoc($produtosAssociados)) {
        $valorTotal += $registro['quantidade'] * $registro['valorUnitario'];
    }
    if (!$servicoModel->atualizarValorTotalServico($idServico, $valorTotal)) {
        echo "Erro ao atualizar o valor total no banco de dados!";
        exit();
    }
} else {
    $produtosAssociados = []; 
}
?>

<div class="container-fluid">
    <h3>Detalhes do Serviço:</h3>
    <div class="col-sm-12">

        <div class="row">
            <div class="col-md-4 mb-3">
                <div class="form-floating border border-info rounded">
                    <input type="text" class="form-control" id="cliente" readonly value="<?= $cliente['nome']; ?>">
                    <label for="cliente">Cliente:</label>
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="form-floating border border-info rounded">
                    <input type="text" class="form-control" id="usuario" readonly value="<?= $usuario['nomeUsuario']; ?>">
                    <label for="usuario">Usuário Responsável:</label>
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="form-floating border border-info rounded">
                    <input type="date" class="form-control" id="dataEntrada" readonly value="<?= $servico['dataEntrada']; ?>">
                    <label for="dataEntrada">Data de Entrada:</label>
                </div>
            </div>

            <div class="col-md-6 mb-2">
                <div class="form-floating border border-info rounded">
                    <input type="text" class="form-control" id="maodeObra" readonly value="R$ <?= number_format($servico['maodeObra'], 2, ',', '.') ?>">
                    <label for="maodeObra">Mão de Obra:</label>
                </div>
            </div>

            <div class="col-md-6 mb-2">
                <div class="form-floating border border-info rounded">
                    <input type="text" class="form-control" id="valorTotal" readonly value="R$ <?= number_format($valorTotal, 2, ',', '.'); ?>">
                    <label for="valorTotal">Valor Total:</label>
                </div>
            </div>

            <div class="col-md-12 mb-3">
                <div class="form-floating border border-info rounded">
                    <textarea style="height: 100px" class="form-control" id="descricao" readonly><?= $servico['descricao']; ?></textarea>
                    <label for="descricao">Descrição:</label>
                </div>
            </div>

            <div class="col-md-12 mb-3">
            <h5>Produtos Usados</h5>
            <?php
            if (!empty($produtosAssociados)) {
                echo "
                    <table class='table table-hover table-bordered table-sm'>
                        <thead class='thead-light'>
                            <tr>
                                <th>PRODUTO</th>
                                <th>QUANTIDADE</th>
                                <th>VALOR UNITÁRIO</th>
                                <th>TOTAL</th>
                            </tr>
                        </thead>
                        <tbody>
                ";

                // Exibir os produtos associados ao serviço
                foreach ($produtosAssociados as $registro) {
                    $totalProduto = $registro['quantidade'] * $registro['valorUnitario'];
                    echo "
                        <tr>
                            <td>{$registro['nomeProduto']}</td>
                            <td>{$registro['quantidade']}</td>
                            <td>R$ " . number_format($registro['valorUnitario'], 2, ',', '.') . "</td>
                            <td>R$ " . number_format($totalProduto, 2, ',', '.') . "</td>
                        </tr>
                    ";
                }
                echo "</tbody></table>";
            } else {
                echo "<p>Nenhum produto associado ao serviço ainda.</p>";
            }
            ?>
            </div>

            <div class="col-md-12 mb-3">
                <div class="d-flex justify-content-end gap-2">
                    <a href='formAtualizarServico.php?id=<?= $idServico ?>' class='btn btn-primary btn-sm'>Atualizar</a>
                    <a href='../../controller/ServicoController.php?acao=excluir&id=<?= $idServico ?>' class='btn btn-danger btn-sm' onclick='return confirm("Tem certeza que deseja excluir?")'>Excluir</a>
                    <a href="servicos.php" class="btn btn-secondary btn me-2">Voltar</a>
                </div>
            </div>


        </div>
    </div>
</div>

<?php include("../../app/footer.php") ?>
