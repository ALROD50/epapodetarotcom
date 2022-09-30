<script language='Javascript' type='text/javascript'>
function ConfirmaExclusao($id) {
  if( confirm( "Você tem certeza de que deseja excluir isso?" ) ) {
  location="minha-conta/?pg=controle/excluir.php&id="+$id;
  } else {
    alert("O Registro não foi excluido!");
  }
}
function toggle(source) {
  checkboxes = document.getElementsByName('id_select[]');
  for(var i=0, n=checkboxes.length;i<n;i++) {
    checkboxes[i].checked = source.checked;
  }
}
</script>

<?php echo "<a href='minha-conta/?pg=controle/add_credito.php&tab=$tab&mesatual=$mesatual' title='Adicionar Crédito' class=\"btn btn-success\" style=\"float: left; margin-right: 20px;\"><i class=\"fas fa-money-bill-alt\"></i> Adicionar Crédito</a>"; ?>

<?php
include "filtro.php";
$ano = date('Y');
$sql = $pdo->query("SELECT * FROM controle WHERE data BETWEEN '$ano_escolhido-$tab-01' AND '$ano_escolhido-$tab-31 23:59:00' ORDER BY id DESC ");
$row = $sql->rowCount();
if ($row > 0){
?>

<!-- código que soma valores pago no mes -->
<?php
$datahoje = date("Y-m-d");
$data_dia = date("d");
$data_mes = date("m");
$data_ano = date("Y");
$sql4 = $pdo->query("SELECT SUM(valor) as soma4 FROM controle WHERE status='PAGO' AND data BETWEEN '$ano_escolhido-$tab-01' AND '$ano_escolhido-$tab-31 23:59:00'  ");
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
    <th><input type="checkbox" onClick="toggle(this)" /></th>
    <th> Cliente</th>
    <th> Plano</th>
    <th> Valor</th>
    <th> Status</th>
    <th> Cod</th>
    <th> Data</th>
    <th> Método</th>
    <th> Tipo</th>
    <th> Venc</th>
    <th> URL</th>
    <th> Dem</th>
    <th></th>
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
    $data=MostraDataCorretamenteHora ($data);
    $metodo=$mostrar['metodo'];
    $tipo=$mostrar['tipo'];
    $vencimento=$mostrar['vencimento'];
    $url=$mostrar['url'];
    $demonstrativo=$mostrar['demonstrativo'];

    $sql22 = $pdo->query("SELECT * FROM clientes WHERE id='$id_nome_cliente' LIMIT 1"); 
    $rows = $sql22->rowCount();
    if ($rows >= 1) {
      while ($dados22= $sql22->fetch(PDO::FETCH_ASSOC)){
        $nome_cliente_compra=$dados22['nome'];
        $nome_cliente_compra = ucwords(strtolower($nome_cliente_compra));
        $telefone =  $dados22['telefone'];
        $telefone =  remover_caracter($telefone); 
        $telefone =  preg_replace("/_/", "", $telefone);
      }
    } else {
      $nome_cliente_compra = "";
    }
  ?>
  <tr>
    <form name="check" id="check" action="" method="post">
      <td style="width:7px;"><input type="checkbox" name="id_select[]" id="id_select" value="<?php echo $id; ?>"/><?php echo $id; ?></td>
      <td><a href='<?php echo "https://api.whatsapp.com/send?phone=55$telefone&text=Oi $nome_cliente_compra, tudo bem? Sou a Patricia aqui do É Papo de Tarot, vi que é nova no site. Posso te ajudar a fazer sua consulta com nossos tarólogos?"; ?>' target="_Blank"><i class="fab fa-whatsapp"></i></a> <?php echo "<a href='minha-conta/?pg=clientes/view.php&id=$id_nome_cliente' data-toggle='tooltip' title='$nome_cliente_compra'>$nome_cliente_compra</a>"; ?></td>
      <td><?php echo $minutos.' Minutos'; ?></td>
      <td><?php echo $valor; ?></td>
      <td>
        <?php 
        if ($status == 'Aguardando') {
            $estiloStatusPagExtra = 'badge badge-pill badge-dark p-1 pb-2';
          } elseif ($status == 'PAGO') {
            $estiloStatusPagExtra = 'badge badge-pill badge-success p-1 pb-1';
          } else {
            $estiloStatusPagExtra = 'badge badge-pill badge-warning p-1 pb-1';
          }
          echo '<strong><span class="'.$estiloStatusPagExtra.'">'.$status.'</span></strong>';
        ?>
      </td>
      <td style="font-size:8px;"><?php echo $cod_pagamento; ?></td>
      <td><?php echo $data; ?></td>
      <td><?php echo $metodo; ?></td>
      <td><?php echo $tipo; ?></td>
      <td><?php echo $vencimento; ?></td>
      <td><?php echo "<a href='$url' target='_blank'>LINK</a>"; ?></td>
      <td><?php echo "<a href='#' data-toggle='tooltip' title='$demonstrativo'>Serviço</a>"; ?></td>
      <td>
        <?php 
        echo "<a href='minha-conta/?pg=controle/editar_compra.php&id=$id'><i class=\"fas fa-edit\"></i></a> / <a href='javascript:;' onclick='ConfirmaExclusao($id);' data-toggle='tooltip' title='Excluir Pagamento' class=\"btn btn-sm\"><i class='far fa-trash-alt'></i></a>";
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

<input type="submit" name="excluir_check_box" value="Excluir Itens" class="btn btn-danger" style="margin-top:-10px; margin-bottom:50px;"/>

</form>

<?php 
if(isset($_POST['excluir_check_box'])) {
  // Pega os id's vindo do post.
  $arr = $_POST['id_select'];
  // Faz um loop com todos os id's
  for($i=0; $i < count($arr); $i++) { 
    // Estacia um id de cada vez.
    $id = $arr[$i];
    // Deleta
    $pdo->query("DELETE FROM controle WHERE id='$id'");
  }
  $msgs="Registros Excluidos Com Sucesso!";
  echo "<script>document.location.href='minha-conta/?pg=controle/controle.php&msgs=$msgs'</script>";
}
?>