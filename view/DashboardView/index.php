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
                <p class="card-text">R$ <?= $vendasFormatado ?> em vendas este mês</p>
            </div>
        </div>

        <div class="card bg-danger" style="width: 350px; color: white">
            <div class="card-body">
                <h4 class="card-title">Despesas</h4>
                <p class="card-text">R$ <?= $despesasFormatado ?> em despesas este mês</p>
            </div>
        </div>

        <div class="card bg-primary" style="width: 350px; color: white">
            <div class="card-body">
                <h4 class="card-title">Total do Mês - Lucro</h4>
                <p class="card-text">R$ <?= $lucroFormatado ?> de lucro este mês</p>
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

        <!-- Card com Gráfico -->
        <div class="info-card-wrapper">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">Resumo Financeiro do Mês</h5>
                    <canvas id="graficoResumo"></canvas>
                    <p></p>
                    <p class="card-text" style="text-align: justify">
                        Bem-vindo à Gestão Samuka Bikes!
                        Aqui você pode encontrar tudo o que precisa para gerenciar sua loja de bicicletas de forma eficiente.
                        Dúvidas? Fale conosco! (42) 99145-7945
                    </p>
                    <p class="card-text"></p>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('graficoResumo');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Vendas', 'Despesas', 'Lucro'],
            datasets: [{
                label: 'R$',
                data: [
                    <?= $servicosEVendas ?>,
                    <?= $despesasNumerico ?>,
                    <?= $lucroMes ?>
                ],
                backgroundColor: [
                    'rgba(40, 167, 69, 0.7)',
                    'rgba(220, 53, 69, 0.7)',
                    'rgba(0, 123, 255, 0.7)'
                ],
                borderColor: [
                    'rgba(40, 167, 69, 1)',
                    'rgba(220, 53, 69, 1)',
                    'rgba(0, 123, 255, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'R$ ' + value.toLocaleString('pt-BR', {
                                minimumFractionDigits: 2
                            });
                        }
                    }
                }
            }
        }
    });
</script>