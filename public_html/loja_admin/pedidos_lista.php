<script language='Javascript' type='text/javascript'>
function ConfirmaExclusao($id) {
  if( confirm( "Você tem certeza de que deseja excluir isso?" ) ) {
  location="minha-conta/?pg=loja_admin/pedidos_excluir.php&id="+$id;
  } else {
    alert("O Registro não foi excluido!");
  }
}
</script>
<?php
include "pedidos_filtro.php";
$ano = date('Y');
$sql = $pdo->query("SELECT * FROM loja_pedidos WHERE data BETWEEN '$ano_escolhido-$tab-01' AND '$ano_escolhido-$tab-31 23:59:00' ORDER BY id DESC ");
$row = $sql->rowCount();
if ($row > 0) {

  // código que soma valores pago no mes
  $datahoje = date("Y-m-d");
  $data_dia = date("d");
  $data_mes = date("m");
  $data_ano = date("Y");
  $sql4 = $pdo->query("SELECT SUM(valor) as soma4 FROM loja_pedidos WHERE status_pagamento='PAGO' AND data BETWEEN '$ano_escolhido-$tab-01' AND '$ano_escolhido-$tab-31 23:59:00'  ");
  $cont4 = $sql4->fetch(PDO::FETCH_ASSOC);
  $valor44 = $cont4["soma4"];
  $valor4 = number_format($valor44, 2, ',', '.');//Formatando para mostrar ao usuario.
  ?>
  <span style="font-size:15px; color:#383C3F;"> Pago: </span><span class="label label-success">R$ <?php echo $valor4; ?></span></strong>
  <!-- código que soma previsão para o mês -->

  <div class="table-responsive">
    <table class="table table-responsive table-bordered table-condensed table-hover table-striped" style="margin-top:15px; font-size:13px;">
      <thead>
        <tr style="background:#265A88; color:#fff;">
          <th>ID</th>
          <th> Cliente</th>
          <th> Telefone</th>
          <th> Data</th>
          <th> Status Pagamento</th>
          <th> Status Entrega</th>
          <th> Cod Rastreio</th>
          <th> Valor</th>
          <th> Cidade</th>
          <th> Visualizar / Editar</th>
          <th> Excluir</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($mostrar=$sql->fetch(PDO::FETCH_ASSOC)){  
        $id=$mostrar['id'];
        $id_nome_cliente=$mostrar['id_cliente'];
        $telefone=$mostrar['telefone'];
        $data=$mostrar['data'];
        $data=MostraDataCorretamenteHora($data);
        $status_pagamento=$mostrar['status_pagamento'];
        $status_entrega=$mostrar['status_entrega'];
        $cod_rastreio=$mostrar['cod_rastreio'];
        $valor=$mostrar['valor'];
        $valor = MostraValorDinheiroCorretamenteNoCifrao($valor);
        $cidade=$mostrar['cidade'];
        $sql22 = $pdo->query("SELECT * FROM clientes WHERE id='$id_nome_cliente' LIMIT 1"); 
        while ($dados22= $sql22->fetch(PDO::FETCH_ASSOC)) {
          $nome_cliente=$dados22['nome'];
        }
        if ($nome_cliente == "") {
          $nome_cliente_compra = "";
        }
        ?>
        <tr>
          <form name="check" id="check" action="" method="post">
            <td style="width:7px;"><?php echo $id; ?></td>
            <td><?php echo "<a href='minha-conta/?pg=clientes/view.php&id=$id_nome_cliente' data-toggle='tooltip' title='$nome_cliente'>$nome_cliente</a>"; ?></td>
            <td><?php echo $telefone; ?></td>
            <td><?php echo $data; ?></td>
            <td>
              <?php 
              if ($status_pagamento == 'Aguardando') {
                $estiloStatusPagExtra = 'label label-default';
              } elseif ($status_pagamento == 'PAGO') {
                $estiloStatusPagExtra = 'label label-success';
              } else {
                $estiloStatusPagExtra = 'label label-default';
              }
              echo '<strong><span class="'.$estiloStatusPagExtra.'">'.$status_pagamento.'</span></strong>';
              ?>
            </td>
            <td>
              <?php 
              if ($status_entrega == 'Preparando') {
                $estiloStatusPagExtraEntrega = 'label label-default';
              } elseif ($status_entrega == 'Em percuso') {
                $estiloStatusPagExtraEntrega = 'label label-primary';
              } elseif ($status_entrega == 'Entregue') {
                $estiloStatusPagExtraEntrega = 'label label-success';
              } else {
                $estiloStatusPagExtraEntrega = 'label label-default';
              }
              echo '<strong><span class="'.$estiloStatusPagExtraEntrega.'">'.$status_entrega.'</span></strong>';
              ?>
            </td>
            <td><?php echo $cod_rastreio; ?></td>
            <td><?php echo $valor; ?></td>
            <td><?php echo $cidade; ?></td>
            <td>
              <?php 
              echo "<a href='minha-conta/?pg=loja_admin/pedidos_editar.php&id=$id'><i class='glyphicon glyphicon-edit' title='Editar'></i> Abrir</a>";
              ?>
            </td>
            <td>
              <?php 
              echo "<a href='javascript:;' onclick='ConfirmaExclusao($id);' data-toggle='tooltip' title='Excluir' class=\"btn btn-sm\"><i class='far fa-trash-alt'></i> Excluir</a>";
              ?>
            </td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
  <?php
} else {
  $msge="Nenhum resultado encontrado...";
  MsgErro($msge);
}
?>
</form>