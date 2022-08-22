<h3 class="text-success">Atendimentos Realizados.</h3>

<?php 

  $sql = $pdo->query("SELECT * FROM atendimento WHERE id_cliente='$usuario_id' ORDER BY id DESC "); 
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
        <th> Código Consulta</th>
        <th> Data</th>
        <th> Duração (Minutos)</th>
        <th> Ver Conversa</th>
      </tr>
    </thead>
    <tbody>
    <?php  
        while ($mostrar = $sql->fetch(PDO::FETCH_ASSOC)){  
	        $id=$mostrar['id'];
	        $id_cliente=$mostrar['id_cliente'];
	        $id_tarologo=$mostrar['id_tarologo'];
	        $cod_consulta=$mostrar['cod_consulta'];
	        $data=$mostrar['data'];
	        $data=MostraDataCorretamenteHora ($data);
	        $duracao=$mostrar['duracao'];

	        //Estancia dados do tarólogo
	        $dadoss4 ="SELECT * FROM clientes WHERE id='$id_tarologo'"; 
	        $executa4=$pdo->query($dadoss4);
	          while ($dadoss4= $executa4->fetch(PDO::FETCH_ASSOC)){
	          $tarologo_id=$dadoss4['id'];
	          $tarologo_nome=$dadoss4['nome'];
	        }
	        $row = $executa4->rowCount();
            if ($row == 0) { $tarologo_nome=""; }

	        //Estancia dados do cliente
	        $dadoss3 ="SELECT * FROM clientes WHERE id='$id_cliente'"; 
	        $executa3=$pdo->query($dadoss3);
	          while ($dadoss3= $executa3->fetch(PDO::FETCH_ASSOC)){
	          $cliente_id=$dadoss3['id'];
	          $cliente_nome=$dadoss3['nome'];
	        }
	        ?>
	      <tr>
	        <td><?php echo $id; ?></td>
	        <td><?php echo $cliente_nome; ?></td>
	        <td><?php echo $tarologo_nome; ?></td>
	        <td><?php echo $cod_consulta; ?></td>
	        <td><?php echo $data; ?></td>
	        <td><?php echo $duracao; ?></td>
	        <td><?php echo "<a href='minha-conta/?pg=area_cliente/msgs_consulta.php&id=$cod_consulta'>Ver Conversa</a>"; ?></td>
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