<?php
date_default_timezone_set("Brazil/East");
ini_set ('default_charset', 'UTF-8');
ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);

if (isset($_POST['online'])) {
	include "/home/epapodetarotcom/public_html/includes/functions.php";
	include "/home/epapodetarotcom/public_html/includes/msg.php";
	include "/home/epapodetarotcom/public_html/includes/conexaoPdo.php";
	$pdo=conexao();
	$row_onlinex = $_POST['online'];
	$usuario_nivel = $_POST['usuario_nivel'];
	$usuario_id = $_POST['usuario_id'];
}
if($row_onlinex == 'offline' OR $row_onlinex == ''){

   echo "Você esta offline, faça login para coninuar...";
   exit();
}
?>
<!-- caixa de verificação de exclusão -->
<script language='Javascript' type='text/javascript'>
	function ConfirmaExclusao($id) {
		$.ajax({
            url : "mensagens/excluir.php",
            type : 'post',
            data : {
                id : +$id
            },
            beforeSend : function(){
                $("#inicio").html("<div class='spinner-border' role='status'><span class='sr-only'>Loading...</span></div>");
            }
        })
        .done(function(msg){
            $("#inicio").html(msg);
        })
        .fail(function(jqXHR, textStatus, msg){
            alert(msg);
        });
	};
	function LereResponderMensagem($id) {
		$.ajax({
            url : "mensagens/lererespondermensagem.php",
            type : 'post',
            data : {
                id : +$id
            },
            beforeSend : function(){
            	$("#coluna3").show();
                $("#coluna3").html("<div class='spinner-border' role='status'><span class='sr-only'>Loading...</span></div>");
            }
        })
        .done(function(msg){
            $("#coluna3").html(msg);
        })
        .fail(function(jqXHR, textStatus, msg){
            alert(msg);
        });
	};
</script>

<div style="height:500px; width: 100%;">

<?php
if ($usuario_nivel == "CLIENTE") {
	$sqlx = $pdo->query("SELECT * FROM mensagens WHERE 
	destinatario='$usuario_id' AND 'status'='entrada' AND exclui_cliente!='$usuario_id' AND exc_cli_defi!='$usuario_id' OR 
	destinatario='$usuario_id' AND 'status'='enviada' AND exclui_cliente!='$usuario_id' AND exc_cli_defi!='$usuario_id'
	ORDER BY id DESC ");
	
} elseif ($usuario_nivel == "TAROLOGO") {
	$sqlx = $pdo->query("SELECT * FROM mensagens WHERE 
	destinatario='$usuario_id' AND 'status'='entrada' AND exclui_tarologo!='$usuario_id' AND exc_tar_defi!='$usuario_id' OR 
	destinatario='$usuario_id' AND 'status'='enviada' AND exclui_tarologo!='$usuario_id' AND exc_tar_defi!='$usuario_id'
	ORDER BY id DESC ");
} elseif ($usuario_nivel == "ADMIN") {
	$sqlx = $pdo->query("SELECT * FROM mensagens WHERE 'status'='entrada' OR 'status' = 'enviada' ORDER BY id DESC ");
}


$row = $sqlx->rowCount();
echo $row;

if ($row > 0) {

	while ($mostrar = $sqlx->fetch(PDO::FETCH_ASSOC)) { 
		$id=$mostrar['id'];
		$remetente=$mostrar['remetente'];
		$destinatario=$mostrar['destinatario'];
		$status=$mostrar['status'];
		$assunto=$mostrar['assunto'];
		$mensagem=$mostrar['mensagem'];
		$mensagem=limita_caracteres($mensagem, 100, true);
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
		?>

		<div class="row" style="margin: 5px;">

			<div id="head1" style="float:left;">
				<?php echo $data.'<br/>'; ?>
				<?php echo 'De: <b>'.$nome_remetente.'</b><br/>'; ?>
				<?php echo 'Para: <b>'.$nome_destinatario.'</b><br/>'; ?>
				<?php echo 'Assunto: <b>'.$assunto.'</b>'; ?>
			</div>
			
		</div>

		<div class="row" style="margin: 5px;">
			<?php echo $mensagem; ?>
		</div>

		<div class="row" style="margin: 5px;">
			<div style="float:right;">
				<?php
				if ($usuario_nivel != 'ADMIN') {
					echo "<a href='javascript:;' onClick='ConfirmaExclusao($id);' title='Excluir'><i class='glyphicon glyphicon-trash'></i></a>";
				}
				?>
			</div>
		</div>

		<?php echo "<a href='javascript:;' onClick='LereResponderMensagem($id);' title='Ler e Responder Mensagem'>Ler e Responder Mensagem</a>"; ?>

		<hr style="border-top: 1px solid #ccc;">

		<?php 
	} 
  
} else {
	$msge="Nenhum resultado encontrado...";
	echo MsgErro ($msge);
}
?>
</div>