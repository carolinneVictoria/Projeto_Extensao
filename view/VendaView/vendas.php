<?php include ("../../app/header.php"); ?>
<!-- Navbar e Barra de Busca -->
<div class="container-fluid bg-dark d-flex position-fixed" style="top: 50px; left: 160px; width: calc(100% - 160px); height: 50px; z-index: 1030;">
  <nav class="navbar navbar-expand-sm navbar-dark bg-dark w-100">
    <div class="container-fluid">
      <div class="collapse navbar-collapse d-flex justify-content-between" id="mynavbar">
          <ul class="navbar-nav mb-4 mb-lg-0">
            <li class="nav-item"><a class="nav-link" href="/Projeto_Extensao/view/VendaView/formVenda.php?acao=cadastrar">Realizar Venda</a></li>
          </ul>
        <!-- Campo de busca -->
        <form method="GET" action="/Projeto_Extensao/controller/VendaController.php?acao=buscar" class="d-flex me-2" role="search">
          <input type="hidden" name="acao" value="buscar">
          <input type="text" name="busca" class="form-control me-2" placeholder="Buscar por Nome"value="<?= $_GET['busca'] ?? '' ?>">
          <button class="btn btn-outline-light" type="submit">Buscar</button>
        </form>
      </div>
    </div>
  </nav>
</div>

<!-- Conteúdo principal -->
<div class="container" style="margin-left: -10px; padding-top: 50px;">

<?php
include ('../../config/conexaoBD.php');
require_once ('../../model/Venda.php');

// Instanciando o Model
$vendaModel = new Venda($conn);
// Listando as vendas
$vendas = $vendaModel->listarVendas();

echo "<p></p><h5>Histórico de Vendas:</h5>";

// Exibindo a tabela de vendas
echo "
    <table class='table table-hover table-bordered table-sm'>
        <thead class='thead-light'>
            <tr>
                <th>ID</th>
                <th>PRODUTO/SERVIÇO</th>
                <th>DATA</th>
                <th>VALOR</th>
                <th>FUNCIONÁRIO</th>
                <th>PAGAMENTO</th>
                <th>AÇÕES</th>
            </tr>
        </thead>";

while ($registro = mysqli_fetch_assoc($vendas)) {
  $idVenda = $registro['idVenda'];
    echo "
        <tbody>
            <tr>
                <td>{$registro['idVenda']}</td>
                <td>{$registro['nomeProduto']}</td>
                <td>{$registro['data']}</td>
                <td>R$ " . number_format($registro['valorTotal'], 2, ',', '.') . "</td>
                <td>{$registro['nomeUsuario']}</td>
                <td>{$registro['formaPagamento']}</td>
                <td>
                <a href='verVenda.php?id=$idVenda' class='btn btn-primary brn-sm'>Ver</a>
                </td>
            </tr>
        </tbody>
    ";
}
echo "</table>";
?>
<?php include "../../app/footer.php"; ?>

</div>