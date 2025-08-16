<?php

// Inclui a conexão com o banco de dados
include_once ("config/conexaoBD.php");

// Inclui todos os Models e Controllers necessários para o roteamento
include_once ('model/Venda.php');
include_once ('model/Financeiro.php');
include_once ('model/Servico.php');
include_once ('controller/DashboardController.php');

// Determina qual Controller e qual método executar.
// Se não houver nada na URL, a ação padrão será 'dashboard'
$acao = $_GET['acao'] ?? 'dashboard';

switch ($acao) {
    case 'dashboard':
        // Ação padrão: carrega o dashboard
        $dashboardController = new DashboardController($conn);
        $dashboardController->exibirDashboard();
        break;
    
    // Futuras ações de outros Controllers podem ser adicionadas aqui
    // case 'produtos':
    //    $produtoController = new ProdutoController($conn);
    //    $produtoController->listarProdutos();
    //    break;
        
    default:
        // Exibe o dashboard em caso de URL inválida
        $dashboardController = new DashboardController($conn);
        $dashboardController->exibirDashboard();
        break;
}

?>