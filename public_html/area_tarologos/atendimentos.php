<?php
//Inclui o filtro
include "atendimentos_filtro.php";

// soma minutos atendidos total
$sql4 = $pdo->query("SELECT SUM(duracao) as soma4 FROM atendimento WHERE data BETWEEN '$ano_escolhido-$tab-01' AND '$ano_escolhido-$tab-31 23:59:00' AND id_tarologo='$usuario_id' ");
$cont4 = $sql4->fetch(PDO::FETCH_ASSOC);
$valor44 = $cont4["soma4"];

$valor = $valor44 * $config_valor_minutos;

$comissao_real = CalculaComissao($valor44, $config_valor_minutos, $config_porcentagem_tarologo);
?>
<span style="font-size:15px; color:#383C3F;">Minutos totais atendidos: </span><strong><span class="label label-success"><?php echo $valor44; ?></span></strong>
<span style="font-size:15px; color:#383C3F;">Valor total minutos R$: </span><strong><span class="label label-success"><?php echo $valor; ?></span></strong>
<span style="font-size:15px; color:#383C3F;">Comissão total R$: </span><strong><span class="label label-success"><?php echo $comissao_real; ?></span></strong>
<!-- soma minutos atendidos -->

<?php
// Comissão 1 ao 14
$sql4 = $pdo->query("SELECT SUM(duracao) as soma5 FROM atendimento WHERE data BETWEEN '$ano_escolhido-$tab-01' AND '$ano_escolhido-$tab-14 23:59:59' AND id_tarologo='$usuario_id' ");
$cont4 = $sql4->fetch(PDO::FETCH_ASSOC);
$valor44 = $cont4["soma5"]; // Minutos Totais
$valor = $valor44 * $config_valor_minutos; // Valor em dinheiro
$comissao_realumaoquinze = CalculaComissao($valor44, $config_valor_minutos, $config_porcentagem_tarologo);
?>
<!-- <p>Comissão <?php //echo $ano_escolhido.'/'.$tab.'/01 à '.$ano_escolhido.'/'.$tab.'/14 23:59:59'; ?> R$: <strong><?php //echo $comissao_realumaoquinze; ?></strong></br> -->
<?php
// Comissão 15 ao 31
$sql4 = $pdo->query("SELECT SUM(duracao) as soma6 FROM atendimento WHERE data BETWEEN '$ano_escolhido-$tab-15' AND '$ano_escolhido-$tab-31 23:59:59' AND id_tarologo='$usuario_id' ");
$cont4 = $sql4->fetch(PDO::FETCH_ASSOC);
$valor44x = $cont4["soma6"]; // Minutos Totais
$valor = $valor44x * $config_valor_minutos; // Valor em dinheiro
$comissao_realumaotrinta = CalculaComissao($valor44x, $config_valor_minutos, $config_porcentagem_tarologo);
?>
<!-- Comissão <?php //echo $ano_escolhido.'/'.$tab.'/15 à '.$ano_escolhido.'/'.$tab.'/31 23:59:59'; ?> R$: <strong><?php //echo $comissao_realumaotrinta; ?></strong></p> -->

<?php
  $sql = $pdo->query("SELECT * FROM atendimento WHERE data BETWEEN '$ano_escolhido-$tab-01' AND '$ano_escolhido-$tab-31 23:59:00' AND id_tarologo='$usuario_id' ORDER BY id DESC "); 
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
		<th> Tipo</th>
        <th> Código Consulta</th>
        <th> Data</th>
        <th> Duração (Minutos)</th>
        <th> Comissão</th>
        <th> Ver Conversa</th>
		<th> Mensagem Particular</th>
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
	        if ($duracao=="") {
              $duracao=0;
            }
			$tipo=$mostrar['tipo'];

	        //Estancia dados do tarólogo
	        $dadoss4 ="SELECT * FROM clientes WHERE id='$id_tarologo'"; 
	        $executa4=$pdo->query($dadoss4);
	          while ($dadoss4= $executa4->fetch(PDO::FETCH_ASSOC)){
	          $tarologo_id=$dadoss4['id'];
	          $tarologo_nome=$dadoss4['nome'];
	        }

	        //Estancia dados do cliente
	        $dadoss3 ="SELECT * FROM clientes WHERE id='$id_cliente'"; 
	        $executa3=$pdo->query( $dadoss3);
	          while ($dadoss3= $executa3->fetch(PDO::FETCH_ASSOC)){
	          $cliente_id=$dadoss3['id'];
	          $cliente_nome=$dadoss3['nome'];
	        }
	        ?>
	      <tr>
	        <td><?php echo $id; ?></td>
	        <td><?php echo @$cliente_nome; ?></td>
	        <td><?php echo $tarologo_nome; ?></td>
			<td>
	        	<?php 
					if ($tipo=="Video") {
						echo '<i class="fas fa-video laranja"></i>';
					} else {
						echo '<i class="fas fa-comments verdao"></i>';
					}
				?>
	        </td>
	        <td><?php echo $cod_consulta; ?></td>
	        <td><?php echo $data; ?></td>
	        <td><?php echo $duracao; ?></td>
	        <td><?php echo 'R$ '.CalculaComissao($duracao, $config_valor_minutos, $config_porcentagem_tarologo); ?></td>
	        <td><?php echo "<a href='minha-conta/?pg=area_tarologos/msgs_consulta.php&id=$cod_consulta'>Ver Conversa</a>"; ?></td>
			<td><?php echo "<a href='minha-conta/?pg=area_tarologos/msgs_privada.php&id=$cliente_id'>Enviar Mensagem</a>"; ?></td>
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