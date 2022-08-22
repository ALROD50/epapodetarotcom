<?php 
if (isset($_POST['enviarcomentario'])) {
	
	if($row_onlinex=="offline" OR $row_onlinex=="") {

		echo "<script>document.location.href='https://www.epapodetarot.com.br/fazer-login/?msge=Ops!<br>Faça login ou cadastre abaixo para enviar seu comentário.<br>É rapidinho, leva só 1 minutinho!'</script>";
		exit();

	} else {

		$comentario = $_POST['comentario'];
		$comentario = preg_replace("/'/", "", $comentario);
		$pontuacao = $_POST['inlineRadioOptions'];
		$data_hoje = date('Y-m-d H:i:s');

		$pdo->query("INSERT INTO blog_comentarios (
			id_artigo,
			id_user,
			mensagem,
			pontuacao,
			status,
			data
		) VALUES (
			'$artigo_id',
			'$usuario_id',
			'$comentario',
			'$pontuacao',
			'Desativado',
			'$data_hoje'
		)");

		$msgs="Parabéns, seu comentário foi enviado com sucesso!<br>";
		$msgs.="Após a aprovação, você poderá vê-lo aqui.";
		MsgSucesso ($msgs);

	}
}
?>
<div class="card card-body">

	<div class="text-center">
		<h3 class="azul"><i class="fas fa-bullhorn"></i> Comentários</h3>
		<hr>
	</div>

	<form method="post" action="">
	  <div class="form-group row">
	    <div class="col-md-12">
			<label for="" class="form-label mr-2 azul"><i class="fas fa-ruler-combined azul"></i> Avaliar Artigo: </label>
			<div class="form-check form-check-inline">
			  <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="1">
			  <label class="form-check-label" for="inlineRadio1">1<i class="fas fa-star laranja"></i></label>
			</div>
			<div class="form-check form-check-inline">
			  <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="2">
			  <label class="form-check-label" for="inlineRadio2">2<i class="fas fa-star laranja"></i></label>
			</div>
			<div class="form-check form-check-inline">
			  <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio3" value="3">
			  <label class="form-check-label" for="inlineRadio3">3<i class="fas fa-star laranja"></i></label>
			</div>
			<div class="form-check form-check-inline">
			  <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio4" value="4">
			  <label class="form-check-label" for="inlineRadio4">4<i class="fas fa-star laranja"></i></label>
			</div>
			<div class="form-check form-check-inline">
			  <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio5" value="5">
			  <label class="form-check-label" for="inlineRadio5">5<i class="fas fa-star laranja"></i></label>
			</div>

	    	<textarea name="comentario" class="col-md-12 form-control" placeholder="Deixa seu comentário sobre este artigo..."></textarea>
	      	
	      	<button type="submit" class="btn btn-success mb-2 mt-3 btn-lg" name="enviarcomentario"><i class="fas fa-comment-dots"></i> Enviar Comentário</button>
	    </div>
	  </div>
	</form>

	<?php
    $executa = $pdo->query("SELECT * FROM blog_comentarios WHERE status='Ativo' AND id_artigo='$artigo_id' ORDER by id DESC");
    $encontrados = $executa->rowCount();
    while ($dadoss= $executa->fetch(PDO::FETCH_ASSOC)) {
  		$id_cliente=$dadoss['id_user'];
  		$mensagem=$dadoss['mensagem'];
  		$pontuacao=$dadoss['pontuacao'];
        $data=$dadoss['data'];
        $data=date("d-m-Y", strtotime("$data"));

  		$dadoss3="SELECT * FROM clientes WHERE id='$id_cliente'"; 
  		$executa3=$pdo->query($dadoss3);
  		while ($dadoss3= $executa3->fetch(PDO::FETCH_ASSOC)) {
  			$cliente_nome=$dadoss3['nome'];
  		}
  		?>
  		<div class="card card-body mb-2 mt-2 bg-light row" id="">
			<p><i class="fas fa-star"></i> <?php echo $pontuacao; ?> <b>Estrelas</b>  <small class="text-muted"><i class="fas fa-calendar-alt"></i> <?php echo $data; ?></small></p>
		    <?php echo $mensagem; ?>
  		</div>
    	<?php 
  	}

    if ($encontrados == 0) {
		echo '<p>';
		echo '(0) Comentários... <i class="fas fa-cat"></i>';
		echo '</p>';
    }
	?>
</div>