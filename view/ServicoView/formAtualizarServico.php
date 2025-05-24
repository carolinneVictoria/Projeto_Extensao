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

    <form id="formServico" action="/Projeto_Extensao/controller/ServicoController.php?acao=atualizar" method="POST" class="was-validated">
        <input type="hidden" name="idServico" value="<?= $idServico ?>">

        <div class="row">

            <div class="col-md-3 mb-3">
                <div class="form-floating ">
                    <input type="hidden" name="idCliente" value="<?= $servico['idCliente'] ?>">
                    <input type="text" class="form-control" id="idCliente" value="<?= $cliente['nome']; ?>">
                    <label for="cliente">Cliente:</label>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="form-floating ">
                    <input type="hidden" name="idUsuario" value="<?= $servico['idUsuario'] ?>">
                    <input type="text" class="form-control" id="idUsuario" value="<?= $usuario['nomeUsuario']; ?>">
                    <label for="idUsuario">Usuario:</label>
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <div class="form-floating">
                    <textarea style="height: 100px" class="form-control" id="descricao" name="descricao" ><?= $servico['descricao']; ?></textarea>
                    <label for="descricao">Descrição:</label>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="form-floating ">
                    <input type="date" class="form-control" id="dataEntrada" name="dataEntrada" value="<?= $servico['dataEntrada']; ?>">
                    <label for="dataEntrada">Data de Entrada:</label>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="form-floating border border-success rounded">
                    <input type="hidden" name="valorTotal" value="<?= $valorTotal ?>">
                    <input type="text" class="form-control" id="valorTotal" readonly value="R$ <?= number_format($valorTotal, 2, ',', '.'); ?>">
                    <label for="valorTotal">Valor Total:</label>
                </div>
            </div>


            <div class="col-md-6 mb-3">
                <div class="form-floating">
                    <select class="form-select" id="entrega" name="entrega" required>
                        <option value="1" <?= $servico['entrega']==1?'selected':'' ?>>Não</option>
                        <option value="0" <?= $servico['entrega']==0?'selected':'' ?>>Sim</option>
                    </select>
                    <label for="entrega">Entregue:</label>
                </div>
            </div>

            <h5>Produtos Usados</h5>
            <div class="col-md-12 mb-3">
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
                                <a href='atualizarProdutoServico.php?idProduto={$registro['idProduto']}&idServico={$registro['idServico']}' class='btn btn-primary btn-sm'>Atualizar</a>
                                <a href='../../controller/ServicoController.php?acao=excluirProduto&id={$registro['idProduto']}&idServico={$idServico}' class='btn btn-danger btn-sm' onclick='return confirm(\"Tem certeza que deseja excluir?\")'>Excluir</a>
                            </td>
                        </tr>
                    ";
                }
                echo "</tbody></table>";
            } else {
                echo "<p>Nenhum produto associado ao serviço ainda.</p>";
            }
            ?>
            </div>

            <div class="d-flex justify-content-end mt-3">
                <a href="servicos.php" class="btn btn-secondary btn me-2">Voltar</a>
                <a href="produtoServico.php?id=<?= $idServico ?>" class="btn btn-primary btn me-2">Adicionar Produtos</a>
                <button type="submit" class="btn btn-primary">Atualizar Serviço</button>
            </div>
            <p></p>

        </div>
        </form>
    </div>
</div>

<?php include("../../app/footer.php") ?>
