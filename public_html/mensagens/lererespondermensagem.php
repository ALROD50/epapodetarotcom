<?php
date_default_timezone_set("Brazil/East"); // seta configurações fusuhorario para Brasil
ini_set ('default_charset', 'UTF-8'); // seta o php em UTF 8
#### Recupera Cookies -----------------------------------
@$usuario_id     = $_COOKIE["UsuarioID"];
@$usuario_nome   = $_COOKIE["UsuarioNome"];
@$usuario_nivel  = $_COOKIE["UsuarioNivel"];
@$usuario_status = $_COOKIE["UsuarioStatus"];
#### Recupera Cookies -----------------------------------
include "/home/epapodetarotcom/public_html/includes/conexaoPdo.php";
$pdo = conexao();
//Verifica se usuario esta online
$sql_onlinex = $pdo->query("SELECT * FROM clientes WHERE id='$usuario_id' "); 
	while ($mostrarx = $sql_onlinex->fetch(PDO::FETCH_ASSOC)){ 
	$row_onlinex=$mostrarx['online'];
}
if(empty($usuario_id) OR empty($usuario_nome) OR empty($usuario_nivel) OR empty($usuario_status)  OR $row_onlinex == 'offline'){

   echo "Você esta offline, faça login para coninuar...";
   exit();
}
include "/home/epapodetarotcom/public_html/includes/functions.php";
include "/home/epapodetarotcom/public_html/includes/globais.php";
include "/home/epapodetarotcom/public_html/includes/msg.php";
?>

<div style="width: 100%; margin:5px;">

<?php
// Pega o ID do Post que veio do Ajax
$id = $_POST['id'];
$sql = $pdo->query("SELECT * FROM mensagens WHERE id='$id'");
$row = $sql->rowCount();

if ($row > 0) {

	while ($mostrar = $sql->fetch(PDO::FETCH_ASSOC)) { 
		$id=$mostrar['id'];
		$remetente=$mostrar['remetente'];
		$destinatario=$mostrar['destinatario'];
		$status=$mostrar['status'];
		$assunto=$mostrar['assunto'];
		$mensagem=$mostrar['mensagem'];
		$data=$mostrar['data'];
		$data=MostraDataCorretamenteHora($data);

		//Verifica nome do remetente	
		$sql77 = $pdo->query("SELECT * FROM clientes WHERE id='$remetente' LIMIT 1 "); 
		while ($mostrar77 = $sql77->fetch(PDO::FETCH_ASSOC)) { 
		  $nome_remetente=$mostrar77['nome'];	  
		}

		//Verifica nome do destinatario	
		$sql777 = $pdo->query("SELECT * FROM clientes WHERE id='$destinatario' LIMIT 1 "); 
		while ($mostrar777 = $sql777->fetch(PDO::FETCH_ASSOC)) { 
		  $nome_destinatario=$mostrar777['nome'];	  
		}

		//Verifica se cliente tem crédito
		$sql_credito12y = $pdo->query("SELECT SUM(minutos_dispo) as soma FROM controle WHERE id_nome_cliente='$usuario_id' "); 
		$cont12y = $sql_credito12y->fetch(PDO::FETCH_ASSOC);
		$valor12y = $cont12y["soma"];
	} 
	?>

	<div id="mensagemcliente" style="border:solid 1px #ccc; padding:5px; box-shadow: 5px 5px 10px #ccc; background:#ED7923; color:#fff;">

		<div class="row" style="margin: 5px;">

			<div id="head1" style="float:left;">
				<?php echo $data.'<br/>'; ?>
				<?php echo 'De: <b>'.$nome_remetente.'</b><br/>'; ?>
				<?php echo 'Para: <b>'.$nome_destinatario.'</b><br/>'; ?>
				<?php echo 'Assunto: <b>'.$assunto.'</b>'; ?>
			</div>

		</div>

		<hr style="border-top: 1px solid #ccc;">

		<div class="row" style="margin: 5px;">
			<?php echo '<b>Mensagem</b>: '; ?>
		</div>

		<div class="row" style="margin: 5px;">
			<?php echo $mensagem; ?>
		</div>

	</div>

	<div style="clear:both; height: 10px;"></div>

	<div id="respondercliente" style="border:solid 1px #ccc; padding:5px; box-shadow: 5px 5px 10px #ccc; background:#eaeaea;">

		<div class="row" style="margin: 5px;">

			<div id="head1" style="float:left;">
				<?php echo '<h3><span style=\'color:#9f9d99;\'>Responder:</span> '.$nome_remetente.'</h3>'; ?>
			</div>
		
		</div>

		<hr style="border-top: 1px solid #ccc;">

		<div class="container-fluid">

		    <div class="">

	            <form action="" method="post">

	            	<input type="hidden" name="remetente" value="<?php echo $destinatario; ?>"/>
	            	<input type="hidden" name="destinatario" value="<?php echo $remetente; ?>"/>

	            	<?php 
	            	if ($valor12y < $config_preco_consulta_email AND $usuario_nivel == 'CLIENTE') {
					  echo '<p><span style="font-size: 15px;">Você não tem minutos suficientes para esta consulta. <a href="https://www.epapodetarot.com.br/comprar-consulta" target="_blank"><b>Por gentileza compre um plano de minutos aqui para continuar seu atendimento.</b></a></span></p>';
					
					} else { ?>
						
		                <div class="row" style="margin-top: 0px; margin-bottom: 15px;">
		                    <div class="col-md-12">
		                    	<p><b>Assunto:</b></p>
		                        <input name="assunto" type="text" required class="form-control" placeholder="Assunto"  value="<? echo 'RE: '.$assunto; ?>">
		                    </div>
		                </div>

		                <div class="row">
		                    <div class="col-md-12">
		                    	<p><b>Mensagem:</b></p>
		                        <textarea name="mensagem" required class="form-control" placeholder="mensagem" rows="12"/></textarea><br>
		                    </div>
		                </div>

		                <div class="row" style="margin-bottom: 15px;">
		                    <div class="col-md-3">
		                        <input name="enviar" id="submit" type="submit" value="Enviar Resposta para <?php echo $nome_remetente; ?>" title="Enviar Resposta para <?php echo $nome_remetente; ?>" class="btn btn-success btn-large">
		                    </div>
		                </div>

			<?php 	} ?>      

	            </form>

		    </div>

		</div>

	</div>

	<?php 
} 
?>
</div>