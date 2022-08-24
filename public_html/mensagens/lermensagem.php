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
<!-- caixa de verificação de exclusão -->
<script language='Javascript' type='text/javascript'>
</script>

<div style="width: 100%; margin:5px;">

<?php
// Pega o ID do Post que veio do Ajax
$id=$_POST['id'];
$sql = $pdo->query("SELECT * FROM mensagens WHERE id='$id'");
$row = $sql->rowCount();

echo $id;
exit();

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
	} 
	?>

	<div id="mensagemcliente" style="border:solid 1px #ccc; padding:5px; box-shadow: 5px 5px 10px #ccc; background:#ED7923; color:#fff;">

		<div class="row" style="margin: 5px;">

			<div id="head1" style="float:left;">
				<?php echo 'De: <b>'.$nome_remetente.'</b><br/>'; ?>
				<?php echo 'Para: <b>'.$nome_destinatario.'</b><br/>'; ?>
				<?php echo 'Assunto: <b>'.$assunto.'</b>'; ?>
			</div>
			
			<div id="head2" style="float:right; font-size:11px;">
				<?php echo $data; ?>
			</div>			

		</div>

		<hr style="border-top: 1px solid #ccc;">

		<div class="row" style="margin: 5px;">
			<b>Mensagem:</b>
		</div>

		<div class="row" style="margin: 5px;">
			<?php echo $mensagem; ?>
		</div>

	</div>

	<div style="clear:both; height: 10px;"></div>

	<?php 
} 
?>
</div>