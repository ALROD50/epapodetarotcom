<?php
date_default_timezone_set("Brazil/East"); // seta configurações fusuhorario para Brasil
ini_set ('default_charset', 'UTF-8'); // seta o php em UTF 8
include_once "/home/epapodetarotcom/public_html/includes/conexaoPdo.php";
$pdo=conexao();
$cod = $_POST['cod'];
$executa66 = $pdo->query("SELECT * FROM mail_camp WHERE id='$cod'");
while ($dadoss66 = $executa66->fetch(PDO::FETCH_ASSOC)) { 
	$fixo=$dadoss66['fixo'];
}

if ($fixo=="PROGRESSIVO" OR $fixo=="FIXO") { ?>
	
	<div class="col-md-12">
	                
		<div class="col-md-6">
		  <div class="form-group">
		    <label for="">Assunto</label>
		    <input type="text" class="form-control" name="assunto" required value="<?php echo @$assunto; ?>" />
		  </div>
		</div>

		<div class="col-md-6">
		  <div class="form-group">
		    <label for="">Ciclo de Envio em Dias</label>
		    <input type="text" class="form-control" name="enviar_dias" required value="<?php echo @$enviar_dias; ?>" />
		  </div>
		</div>

	</div>  <?php
}

if ($fixo=="AGENDADAS") { 

	?>
	
	<div class="col-md-12">

		<div class="col-md-6">
		  <div class="form-group">
		    <label for="">Data:</label> <br>
		    <p>Adicione as datas em que essa mesagem será enviada.</p>
            <input type="button" value="+ Adicionar Nova Data" class="btn btn-primary" onclick="addCampos()"/>
		  </div>
		</div>

	</div>

	<div class="col-md-12">
	                
		<div class="form-group">
			<div id="campoPai"></div>
		</div>

	</div>

	<?php
}
?>
