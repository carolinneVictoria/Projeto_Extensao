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
} else {
    $produtosAssociados = []; 
}
?>

<div class="container-fluid">
    <h3>Detalhes do Serviço:</h3>
    <div class="col-sm-12">

        <div class="row">
            <div class="col-md-6 mb-3">
                <div class="form-floating">
                    <input type="text" class="form-control" id="cliente" readonly value="<?= $cliente['nome']; ?>">
                    <label for="cliente">Cliente:</label>
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <div class="form-floating">
                    <input type="text" class="form-control" id="usuario" readonly value="<?= $usuario['nomeUsuario']; ?>">
                    <label for="usuario">Usuário Responsável:</label>
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <div class="form-floating">
                    <input type="date" class="form-control" id="dataEntrada" readonly value="<?= $servico['dataEntrada']; ?>">
                    <label for="dataEntrada">Data de Entrada:</label>
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <div class="form-floating">
                    <input type="text" class="form-control" id="valorTotal" readonly value="R$ <?= number_format($valorTotal, 2, ',', '.'); ?>">
                    <label for="valorTotal">Valor Total:</label>
                </div>
            </div>

            <div class="col-md-12 mb-3">
                <div class="form-floating">
                    <textarea style="height: 100px" class="form-control" id="descricao" readonly><?= $servico['descricao']; ?></textarea>
                    <label for="descricao">Descrição:</label>
                </div>
            </div>

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
                                <th>AÇÕES</th>
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
                            <td>
                                <a href='formAtualizarProdutoServico.php?idProduto={$registro['idProduto']}&idServico={$registro['idServico']}' class='btn btn-primary btn-sm'>Atualizar</a>
                                <a href='../../controller/ServicoController.php?acao=excluir&id={$registro['idProduto']}&idServico={$idServico}' class='btn btn-danger btn-sm' onclick='return confirm(\"Tem certeza que deseja excluir?\")'>Excluir</a>
                            </td>
                        </tr>
                    ";
                }
                echo "</tbody></table>";
            } else {
                echo "<p>Nenhum produto associado ao serviço ainda.</p>";
            }
            ?>

            <a href="produtoServico.php?id=<?= $idServico ?>" class="btn btn-primary btn-sm">Adicionar Produtos</a>

        </div>
    </div>
</div>

<?php include("../../app/footer.php") ?>
