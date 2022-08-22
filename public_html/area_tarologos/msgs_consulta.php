<h3 class="text-success">Mensagens do atendimento</h3>
<div class="row">
	<div class="col-md-12">
		<div id="row">
		<?php if ($usuario_nivel == 'ADMIN') { ?>
		<a button class="btn btn-info" href="minha-conta/?pg=atendimentos/atendimento_meses.php">Voltar</button></a>
		<?php } else { ?>
		<a button class="btn btn-info" href="minha-conta/?pg=area_tarologos/atendimento_meses.php">Voltar</button></a>
		<?php } ?>
		</div>
		<br>
		<div id="row">
		<?php
		$msg = $_GET['id'];
		$sql = $pdo->query("SELECT * FROM atendimento WHERE cod_consulta='$msg'");
		while ($mostrar = $sql->fetch(PDO::FETCH_ASSOC)) {  
		    $id=$mostrar['id'];
		    $id_cliente=$mostrar['id_cliente'];
		    $id_tarologo=$mostrar['id_tarologo'];
		    $cod_consulta=$mostrar['cod_consulta'];
		    $data=$mostrar['data'];
		    $data=MostraDataCorretamenteHora($data);
		    $duracao=$mostrar['duracao'];
		    $cred_inicial=$mostrar['cred_inicial'];
		    $cred_final=$mostrar['cred_final'];
		    $registroux=$mostrar['registrou'];
		    $paginax=$mostrar['pagina'];

		    //Estancia dados do tarólogo
		    $dadoss4 = "SELECT * FROM clientes WHERE id='$id_tarologo'"; 
		    $executa4=$pdo->query( $dadoss4);
		      while ($dadoss4= $executa4->fetch(PDO::FETCH_ASSOC)){
		      $tarologo_id=$dadoss4['id'];
		      $tarologo_nome=$dadoss4['nome'];
		    }
		    $row = $executa4->rowCount();
		    if ($row == 0) { $tarologo_nome=""; }

		    //Estancia dados do cliente
		    $dadoss3 = "SELECT * FROM clientes WHERE id='$id_cliente'"; 
		    $executa3=$pdo->query( $dadoss3);
		      while ($dadoss3= $executa3->fetch(PDO::FETCH_ASSOC)){
		      $cliente_id=$dadoss3['id'];
		      $cliente_nome=$dadoss3['nome'];
		    }
		    $row = $executa3->rowCount();
		    if ($row == 0) { $cliente_nome=""; }

		    // Revisa o tempo da consulta
		    //Pega a o primeiro registro
		    $dadoss ="SELECT * FROM chat WHERE cod_sala='$cod_consulta' ORDER BY id DESC "; //acessa todos os dados do usuário $NOME da url
		    $executa=$pdo->query( $dadoss); //se conecta no banco e concatena os dados
		    while ( $mostrartempo = $executa->fetch(PDO::FETCH_ASSOC) ) { 
		      $horaInicio=$mostrartempo['datahora'];
		    }
		    // Pega o último registro.
		    $dadoss1 ="SELECT * FROM chat WHERE cod_sala='$cod_consulta' ORDER BY id ASC "; //acessa todos os dados do usuário $NOME da url
		    $executa1=$pdo->query( $dadoss1); //se conecta no banco e concatena os dados
		    while ( $mostrartempo1 = $executa1->fetch(PDO::FETCH_ASSOC) ) { 
		      $horaFim=$mostrartempo1['datahora'];
		    }
		    @$resultado = datediff('n', $horaInicio, $horaFim, false);

		    // Crédito / Tempo Restante do Cliente Atualizado Após Atendimento
		    $tempo_restante = $cred_inicial - $resultado;
		}
		?>
		<p><b>ID:</b>&nbsp;&nbsp;<?php echo $id; ?> | <b>Cod Consulta:</b>&nbsp;&nbsp;<?php echo $cod_consulta; ?> | <b>Registrou:</b>&nbsp;&nbsp;<?php echo $registroux; ?> | <b>Página:</b>&nbsp;&nbsp;<?php echo $paginax; ?> | <b>Tarologo:</b>&nbsp;&nbsp;<?php echo $tarologo_nome; ?> | <b>Cliente:</b>&nbsp;&nbsp;<?php echo $cliente_nome; ?> | <b>Data:</b>&nbsp;&nbsp;<?php echo $data; ?> | <b>Credito inicial:</b>&nbsp;&nbsp;<?php echo $cred_inicial; ?> | <b>Duração:</b>&nbsp;&nbsp;<?php echo $duracao; ?> | <b>Credito final:</b>&nbsp;&nbsp;<?php echo $cred_final; ?> | <b>Duração Revisada:</b>&nbsp;&nbsp;<?php echo $resultado; ?> | <b>Credito final revisado:</b>&nbsp;&nbsp;<?php echo $tempo_restante; ?></p>
		</div>
		<div class="card card-body" style="background:#fff; color:#383C3F;">
			<?php
			$dadoss ="SELECT * FROM chat WHERE cod_sala='$msg' ORDER BY id ASC"; 
			$executa=$pdo->query($dadoss);

			while ($mostrartempo=$executa->fetch(PDO::FETCH_ASSOC)) {
			    $nome=$mostrartempo['nome'];
			    $mensagem=$mostrartempo['mensagem'];
			    $datahora=$mostrartempo['datahora'];
			    $id_cliente=$mostrartempo['id_cliente'];
			    $id_tarologo=$mostrartempo['id_tarologo'];
			    $datahora = date("d-m-Y H:i:s", strtotime("$datahora"));

			    if ($id_tarologo == $usuario_id OR $usuario_nivel == 'ADMIN') {
			    	
			    	echo '<p>'.$datahora.' <b>'.utf8_decode($nome).':</b> '.utf8_decode($mensagem).'</p>';
			    
			    } else {

					echo "<script>document.location.href='https://www.tarotdehorus.com.br/minha-conta/?msge=Consulta%20n%C3%A3o%20encontrada'</script>";
			    }
			}
			?>
		</div>
		<div id="row">
			<?php if ($usuario_nivel == 'ADMIN') { ?>
			<a button class="btn btn-info" href="minha-conta/?pg=atendimentos/atendimento_meses.php">Voltar</button></a>
			<?php } else { ?>
			<a button class="btn btn-info" href="minha-conta/?pg=area_tarologos/atendimento_meses.php">Voltar</button></a>
			<?php } ?>
		</div>
	</div>
</div>