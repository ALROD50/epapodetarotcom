<div id="geral" class="col-md-12" style="margin-bottom: 15px;">
	<?php
	@$id_tarologo       = $_SESSION['id_tarologo'];
	@$nome              = $_SESSION['nome'];
	$email             = trim(addslashes($_GET['email']));
	$_SESSION['email'] = $email;
	@$usuario_id       = $_SESSION['usuario_id'];
	@$usuario_nivel     = $_COOKIE["UsuarioStatus"];
	?>
	<center>
		<h1 style="margin-top:10px;padding-top:15px;color:#0e0c0c;text-shadow: 0px 2px 4px #da8345;"><i class="fab fa-whatsapp"></i> Informe seu WhatsApp</h1>
		<p>Você vai receber no seu Whatsapp os dados da consulta.</p>
	</center>

	<form name="FormWhatsApp" method="post" action="" class="form-horizontal" style="margin-bottom:30px;" onkeydown="return event.key != 'Enter';">

		<div class="form-group">
			<div class="col-sm-12">
				<input type="tel" class="form-control input-lg" id="whatsapp" name="whatsapp" value="<?php echo $whatsapp = isset($_POST['whatsapp']) ? $_POST['whatsapp'] : ''; ?>" placeholder="Digite seu Whatsapp" data-mask="(00) 0.0000-0000" required onblur="testaCelular(this.value, this.id)" />
				<div id="whatsappNaoValido" style="display: none; clear: both; color: #ff0000;">
                    <i class="fas fa-exclamation-circle"></i> Informe o seu whatsapp corretamente.
                </div>
                <div id="msgecel"></div>
			</div>
		</div>

		<button id="enviaWhatsApp" name="enviaWhatsApp" class="btn btn-success btn-lg btn-block" type="button" data-loading-text="Aguarde..." style="font-size: 25px;" data-loading-text="Aguarde..."><i class="fas fa-arrow-right"></i> Ir Para a Consulta</button>

	</form>
	
	<div style="height:20px;"></div>
</div>