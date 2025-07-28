<?php include("app/header.php");
include_once "config/conexaoBD.php";

$mesAtual = date('m');
$anoAtual = date('Y');

// Vendas do mês
$sqlVendas = "SELECT SUM(valorTotal) as totalVendas FROM venda
              WHERE MONTH(data) = $mesAtual AND YEAR(data) = $anoAtual";
$resultVendas = mysqli_query($conn, $sqlVendas);
$vendasMes = mysqli_fetch_assoc($resultVendas)['totalVendas'] ?? 0;
$vendasMes = number_format($vendasMes, 2, ',', '.');

// Despesas do mês
$sqlDespesas = "SELECT SUM(valorTotal) as totalDespesas FROM financeiro
                WHERE status = 'a pagar' AND MONTH(dataVencimento) = $mesAtual AND YEAR(dataVencimento) = $anoAtual";
$resultDespesas = mysqli_query($conn, $sqlDespesas);
$despesasMes = mysqli_fetch_assoc($resultDespesas)['totalDespesas'] ?? 0;
$despesasMes = number_format($despesasMes, 2, ',', '.');
?>


<style>
    body {
        margin: 0; 
        padding: 0; 
        background-color: #f8f9fa; 
    }

    .bottom-section-layout {
        display: flex;
        gap: 20px;
        margin-top: 20px;
    }
    .carousel-wrapper {
        width: 60%;
        flex-shrink: 0;
    }
    .info-card-wrapper {
        width: 35%;
        flex-shrink: 0;
    }
    .carousel-inner {
        border-radius: 8px;
        overflow: hidden;
    }
    .carousel-item img {
        height: 400px;
        object-fit: cover;
        width: 100%;
    }
    .card {
        border: none;
        border-radius: 8px;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }
    .info-card-wrapper .card {
        height: 100%;
    }
</style>

<div class="main-background-container">

    <div style="position: relative; top: 10px;">
        <h4 style="color: black;">Seja Bem-Vindo!</h4>
    </div>

    <div class="d-flex gap-3" style="margin-top: 20px;">
        <div class="card bg-success" style="width: 350px; color: white">
            <div class="card-body">
                <h4 class="card-title">Vendas</h4>
                <p class="card-text">R$ <?= $vendasMes ?> em vendas este mês</p>
                <a href="/Projeto_Extensao/view/VendaView/vendas.php" class="card-link" style="color: white">Ver detalhes</a>
            </div>
        </div>

        <div class="card bg-danger" style="width: 350px; color: white">
            <div class="card-body">
                <h4 class="card-title">Despesas</h4>
                <p class="card-text">R$ <?= $despesasMes ?> em despesas este mês</p>
                <a href="/Projeto_Extensao/view/FinanceiroView/contas.php" class="card-link" style="color: white">Ver detalhes</a>
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

    <!-- Carrossel e Card de Informações da Loja -->
    <div class="bottom-section-layout">
        <!-- Carrossel -->
        <div class="carousel-wrapper">
            <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                </div>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="img/bicicleta.jpg" class="d-block w-100" alt="Bicicleta 1">
                    </div>
                    <div class="carousel-item">
                        <img src="img/bicicleta2.jpg" class="d-block w-100" alt="Bicicleta 2">
                    </div>
                    <div class="carousel-item">
                        <img src="img/bicicleta3.jpg" class="d-block w-100" alt="Bicicleta 3">
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Anterior</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Próximo</span>
                </button>
            </div>
        </div>

        <!-- Card com Informações da Loja (40% da largura) -->
        <div class="info-card-wrapper">
            <div class="card h-100">
                <div class="card-body"> <!-- adicionar cor aqui -->
                    <h5 class="card-title">Informações da Loja</h5>
                    <p class="card-text">
                        Bem-vindo à Gestão Samuka Bikes!
                        Aqui você pode encontrar tudo o que precisa para gerenciar sua loja de bicicletas de forma eficiente.
                        Acompanhe suas vendas, gerencie despesas, visualize serviços, controle seus clientes e fornecedores,
                        mantenha seu estoque atualizado e gerencie os usuários do sistema.
                    </p>
                    <p class="card-text">
                        Qualquer dúvida ou sugestão, entre em contato conosco!
                    </p>
                    <a href="#" class="btn btn-primary">Entre em Contato</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Inclui o Bootstrap JS para que o carrossel funcione -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<?php include("app/footer.php"); ?>