<?php
// mensagens de sucesso do sistema / VERDE
if (isset($_GET['msgs']) ){ 
	$msgs=$_GET['msgs'];
	MsgSucesso ($msgs);
}
function MsgSucesso ($msgs) { ?>
<div class="alert alert-success" role="alert">
	<button type="button" class="close" data-dismiss="alert">×</button>
	<h4><i class="fas fa-trophy"></i> Sucesso!</h4>
	<?php echo $msgs; ?>
</div> <?php 
}
// mensagens de erro do sistema / VERMELHO
if (isset($_GET['msge']) ){ 
	$msge=$_GET['msge'];
	?>
	    <?php MsgErro ($msge); ?>
	<?php
}
function MsgErro ($msge) { ?>
<div class="alert alert-danger" role="alert">
	<button type="button" class="close" data-dismiss="alert">×</button>
	<h4><i class="fas fa-exclamation-triangle"></i> Atenção!</h4>
	<?php echo $msge; ?>
</div> <?php 
}
// mensagens de informação do sistema / AZUL
if (isset($_GET['msgi']) ){ 
	$msgi=$_GET['msgi'];
	?>
	    <?php MsgInfo ($msgi); ?>
	<?php
}
function MsgInfo ($msgi) { ?>
<div class="alert alert-info" role="alert">
	<button type="button" class="close" data-dismiss="alert">×</button>
	<h4><i class="fas fa-exclamation-circle"></i> Informação!</h4>
	<?php echo $msgi; ?>
</div> <?php 
}