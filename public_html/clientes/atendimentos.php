<script language='Javascript' type='text/javascript'>
function ConfirmaExclusaoAtendimento($cod_consulta) {
  if( confirm( "Você tem certeza de que deseja excluir este atendimento?" ) ) {
  location="minha-conta/?pg=atendimentos/excluir.php&cod_consulta="+$cod_consulta;
  } else {
    alert("O Registro não foi excluido!");
  }
}
</script>

<h3 class="text-success">Atendimentos Realizados</h3>
<hr>
<?php 
$id = @$_GET['id'];
$sql = $pdo->query("SELECT * FROM atendimento WHERE id_cliente='$id' ORDER BY id DESC "); 
$row = $sql->rowCount();

if ($row > 0) {
?>
<div class="table-responsive">
	<table class="table table-responsive table-bordered table-condensed table-hover table-striped" style="margin-top:15px; font-size:12px;">
	    <thead>
	      <tr style="background:#265A88; color:#fff;">
	        <th>ID</th>
	        <th> Cliente</th>
	        <th> Tarólogo</th>
	        <th> Código Consulta</th>
	        <th> Data</th>
	        <th> Cred Ini.</th>
	        <th> Duração</th>
	        <th> Cred Fin.</th>
	        <th> Ver Conversa</th>
	        <th> </th>
	      </tr>
	    </thead>
	    <tbody>
		    <?php  
	        while ($mostrar = $sql->fetch(PDO::FETCH_ASSOC)) {  
		        $id=$mostrar['id'];
		        $id_cliente=$mostrar['id_cliente'];
		        $id_tarologo=$mostrar['id_tarologo'];
		        $cod_consulta=$mostrar['cod_consulta'];
		        $data=$mostrar['data'];
		        $data=MostraDataCorretamenteHora ($data);
		        $duracao=$mostrar['duracao'];
		        $cred_inicial=$mostrar['cred_inicial'];
		        $cred_final=$mostrar['cred_final'];
		        $registroux=$mostrar['registrou'];
		        $paginax=$mostrar['pagina'];

		        //Estancia dados do tarólogo
		        $dadoss4 = "SELECT * FROM clientes WHERE id='$id_tarologo'"; 
		        $executa4 = $pdo->query( $dadoss4);
		          while ($dadoss4= $executa4->fetch(PDO::FETCH_ASSOC)) {
		          $tarologo_id=$dadoss4['id'];
		          $tarologo_nome=$dadoss4['nome'];
		        }
		        $row = $executa4->rowCount();
		        if ($row == 0) { $tarologo_nome=""; }

		        //Estancia dados do cliente
		        $dadoss3 = "SELECT * FROM clientes WHERE id='$id_cliente'"; 
		        $executa3 = $pdo->query( $dadoss3);
		          while ($dadoss3= $executa3->fetch(PDO::FETCH_ASSOC)) {
		          $cliente_id=$dadoss3['id'];
		          $cliente_nome=$dadoss3['nome'];
		        }
		        $row = $executa3->rowCount();
		        if ($row == 0) { $cliente_nome=""; }
		        ?>
				<tr>
					<td><?php echo $id; ?></td>
					<td>
						<?php echo @"<a href='minha-conta/?pg=clientes/view.php&id=$cliente_id' data-toggle='tooltip' title='$cliente_nome'>$cliente_nome</a>";?>
					</td>
					<td>
						<?php echo @"<a href='minha-conta/?pg=tarologos_admin/view.php&id=$tarologo_id' data-toggle='tooltip' title='$tarologo_nome'>$tarologo_nome</a>";?>
					</td>
					<td><?php echo @"<span data-toggle='tooltip' title='$registroux - $paginax'>$cod_consulta</span>";?></td>
					<td><?php echo $data; ?></td>
					<td><?php echo $cred_inicial; ?></td>
					<td><?php echo $duracao; ?></td>
					<td><?php echo $cred_final; ?></td>
					<td><?php echo "<a href='minha-conta/?pg=area_tarologos/msgs_consulta.php&id=$cod_consulta'>Ver Conversa</a>"; ?></td>
					<td>
					    <?php echo "<a href='minha-conta/?pg=atendimentos/editar.php&id=$id'><i class=\"fas fa-edit\"></i></a> / <a href='javascript:;' onclick='ConfirmaExclusaoAtendimento($cod_consulta);' data-toggle='tooltip' title='Excluir Atendimento' class=\"btn btn-sm\"><i class='far fa-trash-alt'></i></a>" ?>
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
