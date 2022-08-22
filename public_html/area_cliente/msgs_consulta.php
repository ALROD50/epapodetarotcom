<h3 class="text-success">Mensagens do atendimento</h3>

<div id="row">
	<a button class="btn btn-info" href="minha-conta/?pg=area_cliente/atendimentos.php">Voltar</button></a>
</div>

<div class="card card-body mt-3 mb-3" style="background:#fff; color:#383C3F;">
	<?php
	$msg = $_GET['id'];

	$dadoss ="SELECT * FROM chat WHERE cod_sala='$msg' ORDER BY id ASC"; 
	$executa=$pdo->query( $dadoss);

	while ($mostrartempo=$executa->fetch(PDO::FETCH_ASSOC)) {

	    $nome=$mostrartempo['nome'];
	    $mensagem=$mostrartempo['mensagem'];
	    $datahora=$mostrartempo['datahora'];
	    $id_cliente=$mostrartempo['id_cliente'];
	    $id_tarologo=$mostrartempo['id_tarologo'];
	    $datahora = date("d-m-Y H:i:s", strtotime("$datahora"));

		if ($id_cliente == $usuario_id OR $usuario_nivel == 'ADMIN') {
	    	
	    	echo '<p>'.$datahora.' <b>'.utf8_decode($nome).':</b> '.utf8_decode($mensagem).'</p>';
	    
	    } else {

	    	echo "<script>document.location.href='https://www.epapodetarot.com.br/minha-conta/?msge=Consulta%20n%C3%A3o%20encontrada'</script>";
	    }
	}
	?>
</div>

<div id="row">
	<a button class="btn btn-info" href="minha-conta/?pg=area_cliente/atendimentos.php">Voltar</button></a>
</div>