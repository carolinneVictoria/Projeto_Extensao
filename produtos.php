<?php include "header.php"; ?>

<!-- Navbar horizontal dentro do conteúdo principal -->
<nav class="navbar navbar-expand-sm navbar-dark bg-dark " >
  <div class="container w-100">
    
    <div class="collapse navbar-collapse" id="mynavbar">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" href="formProdutos.php">Cadastrar novo</a>
        </li>
      </ul>
      <form class="d-flex" role="search">
        <input class="form-control me-2" type="search" placeholder="Buscar" aria-label="Buscar">
        <button class="btn btn-outline-light" type="submit">Buscar</button>
      </form>
    </div>
  </div>
</nav>


<?php

    include_once "conexaoBD.php"; //Inclui o arquivo de conexão com o BD
    $listarProdutos = "SELECT * FROM Produto"; //Query para selecionar TODOS o Produtos
    $res = mysqli_query($conn, $listarProdutos) or die("Erro ao tentar listar produtos!" . mysqli_error($conn));

    $totalProdutos = mysqli_num_rows($res); //Retorna o total de registros retornado pela Query

    echo "<h4>Produtos cadastrados: $totalProdutos</h4>";


    //Monta o cabeçalho da tabela para exibir os registros
    echo "
        <table class='table'>
            <thead class='thead-light'>
                <tr>
                    <th>ID</th>
                    <th>NOME</th>
                    <th>DESCRICAO</th>
                    <th>QUANTIDADE</th>
                    <th>VALOR</th>
                    <th>CATEGORIA</th>
                </tr>
            </thead>";

            //Varre a tabela enquanto houverem registros e armazena-os em um array
            while ($registro = mysqli_fetch_assoc($res)){
                //Cria variáveis PHP e armazen os registros nelas
                $idProduto           = $registro["idProduto"];
                $nomeProduto         = $registro["nomeProduto"];
                $descricaoProduto    = $registro["descricaoProduto"];
                $quantidadeProduto   = $registro["quantidadeProduto"];
                $valorProduto        = $registro["valorProduto"];
                $categoriaProduto    = $registro["idCategoria"];
                

                echo "
                    <tbody>
                        <tr>
                            <td>$idProduto</td>
                            <td>$nomeProduto</td>
                            <td>$descricaoProduto</td>
                            <td>$quantidadeProduto</td>
                            <td>$valorProduto</td>
                            <td>$categoriaProduto</td>
                        </tr>
                    </tbody>
                ";
            }
        echo "</table>";

?>

<?php include "footer.php"; ?>
