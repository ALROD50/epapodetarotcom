<div id="geral" class="col-md-12" style="margin-bottom: 15px;">	
	<center>
		<h1 style="margin-top:0px;padding-top:15px;color: #0e0c0c;text-shadow: 0px 2px 4px #da8345;"><i class="fas fa-envelope-open-text"></i> Qual o Seu E-mail?</h1>
	</center>

	<?php 
	$nome = $_GET['nome'];
	@$_SESSION['nome'] = $nome;
	?>

	<form id="FormEmail" role="form" action="" method="POST" class="form-horizontal" style="margin-bottom:30px;">

		<div class="form-group">
			<div class="col-sm-12">
				<input type="text" class="form-control input-lg" id="emaildoformecadastro" name="emaildoformecadastro" value="<?php echo $email = isset($_POST['email']) ? $_POST['email'] : ''; ?>" placeholder="Digite seu melhor e-mail" required/>
				<div id="EmailNaoValido" style="display: none; clear: both; color: #ff0000;">
                    <i class="fas fa-exclamation-circle"></i> Informe o e-mail corretamente.
                </div>
			</div>
		</div>

		<button id="enviaEmail" name="enviaEmail" class="btn btn-success btn-lg btn-block" type="button" data-loading-text="Aguarde..."><i class="fas fa-arrow-right"></i> Próximo</button>

	</form>
	
	<div style="height:20px;"></div>
</div>