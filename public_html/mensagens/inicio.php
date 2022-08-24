<!-- Necessário para funcionar a função de ocultar o formulário assim que for submetido. -->
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script> -->
<script type="text/javascript">
	function ChamaEntrada(){
		$.ajax({
            url : "mensagens/entrada.php",
            type : 'post',
            data : {
                online : '<?php echo $row_onlinex; ?>',
                usuario_nivel : '<?php echo $usuario_nivel; ?>',
                usuario_id : '<?php echo $usuario_id; ?>'
            },
            beforeSend : function(){
                $("#coluna3").hide();
                $("#coluna2").html("<div class='spinner-border' role='status'><span class='sr-only'>Loading...</span></div>");
            }
        })
        .done(function(msg){
            $("#coluna2").html(msg);
        })
        .fail(function(jqXHR, textStatus, msg){
            alert(msg);
        });
	};
	function ChamaEnviadas(){
		$.ajax({
            url : "mensagens/enviadas.php",
            type : 'post',
            data : {
                online : '<?php echo $row_onlinex; ?>',
                usuario_nivel : '<?php echo $usuario_nivel; ?>',
                usuario_id : '<?php echo $usuario_id; ?>'
            },
            beforeSend : function(){
                $("#coluna3").hide();
                $("#coluna2").html("<div class='spinner-border' role='status'><span class='sr-only'>Loading...</span></div>");
            }
        })
        .done(function(msg){
            $("#coluna2").html(msg);
        })
        .fail(function(jqXHR, textStatus, msg){
            alert(msg);
        });
	};
	function ChamaLixeira(){
		$.ajax({
            url : "mensagens/lixeira.php",
            type : 'post',
            data : {
                online : '<?php echo $row_onlinex; ?>',
                usuario_nivel : '<?php echo $usuario_nivel; ?>',
                usuario_id : '<?php echo $usuario_id; ?>'
            },
            beforeSend : function(){
                $("#coluna3").hide();
                $("#coluna2").html("<div class='spinner-border' role='status'><span class='sr-only'>Loading...</span></div>");
            }
        })
        .done(function(msg){
            $("#coluna2").html(msg);
        })
        .fail(function(jqXHR, textStatus, msg){
            alert(msg);
        });
	};
</script>

<?php  
// Enviando mensagem de resposta do formulário
if ( isset($_POST["enviar"]) ) {

	// Verifica se cliente tem crédito o suficiente para responder o tarólogo.
	if ($usuario_nivel == "CLIENTE") {
		$sql_creditoxx = $pdo->query("SELECT SUM(minutos_dispo) as soma FROM controle WHERE id_nome_cliente='$usuario_id' "); 
		$contx = $sql_creditoxx->fetch(PDO::FETCH_ASSOC);
		$creditox = $contx["soma"];

		if ($creditox >= $config_preco_consulta_email) {
			
			// Atualiza o credito menos com o valor do preço da consulta.
			$tempo_restante = $creditox - $config_preco_consulta_email;

			$query = $pdo->query( "UPDATE controle SET 
			  minutos_dispo='$tempo_restante'
			WHERE id_nome_cliente='$usuario_id' AND status='PAGO' ORDER BY id DESC LIMIT 1 " );

		} else {
			$msge = "Erro! Você não tem minutos o suficiente para enviar essa mensagem.<br/>";
			$msge .= "Adquira mais minutos e tente novamente.";
			echo "<script>document.location.href='index.php?pg=mensagens/inicio.php&msge=$msge'</script>";
			exit();
		}
	}

	// Verifica se Tarólogo pode responder esse cliente.
	
	$remetente = $_POST['remetente'];
	$destinatario = $_POST['destinatario'];
	$status = 'enviada';
	$assunto = $_POST['assunto'];
	$mensagem = $_POST['mensagem'];
	$data = date("Y-m-d H:i:s");
	$escreveu = $usuario_id;

	// Grava no banco a resposta do usuário.
	$pdo->query( "INSERT INTO mensagens (
      remetente,
      destinatario,
      status,
      assunto,
      mensagem,
      data,
      escreveu
    ) VALUES (
      '$remetente',
      '$destinatario',
      '$status',
      '$assunto',
      '$mensagem',
      '$data',
      '$escreveu'
    )");

    $msgs = "Mensagem enviada com sucesso!</br>";
    if ($usuario_nivel == 'CLIENTE') {
    	$msgs .= "Seu saldo de minutos atualizado é de <b>".$tempo_restante." Minutos.</b>";
    }
	echo "<script>document.location.href='minha-conta/?pg=mensagens/inicio.php&msgs=$msgs'</script>";
}
?>

<h3 class="text-success">Mensagens</h3>

<p>Instruções básicas:</p>
<p><b>Caixa de Entrada:</b> Armazena todas as novas mensagens recebidas para você.</p>
<p><b>Enviadas:</b> Local onde serão registradas todas as suas mensagens enviadas.</p>
<p><b>Lixeira:</b> Local onde serão armazenadas as mensagens que você excluiu.</p>
<?php  
if ($usuario_nivel == 'CLIENTE') { ?>
	<p><b>Custo:</b> Para responder e enviar uma nova mensagem, você terá um custo de <b><?php echo $config_preco_consulta_email; ?> Minutos</b> do seu saldo disponível. Escolha um tarólogo na página de tarólogos do site, e clique no icone de consulta por e-mail para enviar uma nova mensagem a um tarólogo diferente.</p>
<?php }
?>

<div id="inicio" class="row">
	
	<div id="coluna1" class="col-md-2">
		<div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
	      <a class="nav-link active" href='javascript:;' onClick='ChamaEntrada();' id="v-pills-um-tab" data-toggle="pill" href="#v-pills-um" role="tab" aria-controls="v-pills-um" aria-selected="true">Caixa de Entrada</a>
	      <a class="nav-link" href='javascript:;' onClick='ChamaEnviadas();' id="v-pills-dois-tab" data-toggle="pill" href="#v-pills-dois" role="tab" aria-controls="v-pills-dois" aria-selected="false">Enviadas</a>
	      <a class="nav-link" href='javascript:;' onClick='ChamaLixeira();' id="v-pills-tres-tab" data-toggle="pill" href="#v-pills-tres" role="tab" aria-controls="v-pills-tres" aria-selected="false">Lixeira</a>
	    </div>
	</div>
	
	<div id="coluna2" class="col-md-4" style="display: flex; overflow: auto; border:solid 1px #ccc; padding: 5px;">
		<?php include 'entrada.php'; ?>
	</div>
	
	<div id="coluna3" class="col-md-6" style="display: flex; overflow: auto; border:solid 1px #ccc; padding: 5px;">
	</div>

</div>