<!-- Navbar e Barra de Busca -->
<div class="container-fluid bg-dark d-flex position-fixed" style="top: 50px; left: 160px; width: calc(100% - 160px); height: 50px; z-index: 1030;">
  <nav class="navbar navbar-expand-sm navbar-dark bg-dark w-100">
    <div class="container-fluid">
      <div class="collapse navbar-collapse d-flex justify-content-between" id="mynavbar">
          <ul class="navbar-nav mb-4 mb-lg-0">
            <li class="nav-item"><a class="nav-link" href="/Projeto_Extensao/view/CompraView/formCompra.php?acao=cadastrar">Cadastrar Compra de Produtos</a></li>
          </ul>
        <!-- Campo de busca -->
        <form method="GET" action="/Projeto_Extensao/controller/CompraController.php?acao=buscar" class="d-flex me-2" role="search">
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
echo "<h5>Histórico de Compras:</h5>";

echo "
    <table class='table table-hover table-bordered table-sm'>
        <thead class='thead-light'>
            <tr>
                <th>ID</th>
                <th>DESCRIÇÃO</th>
                <th>FORNECEDOR</th>
                <th>DATA DA COMPRA</th>
                <th>VALOR</th>
                <th>AÇÕES</th>
            </tr>
        </thead>";

while ($registro = mysqli_fetch_assoc($compras)) {
  $idCompra = $registro['idCompra'];
    echo "
        <tbody>
            <tr>
                <td>{$registro['idCompra']}</td>
                <td>{$registro['descricao']}</td>
                <td>{$registro['razaoSocial']}</td>
                <td>R$ " . number_format($registro['valorTotal'], 2, ',', '.') . "</td>
                <td>{$registro['data']}</td>
                <td>
                <a href='/Projeto_Extensao/controller/CompraController.php?acao=verCompra&id=$idCompra' class='btn btn-primary btn-sm'>Ver Detalhes</a>
                </td>
            </tr>
        </tbody>
    ";
}
echo "</table>";
?>
<?php include "../../app/footer.php"; ?>

</div>