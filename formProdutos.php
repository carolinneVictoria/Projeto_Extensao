<?php //include("validarSessao.php") ?>

<?php include("header.php") ?>

<div class="container-fluid text-left">

<h3>Cadastro de Produto:</h3>


    <div class="row-3" style="margin-top: 15px; margin-right: 25px;">

        <div class="col-sm-12">

            <form action="actionProduto.php" class="was-validated" method="POST" enctype="multipart/form-data">

                <div class="row">
    
                    <div class="col-md-6 mb-3">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="nomeProduto" placeholder="Informe o nome do Produto" name="nomeProduto" required>
                            <label for="nomeProduto">Nome do Produto:</label>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="valorProduto" placeholder="Informe o valor do Produto" name="valorProduto" required>
                            <label for="valorProduto">Valor do Produto:</label>
                        </div>
                    </div>

                    <div class="col-md-12 mb-3">
                        <div class="form-floating">
                            <textarea class="form-control" id="descricaoProduto" placeholder="Informe uma descrição do Produto" name="descricaoProduto" style="height: 100px"></textarea>
                            <label for="descricaoProduto">Descrição do Produto:</label>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="form-floating">
                            <select class="form-select" id="categoriaProduto" name="categoriaProduto" required>
                            <option value="" disabled selected>Selecione uma categoria</option>
                            <?php
                            include("conexaoBD.php");

                            $sqlCategorias = "SELECT idCategoria, descricao FROM Categoria";
                            $resultado = mysqli_query($conn, $sqlCategorias);

                            while($linha = mysqli_fetch_assoc($resultado)) {
                            echo "<option value='{$linha['idCategoria']}'>{$linha['descricao']}</option>";
                            }
                            ?>
                            </select>
                            <label for="categoriaProduto">Categoria:</label>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="quantidadeProduto" placeholder="Informe a quantidade" name="quantidadeProduto" required>
                            <label for="quantidadeProduto">Quantidade:</label>
                        </div>
                    </div>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary mt-3">Cadastrar</button>
                </div>

            </form>

        </div>
    </div>
</div>
<br>
<br>

</div>