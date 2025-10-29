<?php

use Dompdf\Dompdf;
use Dompdf\Options;

include_once "../config/conexaoBD.php";
include_once "../model/Servico.php";
include_once "../model/Venda.php";
include_once "../model/Financeiro.php";

$servicoModel       = new Servico($conn);
$vendaModel         = new Venda($conn);
$financeiroModel    = new Financeiro($conn);

function formRelatorio(){
    include_once '../view/RelatorioView/formRelatorio.php';
}

// Gerar PDF do fluxo de caixa do mês
function exportarFluxoMes($servicoModel, $vendaModel, $financeiroModel){
    require_once '../vendor/autoload.php';

    $mes = isset($_GET['mes']) ? $_GET['mes'] : date('m');
    $ano = isset($_GET['ano']) ? $_GET['ano'] : date('Y');

    $servicos = $servicoModel->buscarServicosPorMes($mes, $ano);
    $vendas   = $vendaModel->buscarVendasPorMes($mes, $ano);
    $contas   = $financeiroModel->buscarContasPorMes($mes, $ano);

    ob_start();
    include '../view/RelatorioView/pdfFluxoMes.php';
    $html = ob_get_clean();

    $options = new Options();
    $options->set('isRemoteEnabled', true);

    $dompdf = new Dompdf($options);
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();
    $dompdf->stream("fluxo_caixa_{$mes}_{$ano}.pdf", ["Attachment" => true]);
}

function visualizarFluxoMes($servicoModel, $vendaModel, $financeiroModel){
    $mes = isset($_GET['mes']) ? $_GET['mes'] : date('m');
    $ano = isset($_GET['ano']) ? $_GET['ano'] : date('Y');

    $servicos = $servicoModel->buscarServicosPorMes($mes, $ano);
    $vendas   = $vendaModel->buscarVendasPorMes($mes, $ano);
    $contas   = $financeiroModel->buscarContasPorMes($mes, $ano);

    $totalServicos = 0;
    $totalVendas   = 0;
    $totalContas   = 0;

    // Serviços
    $servicosArray = [];
    if($servicos && mysqli_num_rows($servicos) > 0){
        while($s = mysqli_fetch_assoc($servicos)){
            $s['valorTotal'] = $s['valorTotal'] ?? 0;
            $totalServicos += $s['valorTotal'];
            $servicosArray[] = $s;
        }
    }
    $servicos = $servicosArray;

    //Vendas
    $vendasArray = [];
    $totalVendas = 0;

    if($vendas && mysqli_num_rows($vendas) > 0){
        while($v = mysqli_fetch_assoc($vendas)){
            $idVenda = $v['idVenda'];

            $produtosVenda = $vendaModel->buscarProdutosPorVenda($idVenda);

            foreach($produtosVenda as $p){
                $totalItem = $p['quantidade'] * $p['valorUnitario'];
                $totalVendas += $totalItem;

                $vendasArray[] = [
                    'idVenda'       => $idVenda,
                    'nomeProduto'   => $p['nomeProduto'],
                    'quantidade'    => $p['quantidade'],
                    'valorUnitario' => $p['valorUnitario'],
                    'totalItem'     => $totalItem
                ];
            }
        }
    }

    $vendas = $vendasArray;

    // Contas
    $contasArray = [];
    if($contas && mysqli_num_rows($contas) > 0){
        while($c = mysqli_fetch_assoc($contas)){
            $c['valorTotal'] = $c['valorTotal'] ?? 0;
            $c['statusText'] = ($c['status'] ?? 0) == 1 ? 'Pago' : 'Não Pago';
            $totalContas += $c['valorTotal'];
            $contasArray[] = $c;
        }
    }
    $contas = $contasArray;

    include '../view/RelatorioView/visualizarFluxoMes.php';
}

if (isset($_GET['acao'])){
    $acao = $_GET['acao'];
    if($acao == 'listar'){
        formRelatorio();
    } elseif($acao == 'exportarFluxoMes'){
        exportarFluxoMes($servicoModel, $vendaModel, $financeiroModel);
    } elseif($acao == 'visualizarFluxoMes'){
        visualizarFluxoMes($servicoModel, $vendaModel, $financeiroModel);
    }
} else {
    formRelatorio();
}
?>