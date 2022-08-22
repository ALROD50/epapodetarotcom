<div id="geral" class="col-md-12" style="margin-bottom: 15px;">	
	<center>
		<h1 style="margin-top:0px;padding-top:15px;color: #0e0c0c;text-shadow: 0px 2px 4px #da8345;"><i class="fas fa-user-circle"></i> Qual o seu nome?</h1>
	</center>

	<?php 
	$id_tarologo = $_GET['tarologo'];
	@$_SESSION['id_tarologo'] = $id_tarologo;
	?>

	<form name="FormNome" method="post" action="" class="form-horizontal" style="margin-bottom:30px;">

		<div class="form-group">
			<div class="col-sm-12">
				<input type="text" class="form-control input-lg" name="nome" id="nome" value="<?php echo $nome = isset($_POST['nome']) ? $_POST['nome'] : ''; ?>" placeholder="Seu Nome Completo" required  />
				<div id="NomeNaoValido" style="display: none; clear: both; color: #ff0000;">
                    <i class="fas fa-exclamation-circle"></i> Informe o nome corretamente.
                </div>
			</div>
		</div>

		<button id="enviaNome" name="enviaNome" class="btn btn-success btn-lg btn-block" type="button" data-loading-text="Aguarde..." style="font-size: 25px;" data-loading-text="Aguarde..."><i class="fas fa-arrow-right"></i> Próximo</button>

	</form>
	
	<div style="height:20px;"></div>
</div>