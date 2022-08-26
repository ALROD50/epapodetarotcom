<?php 
//Configurações de sistema
$sql_config = $pdo->query("SELECT * FROM config WHERE id='1' ");
while ($mostrar_config = $sql_config->fetch(PDO::FETCH_ASSOC)){
    $config_preco_consulta_email =  $mostrar_config['preco_consulta_email'];
}
?>
<!-- Necessário para funcionar a função de ocultar o formulário assim que for submetido. -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>

<h1 class="azul mt-2"><i class="fas fa-envelope"></i> Realizar Consulta Por E-mail</h1>
<hr>

<div id="pre_texto">

	<p>Envie mensagens por e-mail para seu tarólogo favorito, este recurso é muito favorável quando você não consegue estar online ao mesmo tempo em que o tarólogo está, ou prefere se consultar por mensagens ao invés de Chat.</p>
	<p>Use nosso sistema de consultas por E-mail para conseguir realizar o seu atendimento a qualquer hora do dia e noite. Este recurso permite que você envie uma mensagem com suas dúvidas e questões para o tarólogo de sua escolha a qualquer hora do dia, e assim o tarólogo poderá te responder quando ele estiver online.</p>
	<p>A consulta por E-mail tem um custo de <b><?php echo $config_preco_consulta_email ?> Minutos do seu Saldo</b>. Certifique-se de que você tem minutos o suficiente para a consulta, caso contrário, <a href="comprar-consulta">adquira mais minutos aqui.</a></p>
	<p>Toda a conversa e mensagens ficarão registradas em sua conta (<b>Minha Conta / Mensagens, na Caixa de Entrada</b>), desta forma você tem a segurança de que as mensagens não se perderam, e poderá vê-las a qualquer momento em sua conta, e ainda poderá enviar novas mensagens para o seu tarólogo favorito, com toda a segurança de que sua mensagem chegará ao destino correto com toda privacidade.</p>

	<hr style="border-top: 1px solid #ccc;">

</div>

<?php
@$id_tarologo = $_POST['id_tarologo'];

if (empty($id_tarologo)) { 
	$id_tarologo = $_POST['tarologo_id']; 
}

if (empty($id_tarologo)) { 
	echo "<script>document.location.href='tarologos'</script>";
}

$cliente_online  = null;
$cliente_credito = null;
$cliente_entrou  = null;
$data = date("d-m-Y h:i:s");

//Verifica se cliente tem crédito
$sql_credito = $pdo->query("SELECT SUM(minutos_dispo) as soma FROM controle WHERE id_nome_cliente='$usuario_id' ");
$cont = $sql_credito->fetch(PDO::FETCH_ASSOC);
$valor = $cont["soma"];

if ($valor < $config_preco_consulta_email) {
  echo '<p>Você não tem minutos suficientes para esta consulta. <a href="comprar-consulta">Por gentileza compre um plano de minutos aqui para continuar seu atendimento.</a></p>';
	$cliente_credito = 'negado';
} else {
	$cliente_credito = 'positivo';
}

//Verifica se cliente esta online
$sql_online = $pdo->query("SELECT * FROM clientes WHERE id='$usuario_id' ");
while ($mostrar = $sql_online->fetch(PDO::FETCH_ASSOC)) {
	$row_online=$mostrar['online'];
}

if ($row_online == "offline" OR $row_online == "") {
	echo '<p>Você está desconectado. <a href="fazer-login">Você precisa estar conectado para usar este recurso, clique aqui para entrar ou criar uma conta.</a></p>';
	$cliente_online = 'negado';
} else {
	$cliente_online = 'positivo';
}

if ($cliente_online == 'positivo' AND $cliente_credito == 'positivo'){

	// Estancia dados do cliente
	$sql_cliente = $pdo->query("SELECT * FROM clientes WHERE id='$usuario_id' ");
    while ($mostrar = $sql_cliente->fetch(PDO::FETCH_ASSOC)) { 
    	$cliente_id=$mostrar['id'];
    	$cliente_nome=$mostrar['nome'];
    	$cliente_email=$mostrar['email'];
    }

	// Estancia dados do tarólogo
	$sql_tarologo = $pdo->query("SELECT * FROM clientes WHERE id='$id_tarologo' ");
    while ($mostrar2 = $sql_tarologo->fetch(PDO::FETCH_ASSOC)) { 
    	$tarologo_id=$mostrar2['id'];
    	$tarologo_nome=$mostrar2['nome'];
    	$tarologo_email=$mostrar2['email'];
    	$logo=$mostrar2['logo'];
    }
	?>

	<div id="formulario_email">

		<h2 class="text-success">Envie sua mensagem aqui</h2>

		<img src="tarologos_admin/fotos/<?php echo $logo; ?>" class="rounded" alt="<?php echo $tarologo_nome;?>" title="<?php echo $tarologo_nome;?>" style="max-width:200px; float: left;">
		<figcaption class="figure-caption">
			<?php echo $tarologo_nome; ?>
		</figcaption>
				<p><b><?php echo $cliente_nome; ?></b>, você gostaria de enviar uma mensagem para o(a) tarólogo(a) <b><?php echo $tarologo_nome; ?></b>?</p>
		<p>Não esqueça de mencionar o nome completo e data de nascimento seu e das pessoas envolvidas ou de quem queira saber informações em sua mensagem. Use o formulário abaixo.</p>

		<div id="respondercliente" style="clear:both; border:solid 1px #ccc; padding:5px; box-shadow: 5px 5px 10px #ccc; background:#eaeaea;">

			<form name="enviaEmailMensagem" method="post" action="">
			    
			    <input type="hidden" name="tarologo_id" value="<?php echo @$tarologo_id; ?>" />
			    <input type="hidden" name="tarologo_nome" value="<?php echo @$tarologo_nome; ?>" />
			    <input type="hidden" name="tarologo_email" value="<?php echo @$tarologo_email; ?>" />
			    <input type="hidden" name="cliente_id" value="<?php echo @$cliente_id; ?>" />
			    <input type="hidden" name="cliente_nome" value="<?php echo @$cliente_nome; ?>" />
			    <input type="hidden" name="cliente_email" value="<?php echo @$cliente_email; ?>" />

			    <div class="row" style="margin: 5px;">
					<div id="head1" style="float:left;">
						<?php echo 'De: <b>'.$cliente_nome.'</b><br/>'; ?>
						<?php echo 'Para: <b>'.$tarologo_nome.'</b><br/>'; ?>
						<?php echo 'Data: <b>'.$data.'</b><br/>'; ?>
					</div>
				</div>

				<hr style="border-top: 1px solid #ccc;">		

				<div class="row" style="margin-top: 0px; margin-bottom: 15px;">
	                <div class="col-md-12">
	                	<p><b>Assunto:</b></p>
	                    <input name="assunto" type="text" required class="form-control" placeholder="Assunto"  value="">
	                </div>
	            </div>

			    <div class="row">
	                <div class="col-md-12">
	                	<p><b>Mensagem:</b></p>
	                    <textarea name="mensagem" required class="form-control" placeholder="Mensagem" rows="12"/></textarea>
	                </div>
	            </div>
			    </br>

			    <div class="row">
	                <div class="col-md-12">
	                	<div style="margin-bottom: 10px; margin-left: 17px; margin-top: 10px;">
	                		<input class="btn btn-info btn-lg" type="submit" name="enviaEmailMensagem" value="Enviar Mensagem para <?php echo $tarologo_nome; ?>"/>
	                	</div>
	                </div>
	            </div>
			    </br>

			</form>

		</div>
	</div>

	<?php
	if(isset($_POST['enviaEmailMensagem'])){
		
		if ($valor >= $config_preco_consulta_email) {

			// Atualizar os minutos disponiveis do cliente
			$query = $pdo->query("UPDATE controle SET 
                minutos_dispo='0'
            WHERE id_nome_cliente='$usuario_id'");

			// Atualiza o credito menos com o valor do preço da consulta.
			$tempo_restante = $valor - $config_preco_consulta_email;

			$query = $pdo->query("UPDATE controle SET 
                minutos_dispo='$tempo_restante'
            WHERE id_nome_cliente='$usuario_id' AND status='PAGO' ORDER BY id DESC LIMIT 1 ");
		}

		$data = date("Y-m-d H:i:s");
		$tarologo_id = $_POST['tarologo_id'];
		$tarologo_nome = $_POST['tarologo_nome'];
		$tarologo_email = $_POST['tarologo_email'];
		$cliente_id = $_POST['cliente_id'];
		$cliente_nome = $_POST['cliente_nome'];
		$cliente_email = $_POST['cliente_email'];
		$assunto = $_POST['assunto'];
		$mensagem = $_POST['mensagem'];

		// Muda as variaveis
		$remetente = $cliente_id;
		$destinatario = $tarologo_id;
		$status = 'entrada';
		$assunto = $assunto;
		$mensagem = addslashes($mensagem);
		$escreveu = $cliente_id;

		// Grava no banco.
		$qq = $pdo->query("INSERT INTO mensagens (
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
		// Envia E-mail para o Tarólogo
        /* -----------------Mandando E-mail---------------------- */
		$assunto  = "Nova Mensagem E-mail - É Papo de Tarot";
        /*Configuramos os cabeçalho do e-mail*/
        $headers  = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=utf-8\r\n";
        $headers .= "From: É Papo de Tarot epapodetarot@gmail.com \r\n";
        $headers .= "Reply-To: epapodetarot@gmail.com \r\n";
        // $headers .= "BCC: logs@novasystems.com.br";
        /*Configuramos o conte?do do e-mail*/
        $conteudo = '
        Olá '.$tarologo_nome.', <br/>
        O cliente '.$cliente_nome.' acabou de te enviar uma nova <b>Mensagem</b>, e espera sua resposta no site É Papo de Tarot. <br/>
        Acesse o site, faça login, e vá até <b>Minha Conta / Mensagens</b> e clique em <b>Caixa de Entrada</b> você verá uma mensagem do cliente '.$cliente_nome.', clique em Ler e Responder Mensagem, e depois você poderá responder o cliente logo abaixo da mensagem, na mesma tela. </br>
        <b>Atenção</b>: Responda o clinete somente atravéz da <b>Minha Conta / Mensagens</b> no site.<br/>
        <br/>
        <b>Data do Envio da Mensagem:</b> '. $data .'<br/>
        <b>Assunto:</b> '. $assunto .'<br/>
        <b>Nome do Cliente:</b> '. $cliente_nome .'<br/>
        <br/>
        É Papo de Tarot<br/>
        <a href=\'https://www.epapodetarot.com.br/\'>www.epapodetarot.com.br</a>
        ';
        /*Enviando o e-mail...*/
        $enviando = mail($tarologo_email, $assunto, $conteudo, $headers);
        /* -----------------Mandando E-mail---------------------- */
        ?>
			<script type="text/javascript">
                $("#formulario_email").hide();
                $("#pre_texto").hide();
            </script>
        <?php

        echo '<div class="card card-body">';
	        echo '<div id="" style="border:solid 1px #ccc; padding:5px; box-shadow: 5px 5px 10px #ccc; background:#D4EBCA; color:#3C763D; ">';
		        echo "<h1><span style=''>Parabéns - Mensagem Enviada!</span></h1>";
		        echo '<p><b>'.$cliente_nome.'</b> sua mensagem foi enviada para o(a) tarólogo(a) <b>'.$tarologo_nome.'</b> e em breve você terá sua resposta.</p>';
		        echo '<p>Para ver a resposta acesse <b>Minha Conta / Mensagens, Caixa de Entrada</b>, aqui no site, fique atento pois somente lá poderá ver sua resposta que poderá chegar a qualquer momento do tarólogo.</p>';
		        echo '<p>Todas as mensagens de envio e resposta ficarão registradas em <b>Minha Conta / Mensagens, Caixa de Entrada</b>, acesse regularmente sua conta para não perder as mensagens.</p>';
	        echo '</div>';
        echo '</div>';
	}
}
?>