<?php

include_once __DIR__ . '/../model/Venda.php';
include_once __DIR__ . '/../model/Financeiro.php'; 
include_once __DIR__ . '/../model/Servico.php';

class DashboardController {
    
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function exibirDashboard() {
        $mesAtual = date('m');
        $anoAtual = date('Y');

        $vendaModel = new Venda($this->conn);
        $despesaModel = new Financeiro($this->conn);
        $servicoModel = new Servico($this->conn);
        
        $vendasNumerico = $vendaModel->totalVendasPorMes($mesAtual, $anoAtual);
        $despesasNumerico = $despesaModel->totalDespesasPorMes($mesAtual, $anoAtual);
        $servicosNumerico = $servicoModel->totalServicosPorMes($mesAtual, $anoAtual);

        $lucroMes = $vendasNumerico + $servicosNumerico - $despesasNumerico;
        
        $vendasFormatado = number_format($vendasNumerico, 2, ',', '.');
        $despesasFormatado = number_format($despesasNumerico, 2, ',', '.');
        $lucroFormatado = number_format($lucroMes, 2, ',', '.');

        include_once __DIR__ . '/../app/header.php';
        include_once __DIR__ . '/../view/DashboardView/index.php';
        include_once __DIR__ . '/../app/footer.php';
    }
}