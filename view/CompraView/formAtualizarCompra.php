<div class="container-fluid"><p></p>
    <h4>Atualizar Compra:</h4>
    <div class="col-sm-12">

        <form id="formCompra" action="/Projeto_Extensao/controller/CompraController.php?acao=atualizar" method="POST" class="was-validated">
            <div class="row mt-4">

            <input type="hidden" name="idCompra" value="<?= $compra['idCompra']; ?> ">

                <!-- Usuário -->
                <div class="col-md-3 mb-3">
                    <div class="form-floating border rounded">
                        <select class="form-select" id="idUsuario" name="idUsuario" required>
                            <option value="">Selecione</option>
                            <?php foreach ($usuarios as $usuario): ?>
                                <option value="<?= $usuario['idUsuario'] ?>" <?= ($usuario['idUsuario'] == $compra['idUsuario']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($usuario['nomeUsuario']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <label for="idUsuario">Usuário:</label>
                    </div>
                </div>

                <!-- Fornecedor -->
                <div class="col-md-3 mb-3">
                    <div class="form-floating border rounded">
                        <select class="form-select" id="idFornecedor" name="idFornecedor" required>
                            <option value="">Selecione</option>
                            <?php foreach ($fornecedores as $fornecedor): ?>
                                <option value="<?= $fornecedor['idFornecedor'] ?>" <?= ($fornecedor['idFornecedor'] == $compra['idFornecedor']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($fornecedor['razaoSocial']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <label for="idFornecedor">Fornecedor:</label>
                    </div>
                </div>


                <!-- Data de Entrada -->
                <div class="col-md-3 mb-3">
                    <div class="form-floating">
                        <input type="date" class="form-control" id="data" name="data" value="<?= htmlspecialchars($compra['data']); ?>" required>
                        <label for="data">Data da compra:</label>
                    </div>
                </div>

                <!-- Valor Total -->
                <div class="col-md-3 mb-3">
                    <div class="form-floating">
                        <input type="text" class="form-control" id="valorTotal" name="valorTotal" value="<?= htmlspecialchars($compra['valorTotal']); ?>" required>
                        <label for="valorTotal">Valor Total:</label>
                    </div>
                </div>

                <!-- Descrição -->
                <div class="col-md-12 mb-4">
                    <div class="form-floating">
                        <input type="text" class="form-control" id="descricao" name="descricao" value="<?= htmlspecialchars($compra['descricao']); ?>" required>
                        <label for="descricao">Descrição:</label>
                    </div>
                </div>

                <h5>Produtos</h5>
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
                                <a href='atualizarProdutoCompra.php?idProduto={$registro['idProduto']}&idCompra={$registro['idCompra']}' class='btn btn-primary btn-sm'>Atualizar</a>
                                <a href='../../controller/CompraController.php?acao=excluirProduto&id={$registro['idProduto']}&idCompra={$idCompra}' class='btn btn-danger btn-sm' onclick='return confirm(\"Tem certeza que deseja excluir?\")'>Excluir</a>
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
                    <a href="../view/CompraView/produtoCompra.php?id=<?= $idCompra ?>" class="btn btn-primary btn me-2">Adicionar Produtos</a>
                    <button type="submit" class="btn btn-primary">Atualizar</button>
                </div>
                <p></p>
            </div>
            </div>
        </form>
    </div>
</div>
