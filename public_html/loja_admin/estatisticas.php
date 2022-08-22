<?php
// Estatísticas
$dataCompleta = date("Y-m-d");
$data_dia = date("d");
$data_mes = date("m");
$data_ano = date("Y");
$MostraNomeDoMes = MostraNomeDoMes($data_mes);

function TotalPedidos ($pdo) {
$sql = $pdo->query("SELECT * FROM loja_pedidos "); 
$loja_pedidos = $sql->rowCount();
echo $loja_pedidos;
}
function TotalPedidosMes ($pdo, $data_mes, $data_ano) {
$sql = $pdo->query("SELECT * FROM loja_pedidos WHERE data BETWEEN '$data_ano-$data_mes-01' AND '$data_ano-$data_mes-31 23:59:00'"); 
$resultado = $sql->rowCount();
echo $resultado;
}
function TotalValorMes ($pdo, $data_mes, $data_ano) {
$sql = $pdo->query("SELECT SUM(valor) as soma FROM loja_pedidos WHERE status_pagamento='PAGO' AND data BETWEEN '$data_ano-$data_mes-01' AND '$data_ano-$data_mes-31 23:59:00'"); 
$cont  = $sql->fetch(PDO::FETCH_ASSOC);
$valor = $cont["soma"];
$valor = number_format($valor, 2, ',', '.');//Formatando para mostrar ao usuario.
echo 'R$ <b>'.$valor.'</b>';
}
function QuantidadeProdutos ($pdo) {
$sql = $pdo->query("SELECT * FROM loja_produtos "); 
$loja_produtos = $sql->rowCount();
echo $loja_produtos;
}
?>
<h3 class="text-success">Estatísticas Básicas da Loja</h3>
<hr>
<div class="row">
  <div class="col-md-6">
    <div class="alert alert-info" role="alert">
      <button type="button" class="close" data-dismiss="alert">×</button>
      <strong><i class="glyphicon glyphicon-stats"></i> Pedidos Total: <?php TotalPedidos($pdo); ?></strong>
    </div>
  </div>

  <div class="col-md-6">
    <div class="alert alert-info" role="alert">
      <button type="button" class="close" data-dismiss="alert">×</button>
      <strong><i class="glyphicon glyphicon-stats"></i> Pedidos em <?php echo $MostraNomeDoMes ?>: <?php TotalPedidosMes($pdo, $data_mes, $data_ano); ?></strong>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-6">
    <div class="alert alert-info" role="alert">
      <button type="button" class="close" data-dismiss="alert">×</button>
      <strong><i class="glyphicon glyphicon-stats"></i> Valor Vendas <?php echo $MostraNomeDoMes ?>: <?php TotalValorMes($pdo, $data_mes, $data_ano); ?></strong>
    </div>
  </div>

  <div class="col-md-6">
    <div class="alert alert-info" role="alert">
      <button type="button" class="close" data-dismiss="alert">×</button>
      <strong><i class="glyphicon glyphicon-stats"></i> Quantidade Produtos: <?php QuantidadeProdutos($pdo); ?></strong>
    </div>
  </div>
</div>