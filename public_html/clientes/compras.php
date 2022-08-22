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
function confirmacao(){
  document.getElementById("check").submit();
}
</script>

<h3 class="text-success">Planos Contratados</h3>
<hr>

<?php echo "<a href='minha-conta/?pg=controle/add_credito.php&cliente=$id' title='Adicionar Crédito' class=\"btn btn-success mb-2\"><i class=\"fas fa-money-bill-alt\"></i> Adicionar Crédito $nome</a>"; ?>

<?php
require_once 'includes/conexaoPdo.php';
$pdo = conexao();
$id = @$_GET['id'];
$ano = date('Y');

//Verifica se cliente tem crédito
$sql_credito = $pdo->query("SELECT SUM(minutos_dispo) as soma FROM controle WHERE id_nome_cliente='$id' AND status='PAGO'"); 
$cont = $sql_credito->fetch(PDO::FETCH_ASSOC);
$valor = $cont["soma"];

//Selecionando compras do cliente.
$sql = $pdo->query("SELECT * FROM controle WHERE id_nome_cliente ='$id' ORDER BY id DESC ");
$row = $sql->rowCount();
if ($row > 0){
?>

<button onclick='confirmacao();' class="btn btn-danger" name="excluir_check_box" id="excluir_check_box"><i class="fas fa-trash-alt"></i> Excluir Itens</button></br>

Minutos Disponíveis: <strong><?php echo $valor; ?></strong></br>

<div class="table-responsive">
<table class="table table-responsive table-bordered table-condensed table-hover table-striped" style="margin-top:15px; font-size:13px;">
<thead>
  <tr style="background:#265A88; color:#fff;">
    <th><input type="checkbox" onClick="toggle(this)" /></th>
    <th>ID</th>
    <th> Cliente</th>
    <th> Plano</th>
    <th> Valor</th>
    <th> Status</th>
    <!-- <th> M. Dispo.</th> -->
    <th> Cod Pagto.</th>
    <th> Data.</th>
    <th> Venc</th>
    <th> Método</th>
    <th> URL</th>
    <th> Opções</th>
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
    $url=$mostrar['url'];
    $vencimento=$mostrar['vencimento'];
    $vencimento=MostraDataCorretamente ($vencimento);

    $sql22 = $pdo->query("SELECT * FROM clientes WHERE id='$id_nome_cliente' LIMIT 1"); 
    while ($dados22= $sql22->fetch(PDO::FETCH_ASSOC)){
      $nome_cliente_compra=$dados22['nome'];
    }
  ?>
  <tr>
    <form name="check" id="check" action="" method="post">
      <td><input type="checkbox" name="id_select[]" id="id_select" value="<?php echo $id; ?>"></td>
      <td style="width:7px;"><?php echo $id; ?></td>
      <td><?php echo $nome_cliente_compra; ?></td>
      <td><?php echo $minutos.' Minutos'; ?></td>
      <td><?php echo $valor; ?></td>
      <td><?php echo $status; ?></td>
      <!-- <td><?php //echo $minutos_dispo; ?></td> -->
      <td><?php echo $cod_pagamento; ?></td>
      <td><?php echo $data; ?></td>
      <td><?php echo $vencimento; ?></td>
      <td><?php echo $metodo; ?></td>
      <td><?php echo "<a href='$url' target='_blank'>LINK</a>"; ?></td>
      <td>
        <?php 
        echo "<a href='minha-conta/?pg=clientes/editar_compra.php&id_nome_cliente=$id_nome_cliente&id_plano=$id'><i class='glyphicon glyphicon-edit' title='Editar'></i></a>"; 
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
    MsgErro ($msge);
  }
?>
</form>

<?php 
if(isset($_POST['id_select'])) {
  // Pega os id's vindo do post.
  $arr = $_POST['id_select'];
  // Faz um loop com todos os id's
  for($i=0; $i < count($arr); $i++) { 
    // Estacia um id de cada vez.
    $id = $arr[$i];
    // Deleta
    $pdo->query("DELETE FROM controle WHERE id='$id'");
  }
  $id = @$_GET['id'];
  $msgs="Registros Excluidos Com Sucesso!";
  echo "<script>document.location.href='minha-conta/?pg=clientes/view.php&id=$id&msgs=$msgs'</script>";
}
?>