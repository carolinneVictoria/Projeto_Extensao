<?php include("app/header.php"); ?>

<div style="position: relative; top: 10px;">
    <h4 style="color: black;">Seja Bem-Vindo!</h4>
</div>

<div class="d-flex gap-3" style="margin-top: 20px;">
    <div class="card bg-success" style="width: 350px; color: white">
    <div class="card-body">
        <h4 class="card-title">Vendas</h4>
        <p class="card-text">Total de Vendas!</p>
        <a href="/Projeto_Extensao/view/VendaView/formVenda.php" class="card-link" style="color: white">Fazer uma venda</a>
    </div>
    </div>

    <div class="card bg-danger" style="width: 350px; color: white">
    <div class="card-body">
        <h4 class="card-title">Despesas</h4>
        <p class="card-text">Some example text. Some example text.</p>
        <a href="#" class="card-link"></a>
        <a href="#" class="card-link"></a>
    </div>
    </div>

    <div class="card bg-primary" style="width: 350px; color: white">
    <div class="card-body">
        <h4 class="card-title">Serviços</h4>
        <p class="card-text">Vamos ver se tem algum serviço esperando!! :)</p>
        <a href="/Projeto_Extensao/view/ServicoView/servicos.php" class="card-link" style="color: white">Ver Serviços</a>
    </div>
    </div>

</div>

<?php include("app/footer.php"); ?>