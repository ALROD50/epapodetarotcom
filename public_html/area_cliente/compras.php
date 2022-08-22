<?php
  $ano = date('Y');

  //Verifica se cliente tem crédito
  $sql_credito = $pdo->query("SELECT SUM(minutos_dispo) as soma FROM controle WHERE id_nome_cliente='$usuario_id' AND status='PAGO' "); 
  $cont = $sql_credito->fetch(PDO::FETCH_ASSOC);
  $valor = $cont["soma"];

  //Selecionando compras do cliente.
  $sql = $pdo->query("SELECT * FROM controle WHERE id_nome_cliente ='$usuario_id' ORDER BY id DESC ");
  $row = $sql->rowCount();
  if ($row > 0){
?>

<h3 class="text-success">Planos Contratados</h3>

Minutos Disponíveis: <strong><?php echo $valor; ?></strong></br>

<div class="table-responsive">
<table class="table table-responsive table-bordered table-condensed table-hover table-striped" style="margin-top:15px; font-size:13px;">
<thead>
  <tr style="background:#265A88; color:#fff;">
    <th>ID</th>
    <th> Abrir</th>
    <th> Plano</th>
    <th> Valor</th>
    <th> Status</th>
    <th> Cod Pagto.</th>
    <th> Data.</th>
    <th> Método</th>
  </tr>
</thead>
<tbody>
  <?php  while ($mostrar = $sql->fetch(PDO::FETCH_ASSOC)){  
      $id=$mostrar['id'];
      $id_nome_cliente=$mostrar['id_nome_cliente'];
      $ref=$mostrar['ref'];
      $minutos=$mostrar['minutos'];
      $valor=$mostrar['valor'];
      $minutos_dispo=$mostrar['minutos_dispo'];
      $cod_pagamento=$mostrar['cod_pagamento'];
      $status=$mostrar['status'];
      $data=$mostrar['data'];
      $data=MostraDataCorretamenteHora($data);
      $metodo=$mostrar['metodo'];
      $url=$mostrar['url'];
  ?>
  <tr>
    <form name="check" id="check" action="" method="post">
      <td style="width:7px;"><?php echo $id; ?></td>
      <td><?php echo "<a href='$url' target='_blank'>ABRIR COBRANÇA</a>"; ?></td>
      <td><?php echo $minutos.' Minutos'; ?></td>
      <td><?php echo $valor; ?></td>
      <td>
        <?php 
          if ($status == 'Aguardando') {
              $estiloStatusPagExtra = 'label label-default';
            } elseif ($status == 'PAGO') {
              $estiloStatusPagExtra = 'label label-success';
            } else {
              $estiloStatusPagExtra = 'label label-default';
            }
            echo '<strong><span class="'.$estiloStatusPagExtra.'">'.$status.'</span></strong>';
         ?>
       </td>
      <!-- <td><?php //echo $minutos_dispo; ?></td> -->
      <td><?php echo $cod_pagamento; ?></td>
      <td><?php echo $data; ?></td>
      <td><?php echo $metodo; ?></td>
  </tr>
  <?php } ?>
</tbody>
</table>
</div>
    <?php
  }else{
    $msge="Nenhum resultado encontrado...";
    MsgErro ($msge);
    }
?>
</form>