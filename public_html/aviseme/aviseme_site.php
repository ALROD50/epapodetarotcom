<?php 
date_default_timezone_set("Brazil/East"); // seta configurações fusuhorario para Brasil
ini_set ('default_charset', 'UTF-8'); // seta o php em UTF 8
ini_set('display_errors',0); // Força o PHP a mostrar os erros.
ini_set('display_startup_erros',0); // Força o PHP a mostrar os erros.
?>
<h1 class="azul mt-2"><i class="far fa-clock"></i> Avise-me Quando Disponível</h1>
<hr>
<!-- Necessário para funcionar a função de ocultar o formulário assim que for submetido. -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<?php
$id_tarologo = $_POST['id_tarologo'];

if (empty($id_tarologo)) { 
	$id_tarologo = $_GET['id_tarologo'];
}

$cliente_online  = null;
$cliente_credito = null;
$cliente_entrou  = null;
$data = date("Y-m-d H:i:s");

//Verifica se cliente esta online
$sql_online = $pdo->query("SELECT * FROM clientes WHERE id='$usuario_id' "); 
while ($mostrar = $sql_online->fetch(PDO::FETCH_ASSOC)) {
	$row_online=$mostrar['online'];
}

if ($row_online == "offline" OR $row_online == "") {
	echo "<script>document.location.href='fazer-login/?msge=Você está desconectado, faça login para usar este recurso.'</script>";
} else {
	$cliente_online = 'positivo';
}

if ($cliente_online == 'positivo'){

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

	<div class="card card-body" id="formulario_aviseme">
		<div class="row">
			<div class="col-md-4">
				<img src="tarologos_admin/fotos/<?php echo $logo; ?>" class="rounded" alt="<?php echo $tarologo_nome;?>" title="<?php echo $tarologo_nome;?>" style="max-width:100%;">
				<figcaption class="figure-caption">
					<?php echo $tarologo_nome; ?>
				</figcaption>
			</div>
			<div class="col-md-8">
				<p><b><?php echo $cliente_nome; ?></b>, você gostaria de receber um aviso quando o tarólogo(a) <b><?php echo $tarologo_nome; ?></b> estiver disponível?</p>
				<p>Isso é possível usando o <b>Avise-me</b>, basta clicar no botão verde abaixo, e prontinho, você vai ser avisando quando a(o) <?php echo $tarologo_nome; ?> estiver online!</p>

				<h3 class="vermelho"><i class="fas fa-envelope-open-text"></i> Você será avisado no e-mail: <?php echo $cliente_email; ?></h3>

				<form name="enviaEmail" method="post" action="">
				    <input type="hidden" name="tarologo_id" value="<?php echo @$tarologo_id; ?>" />
				    <input type="hidden" name="tarologo_nome" value="<?php echo @$tarologo_nome; ?>" />
				    <input type="hidden" name="tarologo_email" value="<?php echo @$tarologo_email; ?>" />
				    <input type="hidden" name="cliente_id" value="<?php echo @$cliente_id; ?>" />
				    <input type="hidden" name="cliente_nome" value="<?php echo @$cliente_nome; ?>" />
				    <input type="hidden" name="cliente_email" value="<?php echo @$cliente_email; ?>" />
				    <input class="btn btn-success btn-md" type="submit" name="enviaEmail" value="<?php echo $tarologo_nome; ?> Avise-me por E-mail"/>
				</form>
			</div>
		</div>
	</div>
	<?php
	
	// Avise-me por E-mail
	if(isset($_POST['enviaEmail'])){
		$tarologo_id = $_POST['tarologo_id'];
		$tarologo_nome = $_POST['tarologo_nome'];
		$tarologo_email = $_POST['tarologo_email'];
		$cliente_id = $_POST['cliente_id'];
		$cliente_nome = $_POST['cliente_nome'];
		$cliente_email = $_POST['cliente_email'];

		// Grava no banco aviseme.
		$pdo->query( "INSERT INTO aviseme (
		  data,
		  cliente_id,
		  tarologo_id,
		  tarologo_nome,
		  cliente_nome,
		  cliente_email
		) VALUES (
		  '$data',
		  '$cliente_id;',
		  '$tarologo_id',
		  '$tarologo_nome',
		  '$cliente_nome',
		  '$cliente_email'
		)");

		// Envia E-mail para o Tarólogo

        /* -----------------Mandando E-mail---------------------- */
        $assunto  = "Avise-me Quando Disponível - É Papo de Tarot";
        /*Configuramos os cabeçalho do e-mail*/
        $headers  = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=utf-8\r\n";
        $headers .= "From: É Papo de Tarot contato@epapodetarot.com.br \r\n";
        $headers .= "Reply-To: contato@epapodetarot.com.br \r\n";
        // $headers .= "BCC: logs@novasystems.com.br";
        /*Configuramos o conte?do do e-mail*/
        $conteudo = '
        Olá '.$tarologo_nome.', <br/>
        Um novo cliente acabou de usar o <b>Avise-me Quando Disponível</b>, e espera você retornar ao site É Papo de Tarot para que você possa atendê-lo. <br/>
        Acesse o site, faça login, e vá até <b>Minha Conta / Avise-me</b> e clique no botão <b>Avisar</b> para que este cliente receba um e-mail de que você ja esta online, disponível no site e esperando para atendê-lo.</br> 
        <br/>
        <b>Data do Registro:</b> '. $data .'<br/>
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
            $("#formulario_aviseme").hide();
        </script>
        <?php

        echo '<div class="card card-body">';
	        echo "<h1><span style='color:#669900'>Parabéns - Você Será Avisado!</span></h1>";
	        echo '<p><b>'.$cliente_nome.'</b> acabamos de alertar o(a) tarólogo(a) <b>'.$tarologo_nome.'</b> de que você gostaria de ser avisado assim que ele voltar online.</p>';
	        echo '<p>Assim que ele estiver disponível no site, ele irá te avisar por E-mail no <b>'.$cliente_email.'</b>, fique atento a sua caixa de entrada e spam, pois a qualquer momento poderá receber um e-mail do tarólogo informando que esta disponível em nosso site.</p>';
        echo '</div>';
	}
}
?>