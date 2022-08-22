<?php
date_default_timezone_set("Brazil/East"); // seta configurações fusuhorario para Brasil
ini_set ('default_charset', 'UTF-8'); // seta o php em UTF 8
?>
<script language='Javascript' type='text/javascript'>
function ConfirmaExclusao($id) {
  if( confirm( "Você tem certeza de que deseja excluir este registro?" ) ) {
  	location="minha-conta/?pg=aviseme/excluir.php&id="+$id;
  } else {
    alert("O Registro não foi excluido!");
  }
}
</script>
<h3 class="text-success">Avise-me Quando Disponível</h3>
<hr>
<p>Estes são os últimos registrados de solicitações avise-me, feito por clientes.</p>
<?php 
$sql = $pdo->query("SELECT * FROM aviseme ORDER BY id DESC "); 
$row = $sql->rowCount();
if ($row > 0){
?>
<div class="table-responsive">
<table class="table table-responsive table-bordered table-condensed table-hover table-striped" style="margin-top:15px; font-size:12px;">
    <thead>
      <tr style="background:#265A88; color:#fff;">
        <th>ID</th>
        <th> Cliente</th>
        <th> Tarólogo</th>
        <th> E-mail Cliente</th>
        <th> Celular Cliente</th>
        <th> Data</th>
        <th> Excluir</th>
      </tr>
    </thead>
    <tbody>
    <?php  
        while ($mostrar = $sql->fetch(PDO::FETCH_ASSOC)){  
	        $id=$mostrar['id'];
	        $tarologo_id=$mostrar['tarologo_id'];
	        $tarologo_nome=$mostrar['tarologo_nome'];
	        $cliente_id=$mostrar['cliente_id'];
	        $cliente_nome=$mostrar['cliente_nome'];
	        $cliente_email=$mostrar['cliente_email'];
	        $cliente_celular=$mostrar['cliente_celular'];
	        $data=$mostrar['data'];
	        $data=MostraDataCorretamenteHora ($data);
	        ?>
	      <tr>
	        <td><?php echo $id; ?></td>
	        <td><?php echo $cliente_nome; ?></td>
	        <td><?php echo $tarologo_nome; ?></td>
	        <td><?php echo $cliente_email; ?></td>
	        <td><?php echo $cliente_celular; ?></td>
	        <td><?php echo $data; ?></td>
	        <td>
		        <?php echo "<a href='javascript:;' onclick='ConfirmaExclusao($id);' data-toggle='tooltip' title='Excluir Registro' class=\"btn btn-sm\"><i class='far fa-trash-alt'></i></a>" ?>
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