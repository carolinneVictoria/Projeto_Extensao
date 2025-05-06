<?php include("header.php"); ?>

<?php

    //Bloco para declaração das variáveis
    $nomeProduto= $descricaoProduto = $quantidadeProduto = $valorProduto = $categoriaProduto = "";
    $erroPreenchimento = false; //Variável para controle de erros durante o preenchimento do formulário

    //Verifica o método de envio do FORM
    if($_SERVER["REQUEST_METHOD"] == "POST"){

        //Utiliza a função empty para verificar se o campo nomeProduto(form) está vazio
        if(empty($_POST["nomeProduto"])){
            echo "<div class='alert alert-warning text-center'>O campo <strong>NOME</strong> é obrigatório!</div>";
            $erroPreenchimento = true; //Em caso de erro, a variável passa a ser verdadeira
        } else{
            $nomeProduto = filtrar_entrada($_POST["nomeProduto"]); //Caso não hajam erros, a variável PHP recebe o valor que foi preenchido no formulário
        }

        //Validação do campo descricaoProduto
        $descricaoProduto = filtrar_entrada($_POST["descricaoProduto"]);

        //Validação do campo quantidadeProduto
        if(empty($_POST["quantidadeProduto"])){
            echo "<div class='alert alert-warning text-center'>O campo <strong>QUANTIDADE</strong> é obrigatório!</div>";
            $erroPreenchimento = true;
        } else{
            $quantidadeProduto = filtrar_entrada($_POST["quantidadeProduto"]);
        }

        //Validação do campo valorProduto
        if(empty($_POST["valorProduto"])){
            echo "<div class='alert alert-warning text-center'>O campo <strong>VALOR DO PRODUTO</strong> é obrigatório!</div>";
            $erroPreenchimento = true;
        } else{
            $valorProduto = filtrar_entrada($_POST["valorProduto"]);
        }

        //Validação do campo categoriaProduto
        if(empty($_POST["categoriaProduto"])){
            echo "<div class='alert alert-warning text-center'>O campo <strong>CATEGORIA</strong> é obrigatório!</div>";
            $erroPreenchimento = true;
        } else{
            $idCategoria = filtrar_entrada($_POST["categoriaProduto"]);
        }

        
        //Se NÃO houver erro de preenchimento (caso a variável de controle esteja com o valor 'false')
        if(!$erroPreenchimento && !$erroUpload){

            //Cria a Query para realizar a inserção das informações na tabela Produtos
            $inserirProduto = "INSERT INTO Produto (nomeProduto, descricaoProduto, quantidadeProduto, valorProduto, idCategoria)
                            VALUES ('$nomeProduto', '$descricaoProduto', '$quantidadeProduto', $valorProduto, '$idCategoria')"; 

            //Inclui o arquivo para conexão com o Banco de Dados
            include("conexaoBD.php");

            //Utiliza a função mysqli_query para executar a QUERY no Banco de Dados
            if(mysqli_query($conn, $inserirProduto)){

                echo "
                    <div class='alert alert-success text-center'>Produto cadastrado com sucesso!</div>
                    <div class='container mt-3'>
                        <div class='table-responsive'>
                            <table class='table'>
                                <tr>
                                    <th>NOME</th>
                                    <td>$nomeProduto</td>
                                </tr>
                                <tr>
                                    <th>DESCRIÇÃO</th>
                                    <td>$descricaoProduto</td>
                                </tr>
                                <tr>
                                    <th>QUANTIDADE</th>
                                    <td>$quantidadeProduto</td>
                                </tr>
                                <tr>
                                    <th>VALOR DO PRODUTO</th>
                                    <td>$valorProduto</td>
                                </tr>
                                <tr>
                                    <th>CATEGORIA</th>
                                    <td>$categoriaProduto</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                ";
            }
            else{
                echo "<div class='alert alert-danger text-center'>Erro ao tentar cadastrar produto!</div>" . mysqli_error($conn);
                echo "<p>$inserirProduto</p>";
            }
            echo "<div class='text-end' style='margin-right: 30px;' ><a href='produtos.php' class='btn btn-success'>Voltar</a></div>";
        }

    }

    //Função para filtrar as entradas de dados do formulário para evitar SQL Injection
    function filtrar_entrada($dado){
        $dado = trim($dado); //Remove espaços desnecessários
        $dado = stripslashes($dado); //Remove as barras invertidas
        $dado = htmlspecialchars($dado); //Converte caracteres especiais em entidades HTML

        return($dado); //Retorna o dado já filtrado
    }

?>