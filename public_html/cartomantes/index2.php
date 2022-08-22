<?php
ini_set ('default_charset', 'UTF8');
date_default_timezone_set('America/Sao_Paulo');
header('X-UA-Compatible: IE=edge');
ini_set('display_errors',1); // Força o PHP a mostrar os erros.
ini_set('display_startup_erros',1); // Força o PHP a mostrar os erros.
error_reporting(E_ALL); // Força o PHP a mostrar os erros.
// phpinfo();
session_start();
require_once "/home/tarotdehoruscom/public_html/includes/conexaoPdo.php";
require_once "/home/tarotdehoruscom/public_html/includes/functions.php";
require_once "/home/tarotdehoruscom/public_html/includes/functions.php";
require_once "/home/tarotdehoruscom/public_html/scripts/PHPMailer-master5.2.22/class.phpmailer.php";
require_once "/home/tarotdehoruscom/public_html/scripts/PHPMailer-master5.2.22/class.smtp.php";
$pdo = conexao();
$ano = date("Y");
if (@$_POST['Cartomantes'] == 'confirmarcompraconsulta') {

	$nome             = $_POST['nome'];
	$email            = trim($_POST['email']);
	$whatsapp         = $_POST['whatsapp'];
	$datanascimento   = $_POST['datanascimento'];
	@$datanascimento  = date("Y-m-d", strtotime("$datanascimento"));
	$plano            = $_POST['plano'];

	// Verifica se e-mail ja existe no sistema  
	$sqlmailx = $pdo->query("SELECT * FROM clientes WHERE email='$email'");
	if ($sqlmailx->rowCount() >= 1){
	    
	    // o email ja esta cadastrado no sistema não cadastra de novo
	    echo "<script>document.location.href='https://www.tarotdehorus.com.br/comprar-consulta/chat/?msgs=Parabéns $nome, você já tem cadastro no site!<br>Vamos%20Realizar%20Sua%20Consulta!'</script>";
	    exit();

	} else { 

		setcookie('UsuarioID', null, -1, '/');
		setcookie('UsuarioNome', null, -1, '/');
		setcookie('UsuarioNivel', null, -1, '/');
		setcookie('UsuarioStatus', null, -1, '/');

		// email novo, realizando o cadastro do cliente
		$data_registro = date("Y-m-d H:i:s");
		$senha         = geraSenha(6, true, true, false);
		$senha2        = md5($senha);
	    $nome          = ucwords(strtolower($nome));
	    $queryInsert   = $pdo->query("INSERT INTO clientes (
	        nome,
	        email,
	        usuario,
	        senha,
	        aceita_termos_uso,
	        receber_email,
	        data_registro,
	        nivel,
	        telefone,
	        data_nascimento
	    ) VALUES (
	        '$nome',
	        '$email',
	        '$email',
	        '$senha2',
	        'SIM',
	        'SIM',
	        '$data_registro',
	        'CLIENTE',
	        '$whatsapp',
	        '$datanascimento'
	    )");
	    
	    // Faz login
	    $id_gerado = $pdo->lastInsertId();
	    
	    // Logando novo cliente
	    $query = $pdo->query("SELECT * FROM clientes WHERE id='$id_gerado' AND status!='CANCELADO' LIMIT 1");
		$resultado = $query->fetch(PDO::FETCH_ASSOC);
		
	    #### Sistema de login com Cookies -----------------------------------
	    @setcookie("UsuarioID", $resultado['id'], time()+3600*24*30*12*5, "/", NULL);
	    @setcookie("UsuarioNome", $resultado['nome'], time()+3600*24*30*12*5, "/", NULL);
	    @setcookie("UsuarioNivel", $resultado['nivel'], time()+3600*24*30*12*5, "/", NULL);
	    @setcookie("UsuarioStatus", $resultado['status'], time()+3600*24*30*12*5, "/", NULL);
	    @$usuario_id     = $_COOKIE["UsuarioID"];
	    @$usuario_nome   = $_COOKIE["UsuarioNome"];
	    @$usuario_nivel  = $_COOKIE["UsuarioNivel"];
	    @$usuario_status = $_COOKIE["UsuarioStatus"];
	    #### Sistema de login com Cookies -----------------------------------
		
	    //Registrar usuário como online
		$datacompleta2 = date("Y-m-d H:i:s");
		$query = $pdo->query("UPDATE clientes SET 
			online='online',
			time='$datacompleta2'
		WHERE id='$id_gerado'");

	    ###################### EMAIL ##############################
		$memaildestinatario = $email;
		$mnomedestinatario  = $nome;
		$massunto           = "Bem Vindo ao Tarot de Hórus";
		$mmensagem          = "
			<p>Obrigado por se registrar em nosso site, abaixo segue os seus dados de cadastro e login.</p>
			<p>$nome guarde bem estes dados, pois sempre que for usar o site, vai precisar deles:</p>
			<strong><strong>NOME:</strong> $nome <br/>
			<strong>E-MAIL:</strong> $email<br/>
			<strong>USUÁRIO:</strong> $email<br/>
			<strong>SENHA:</strong> $senha<br/>
			<br/>
			<br/>
			<b>Tarot de Hórus</b> <br/>
			contato@tarotdehorus.com.br <br/>
			Site: www.TarotDeHorus.com.br <br/>
		";
		EnviarEmail($memaildestinatario, $mnomedestinatario, $massunto, $mmensagem);
		###################### EMAIL ##############################

	    // Adiciona cliente no autoresponder ID 15
	    // ADICIONA OS E-MAILS NA LISTA DA CAMPANHA
	    $data_hoje = date('Y-m-d H:i:s');
	    $pdo->query("INSERT INTO mail_lista (
	        id_camp,
	        nome,
	        email,
	        data
	    ) VALUES (
	        '15',
	        '$nome',
	        '$email',
	        '$data_hoje'
	    )");

	    // Gerando Fatura
	    switch($plano) {
			case "10":
				$demonstrativo = "Consulta Via Chat - 10 Minutos = R$ 15,00";
				$minutos = "10";
				$valor = "15.00";
				$tipo  = "padrao";
				break;
			case "20":
				$demonstrativo = "Consulta Via Chat - 20 Minutos = R$ 30,00";
				$minutos = "20";
				$valor = "30.00";
				$tipo  = "padrao";
				break;
			case "30":
				$demonstrativo = "Consulta Via Chat - 30 Minutos = R$ 45,00";
				$minutos = "30";
				$valor = "45.00";
				$tipo  = "padrao";
				break;
			case "40":
				$demonstrativo = "Consulta Via Chat - 40 Minutos = R$ 60,00";
				$minutos = "40";
				$valor = "60.00";
				$tipo  = "padrao";
				break;
		}

	    $ref    = uniqid(NULL, true);
	    $vencimento     = date('d-m-Y', strtotime("+1 days"));
		$cod            = Codificador::Codifica("$id_gerado, $ref");
		$url            = 'https://www.tarotdehorus.com.br/pagamentos/pagar.php?cod='.$cod;

		// Transforma vencimento em dia util caso necessário
		$vencimento = proximoDiaUtil($vencimento, $saida = 'Y-m-d');

		$q = $pdo->query("INSERT INTO controle (
            id_nome_cliente,
            minutos,
            minutos_dispo,
            valor,
            cod_pagamento,
            status,
            data,
            metodo,
            tipo,
            vencimento,
            url,
            demonstrativo
        ) VALUES (
            '$id_gerado',
            '$minutos',
            '0',
            '$valor',
            '$ref', 
            'Aguardando', 
            '$data_hoje',
            '',
            '$tipo',
            '$vencimento',
            '$url',
			'$demonstrativo'
        )");

		###################### EMAIL ##############################
		$memaildestinatario = $email;
		$mnomedestinatario  = $nome;
		$massunto           = "Nova Cobrança Gerada Tarot de Hórus";
		$mmensagem          = "
			<p>Olá <b>$nome</b>, </p>
			<p>Estes são os dados para realizar sua consulta.</p>
			<strong>Demonstrativo:</strong> $demonstrativo <br/>
			<strong>Valor:</strong> $valor <br/>
			<strong>Código:</strong> $ref <br/>
			<strong>Data Vencimento:</strong> $vencimento <br/>
			<strong>Link para pagamento:</strong> <a href=".$url.">$url</a> <br/>
			<p>Caso não seja possível clicar no link da cobrança acima, tente copiar todo o endereço e colar na barra de navegação do seu navegador de internet.</p>
			<p>Conclua seu pagamento para realizar sua consulta.</p>
			<p>Para mais detalhes acesse sua conta em:</p>
			<p><b>Minha Conta:</b></p>
			<p><a href='https://www.tarotdehorus.com.br/minha-conta/'>https://www.tarotdehorus.com.br/minha-conta</a></p>
			<br/>
			<br/>
			<b>Tarot de Hórus</b> <br/>
			Departamento Financeiro <br/>
			contato@tarotdehorus.com.br <br/>
			Site: www.TarotDeHorus.com.br <br/>
		";
		EnviarEmail($memaildestinatario, $mnomedestinatario, $massunto, $mmensagem);
		###################### EMAIL ##############################
		
		echo "<script>document.location.href='https://www.tarotdehorus.com.br/pagamentos/pagar.php?cod=$cod'</script>";
	}

}
?>
<!DOCTYPE html>
<html lang="pt-br">
	<head>
	    <script type="text/javascript">
	    var _smartsupp = _smartsupp || {};
	    _smartsupp.key = 'd91a374ad4f38486598b3f199ba67bc15239def7';
	    window.smartsupp||(function(d) {
	      var s,c,o=smartsupp=function(){ o._.push(arguments)};o._=[];
	      s=d.getElementsByTagName('script')[0];c=d.createElement('script');
	      c.type='text/javascript';c.charset='utf-8';c.async=true;
	      c.src='https://www.smartsuppchat.com/loader.js?';s.parentNode.insertBefore(c,s);
	    })(document);
	    </script>
		<!-- Global Google  -->
	    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-163758748-1" crossorigin="anonymous"></script>
	    <script>
	      window.dataLayer = window.dataLayer || [];
	      function gtag(){dataLayer.push(arguments);}
	      gtag('js', new Date());
	      gtag('config', 'UA-163758748-1'); // Global site tag (gtag.js) - Google Analytics
	      gtag('config', 'AW-623703979'); // tag conversão
	    </script>

		<meta charset="UTF-8"/>
		<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
		<title>Sensitivos Online</title>
		<base href="https://www.tarotdehorus.com.br"/>
		<meta name="keywords" content="Tarot de Hórus, Consultas de Tarot Online, Tarot, Buzios, Baralho Cigano, Tarô, Consultas via Chat, Taro, Cartomancia, Taro, Búzios, Runas, Numerologia, Reiki, Umbanda, Candomblé, Trabalhos Espirituais, Consultas Espirituais, Consultas Espirituais a distância, Jogo de Búzios a distância, Jogo de Baralho Cigano Online, Consultas Espirituais Online, Cartomancia, Sensitivos, Videntes, Consultas Esotéricas, Magia, Leitura de Baralho Cigano, Leitura Cartas de Tarot, Leitura Tarô do Amor, Jogar Cartas Online, Ele Me Ama, Ele Me Trai?, Sensitivos" />
		<meta name="description" content="Tarot de Hórus - Consultas de Tarot Online: Tarot, Buzios, Baralho Cigano, Tarô Consultas via Chat, Conselhos Videntes ao Vivo, Consultas Tarô, Faça seu cadastro e compre seus créditos, Sensitivos" />
		<meta name="author" content="Agência Nova Systems Marketing Digital"/>
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link rel="shortcut icon" href="https://www.tarotdehorus.com.br/images/favicon.ico" />
		<meta property="og:image" name="og:image" content="https://www.tarotdehorus.com.br/images/metapropertyimg/home.webp"/>
		<link rel="stylesheet" href="https://www.tarotdehorus.com.br/assets/preloader.css"/>
		<!--[if lt IE 9]>
	      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	    <![endif]-->
	    <!-- Global site tag (gtag.js) - Google Ads: 623703979 -->
	</head>
	<body role="document">

		<!-- Preloader -->
	    <div id="preloader">
	        <div class="inner">
	            <div class="bolas">
	                <div></div>
	                <div></div>
	                <div></div>                    
	            </div>
	        </div>
	    </div>

		<div class="container">
			
			<header>
				<div id="header" class="p-4">
					<center>
						<img id="sizelogo" src="../images/Logo-Site.fw.webp" alt="Site Tarot de Hórus" title="Site Tarot de Hórus" style="max-width:300px;"/><br>	
						<small class="text-white">Sensitivos</small>
					</center>
				</div>
			</header>
			
			<main role="main">
				<?php
				require_once "../includes/msg.php";
				?>

				<div id="geral" class="p-3">	
					
					<center>
						<h2 style="margin-top:15px;color: #0e0c0c;text-shadow: 0px 2px 4px #da8345;"><i class="fas fa-comments"></i> Fale Com Um Sensitivo Online Agora!</h2>
					  	<h4 style="margin-top:0px;color: #963f10;text-shadow: 0px 2px 4px #da8345;">Acalme o seu coração e pergunte sobre a sua VIDA AMOROSA. Está a procura de um EMPREGO ou quer mudar de PROFISSÃO? Como anda a sua Saúde? Sua FAMÍLIA, como está?</h4>
					  	<h4 style="margin-top:0px;color: #636f03;text-shadow: 0px 2px 4px #da8345;">Os atendimentos ocorrem via Chat, E-mail ou WhatsApp, em texto. A consulta é SIGILOSA, você não aparece e poderá ficar mais à vontade para fazer as suas perguntas.</h4>
					  	<p><i class="fas fa-hat-wizard"></i> Leitura de Baralho Cigano, Marselha, Cartas de Tarot, Tarô do Amor, Jogar Cartas Online, Tarologos, Sensitivos</p>
					</center>

					<div class="row my-3">
					  <div class="col-md-1"></div>
					  <div class="col-xl-10 col-lg-10 col-md-10 col-sm-12 col-xs-12 mb-2">
					  	<img class="rounded img-fluid" title="Tarot" src="../images/tarot4.jpg" alt="Tarot">
					    <!-- <div class="embed-responsive embed-responsive-16by9">
					      <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/arTGcm1vl74" allowfullscreen frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"></iframe>
					    </div> -->
					    <!-- <center><p><b><i class="fas fa-address-card"></i> Patrícia</b> é: Especialista em Esoterismo no Tarot de Hórus</p></center> -->
					  </div>
					  <div class="col-md-1"></div>
					</div>

					<center>
						<p><i class="fas fa-star-and-crescent"></i><img src="https://www.tarotdehorus.com.br/images/logotexto.webp" alt="Tarot de Hórus" title="Tarot de Hórus"><i class="fas fa-star-and-crescent"></i></p>
						<p><b><i class="fas fa-ankh"></i> Tarot de Hórus</b> é um portal de conhecimento e luz, temos uma equipe especializada na leitura dos oráculos, que trabalham utilizando o tarot, runas, baralhos e diversos métodos como forma de autoconhecimento, aprendizagem e reflexão do ser e espírito, tudo através de consultas online. Nossa equipe foi rigorosamente selecionada em cada um de seus conhecimentos e dons especiais, onde são utilizadas em consultas via chat, com a intenção de auxiliar e orientar, para que você possa tomar a melhor decisão ou o melhor caminho a seguir na questão que lhe aflige, conheça!</p>
					</center>

					<!-- <h1 class="text-dark mt-4"><i class="fas fa-question-circle"></i> O que eu posso perguntar ao Sensitivo?</h1>
					<hr>

					<div class="row">
						<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-xs-12">
							<div class="card-body mb-3">
								<h3 class="title2"><i class="fas fa-heart"></i> No Amor</h3>
								<p><i class="far fa-lightbulb"></i> <b>Saiba</b>:<br>
								- Ele Me Ama...<br>
								- Ele Me Trai?...<br>
								- Vamos Voltar?...<br>
								- Seremos Felizes?...<br>
								- Conseguirei Aquele Amor?...<br>
								- O Que Ele Sente Por Min?...<br>
								- Poderei Engravidar?...<br>
								</p>
							</div>
						</div>
						<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-xs-12">
							<div class="card-body mb-3">
								<h3 class="title2"><i class="fas fa-medkit"></i> Na Saúde</h3>
								<p><i class="far fa-lightbulb"></i> <b>Saiba</b>:<br>
								- Estou Doente?...<br>
								- Tenho Cura?...<br>
								- X Pessoa Esta Bem?...<br>
								- A COVID-19 na Minha Vida...<br>
								- Vou Conseguir Emagrecer?...<br>
								</p>
							</div>
						</div>
						<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-xs-12">
							<div class="card-body mb-3">
								<h3 class="title2"><i class="fas fa-house-user"></i> Na Família</h3>
								<p><i class="far fa-lightbulb"></i> <b>Saiba</b>:<br>
								- Alguém Me Bloqueia...<br>
								- Meus Irmãos...<br>
								- Meus Pais...<br>
								- Serei Mãe...<br>
								- Meu Filho Esta Bem?...<br>
								- Briguei Com Um Familiar e Agora?...<br>
								</p>
							</div>
						</div>
						<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-xs-12">
							<div class="card-body mb-3">
								<h3 class="title2"><i class="fas fa-building"></i> No Trabalho</h3>
								<p><i class="far fa-lightbulb"></i> <b>Saiba</b>:<br>
								- Devo Mudar de Profissão?...<br>
								- As Coisas Vão Melhorar?...<br>
								- Terei Sucesso Na Minha Área?...<br>
								- Estou Sendo Sabotado, Roubado?...<br>
								- É a Hora Certa de Investir Mais?...<br>
								</p>
							</div>
						</div>
						<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
							<div class="card-body mb-3">
								<h3 class="title2"><i class="fas fa-users"></i> Geral</h3>
								<p><i class="far fa-lightbulb"></i> <b>Saiba</b>:<br>
								- Vou Conseguir Aquela Viagem?...<br>
								- Onde Posso Melhorar Espiritualmente?...<br>
								- Como Diminuir a Angustia...<br>
								- Como Me Livrar da Ansiedade...<br>
								- Como Sair Dessa Situação...<br>
								</p>
							</div>
						</div>
					</div>
					
					<div class="bg-dark my-3 text-center p-3 text-white">
					  <i class="fas fa-hat-wizard"></i> E muito mais... você pode perguntar qualquer assunto...
					</div>

					<h1 class="text-dark mt-4"><i class="fas fa-question-circle"></i> Principais Dúvidas</h1>
					<hr>
					<div class="accordion" id="accordionExample">
					  <div class="card">
					    <div class="card-header" id="headingOne">
					      <h1 class="mb-0">
					        <button class="btn btn-link btn-block btn-lg text-left" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
					          <i class="far fa-lightbulb"></i> O taróloga vai me ver durante a consulta?
					        </button>
					      </h1>
					    </div>

					    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
					      <div class="card-body">
					        Não, sua imagem não aparece! Você não precisa ter câmera de video. Você vai conseguir ver a foto de perfil do tarólogo e a conversa será toda via texto. Então não se preocupe pois sua identidade permanecerá em sigilo total.
					      </div>
					    </div>
					  </div>
					  <div class="card">
					    <div class="card-header" id="headingTwo">
					      <h1 class="mb-0">
					        <button class="btn btn-link btn-block btn-lg text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
					          <i class="far fa-lightbulb"></i> Eu posso ser identificado por outra pessoa?
					        </button>
					      </h1>
					    </div>
					    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
					      <div class="card-body">
					        Não. Sua imagem não aparece no site, coletamos o mínimo de dados apenas para contato e administração do site. Nenhuma outra pessoa, tarólogo ou empresa dentro ou fora do site tem acesso aos seus dados pessoais. Tudo está guardado com a segurança mais moderna possível, e com criptografia de última geração, você está protegido, oculto e seguro para todos.
					      </div>
					    </div>
					  </div>
					  <div class="card">
					    <div class="card-header" id="headingThree">
					      <h1 class="mb-0">
					        <button class="btn btn-link btn-block btn-lg text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
					          <i class="far fa-lightbulb"></i> Em 10 minutos consigo fazer minha consulta?
					        </button>
					      </h1>
					    </div>
					    <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
					      <div class="card-body">
					        Sim, em 10 minutos é possível fazer 1 pergunta, podendo ser explorado vários aspectos da sua questão. Na verdade, não há limite para perguntas, você pode fazer quantas quiser. Claro quanto mais tempo, mais poderá saber sobre sua situação, pois o consultor vai poder entender melhor cada pergunta e assim te explicar com mais detalhes cada situação.
					      </div>
					    </div>
					  </div>
					  <div class="card">
					    <div class="card-header" id="headingThree">
					      <h1 class="mb-0">
					        <button class="btn btn-link btn-block btn-lg text-left collapsed" type="button" data-toggle="collapse" data-target="#collapse4" aria-expanded="false" aria-controls="collapse4">
					          <i class="far fa-lightbulb"></i> Posso fazer a consulta no meu celular?
					        </button>
					      </h1>
					    </div>
					    <div id="collapse4" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
					      <div class="card-body">
					        O site é totalmente adaptado para funcionar no seu celular, com todas as funções normais. Pode efetuar a compra dos minutos e pode realizar a consulta no chat do site normalmente.
					      </div>
					    </div>
					  </div>
					  <div class="card d-none">
					    <div class="card-header" id="headingThree">
					      <h1 class="mb-0">
					        <button class="btn btn-link btn-block btn-lg text-left collapsed" type="button" data-toggle="collapse" data-target="#collapse5" aria-expanded="false" aria-controls="collapse5">
					          <i class="far fa-lightbulb"></i> Após comprar os minutos, quanto tempo demora para começar?
					        </button>
					      </h1>
					    </div>
					    <div id="collapse5" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
					      <div class="card-body">
					        É imediato via chat! Após sua compra, basta escolher um tarólogo que esteja online. O tarólogo vai te atender no mesmo momento.
					      </div>
					    </div>
					  </div>
					  <div class="card">
					    <div class="card-header" id="headingThree">
					      <h1 class="mb-0">
					        <button class="btn btn-link btn-block btn-lg text-left collapsed" type="button" data-toggle="collapse" data-target="#collapse6" aria-expanded="false" aria-controls="collapse6">
					          <i class="far fa-lightbulb"></i> Como os tarólogos trabalham?
					        </button>
					      </h1>
					    </div>
					    <div id="collapse6" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
					      <div class="card-body">
					        Nossos profissionais foram selecionados a dedo. Temos excelentes profissionais com muitos anos de experiencia em esoterismo. Cada profissional trabalha no seu local particular, que pode ser por exemplo, um HomeOffice. É um local reservado para o trabalho no site, onde faz conexão com o nosso site, permanece online para falar com você. Cada consultor possui técnicas, oráculos, dons e mediunidades particulares. Veja no perfil de cada um deles. Quando a consulta começa, o seu consultor prepara as cartas e oráculos, neste momento ele abre o jogo fazendo a leitura e analise baseado nas suas perguntas e questões de vida.
					      </div>
					    </div>
					  </div>
					  <div class="card d-none">
					    <div class="card-header" id="headingThree">
					      <h1 class="mb-0">
					        <button class="btn btn-link btn-block btn-lg text-left collapsed" type="button" data-toggle="collapse" data-target="#collapse7" aria-expanded="false" aria-controls="collapse7">
					          <i class="far fa-lightbulb"></i> A consulta é muito cara?
					        </button>
					      </h1>
					    </div>
					    <div id="collapse7" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
					      <div class="card-body">
					        Não, apenas R$ 1,50 o minuto. Por exemplo, em 10 minutos de consulta, você paga apenas R$ 15,00 reais. E você pode pagar com:  Cartão de Crédito, Débito, Boleto, Transferência, Paypal, PagSeguro ou Mercado Pago.
					      </div>
					    </div>
					  </div>
					  <div class="card">
					    <div class="card-header" id="headingThree">
					      <h1 class="mb-0">
					        <button class="btn btn-link btn-block btn-lg text-left collapsed" type="button" data-toggle="collapse" data-target="#collapse8" aria-expanded="false" aria-controls="collapse8">
					          <i class="far fa-lightbulb"></i> Onde a consulta acontece?
					        </button>
					      </h1>
					    </div>
					    <div id="collapse8" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
					      <div class="card-body">
					        Aqui mesmo nesse site, em sala reservada, um chat, onde somente você e o tarólogos entraram, é muito parecido com uma conversa privada no whatsapp, onde só você e a pessoa conversam.
					      </div>
					    </div>
					  </div>
					</div> -->

					<center>
				      <h2 style="margin-top:30px;color: #0e0c0c;text-shadow: 0px 2px 4px #da8345;"><i class="fas fa-gem"></i> Sensitivos</h2>
				      <p><i class="fas fa-mouse-pointer"></i> Escolha um TARÓLOGO e faça todas as perguntas com total sigilo e privacidade.</p>
				    </center>
					
					<hr>

					<div class="row">
						<?php
						$result = $pdo->query("SELECT * FROM clientes WHERE nivel='TAROLOGO' AND status='ATIVO' AND fotoreal!='' ORDER BY nome ASC");
						$row_online = $result->rowCount();
						while ($mostrar2 = $result->fetch(PDO::FETCH_ASSOC)) {
							$id=$mostrar2['id'];
							$nome=$mostrar2['nome'];
							$alias=$mostrar2['alias'];
							$especialidades2=utf8_decode($mostrar2['especialidade_taro']);
							$infos2=$mostrar2['infos'];
							$descricaocurta=$mostrar2['infos2'];
							$descricaocurta = strip_tags($descricaocurta);
							$descricaocurta = strip_tags(limita_caracteres($descricaocurta, 300, false));
							$logo2=$mostrar2['logo'];
							$nome2=$mostrar2['nome2'];
    						$fotoreal=$mostrar2['fotoreal'];
							?>
							<!-- Modal -->
							<div class="modal fade" id="verperfil<?php echo $id; ?>" tabindex="-1" aria-labelledby="verperfil<?php echo $id; ?>" aria-hidden="true">
							  <div class="modal-dialog">
							    <div class="modal-content">
							      <div class="modal-header">
							        <h5 class="modal-title" id="verperfil<?php echo $id; ?>">Tarologo: <?php echo $nome; ?></h5>
							      	<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="opacity: 1 !important;z-index: 99999;">
							          <span aria-hidden="true"><i class="fas fa-times-circle text-danger"></i></span>
							        </button>
							      </div>
							      <div class="modal-body">
							        <h2 style="margin-top:15px;color: #0e0c0c;text-shadow: 0px 2px 4px #da8345;"><i class="fas fa-ankh"></i> <?php echo $nome; ?></h2>
							        <img src="../tarologos_admin/fotos/<?php echo $logo2; ?>" class="rounded img-fluid" alt="<?php echo $nome;?>" title="<?php echo $nome2;?>">
							        <hr>
							        <p><i class="fas fa-address-card"></i> <?php echo $nome; ?> é representada(o) por:</p>
							        <?php echo $infos2; ?>
								  	<p style="font-size:30px; color: #9e3434;"><b><i class="fas fa-star-and-crescent"></i> ORÁCULOS</b>:</p>
									<p><?php echo $especialidades2;?></p>
									<div style="clear:both;"></div>
									<hr style="border: 1px solid #ccc;">
									<h1 class="text-success"><i class="fas fa-medal"></i> DEPOIMENTOS</h1>
									<?php
									//Estanciando dados dos depoimentos
									$executa = $pdo->query("SELECT * FROM depoimentos WHERE id_tarologo='$id' AND habilitado='SIM' ORDER by id DESC");
									$encontrados = $executa->rowCount();
									while ($dadoss= $executa->fetch(PDO::FETCH_ASSOC)) {
										$mensagem=$dadoss['mensagem'];
										$pontuacao=$dadoss['pontuacao'];
									  	$data  = $dadoss['data'];
									  	$data  = date("d-m-Y", strtotime("$data"));
										?>
										<div class="card card-body mb-3" id="depoimento">
									    <p><i class="fas fa-star"></i> <?php echo '<b>Pontuação:</b> '.$pontuacao; ?><br>
									    <small class="text-muted">Enviado em: <?php echo $data; ?> </small></p>
										    <?php echo $mensagem; ?>
											</div>
										<?php 
									} 
									if ($encontrados == 0) {
									  	echo '<p>';
									  	echo '(0) depoimentos...';
									  	echo '</p>';
									}
									?>
							      </div>
							      <div class="modal-footer">
							        <button type="button" class="btn btn-danger" data-dismiss="modal" style="position: fixed;bottom: 0px;"><i class="fas fa-times-circle"></i> Fechar</button>
							      </div>
							    </div>
							  </div>
							</div>
							<!-- Modal -->
							<div id="tarologoshomeresultado" class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12 shadow" style="margin-bottom:15px;">
								<!-- Foto, nome e oraculos -->
								<div style="background-image: url('../images/bg_tarologo.jpg');">

									<div style="padding-top: 45px;">
									  <center>
									  	<h2 style="margin-top:15px;color: #0e0c0c;text-shadow: 0px 2px 4px #da8345;"><i class="fas fa-ankh"></i> <?php echo $nome; ?></h2>
									  </center>
									</div>

								  <center>
								    <div style="background: url('tarologos_admin/fotos/<?php echo $logo2;?>');width:90%;height:250px;margin-top:7px;border:none;background-size:cover;background-position:50% 50%;" class="rounded efeitodois"  alt="<?php echo $nome2;?>" title="<?php echo $nome2;?>"></div>
								  </center>
									
									<div style="margin:0px;padding:10px 10px 0 10px;color:#000000;background:#ffffff91;">
									  <center>
									    <p><?php echo $descricaocurta;?></p>
									  </center>
									</div>
									      
									<div class="mb-2">
									  <button type="button" class="btn btn-dark btn-lg btn-block" data-toggle="modal" data-target="#verperfil<?php echo $id; ?>"><i class="fas fa-eye"></i> Ver Perfil Completo</button>
									</div>

									<div class="mb-2">
										<button type="button" class="btn btn-success btn-lg btn-block" onclick="Consultar();"><i class="fas fa-comments"></i> Consultar</button>
									</div>  
								</div>
							</div>
							<?php
						}
						?>
					</div>

					<hr>

					<center>
						<h3 style="margin-top:30px;color: #963f10;text-shadow: 0px 2px 4px #da8345;"><i class="fas fa-om"></i> Vamos Fazer Sua Consulta Agora?</h3>
						<!-- <h4>Se tudo isso faz sentido para você, e precisa de orientação, fazendo uma consulta com um sensitivo online, preencha os dados abaixo para começar sua consulta particular.</h4> -->
						<h4><i class="fas fa-mug-hot mt-3"></i> Preencha os dados para começar...</h4>
					</center>

					<div class="row py-4">
					    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12 offset-xl-3 offset-lg-3">

					    	<form name="Lptarotdehorus" id="Lptarotdehorus" method="post" action="" class="form-horizontal shadow" style="border: solid #2cb035 1px;padding: 15px; background: #fff;">

					            <input type="hidden" name="Cartomantes">
					            
					            <div class="form-group">
					                <label><i class="fas fa-user-circle"></i> Seu Completo:</label>
					                <input type="text" class="form-control input-lg" name="nome" id="nome" value="<?php echo $nome = isset($_POST['nome']) ? $_POST['nome'] : ''; ?>" placeholder="Seu Nome Completo" required  onblur="CampoPreenchido(nome, this.id);"/>
					                <small>O tarólogo precisa do seu nome completo</small>
									<div id="nomeNaoValido" style="display: none; clear: both; color: #ff0000; font-size:18px;">
					                    <i class="fas fa-exclamation-circle"></i> Informe o nome corretamente.
					                </div>
					            </div>
					            <div class="form-group">
					                <label><i class="fas fa-envelope-open-text"></i> E-mail:</label>
					                <input type="text" class="form-control input-lg" id="email" name="email" value="<?php echo $email = isset($_POST['email']) ? $_POST['email'] : ''; ?>" placeholder="Digite seu melhor e-mail" required onblur="testaemail(email, this.id);" />
					                <small>Vamos enviar o acesso ao chat no seu e-mail.</small>
									<div id="emailNaoValido" style="display: none; clear: both; color: #ff0000; font-size:18px;">
					                    <i class="fas fa-exclamation-circle"></i> Informe o e-mail corretamente.
					                </div>
					            </div>
					            <div class="form-group">
					                <label><i class="fab fa-whatsapp"></i> WhatsApp:</label>
					                <input type="tel" class="form-control input-lg" id="whatsapp" name="whatsapp" value="<?php echo $whatsapp = isset($_POST['whatsapp']) ? $_POST['whatsapp'] : ''; ?>" placeholder="Digite seu Whatsapp" data-mask="(00) 00000-0000" required onblur="testaCelular(this.value, this.id);" />
					                <small>Vamos enviar os dados da consulta no seu whatsapp</small>
									<div id="whatsappNaoValido" style="display: none; clear: both; color: #ff0000; font-size:18px;">
					                    <i class="fas fa-exclamation-circle"></i> Informe o seu whatsapp corretamente.
					                </div>
					                <div id="msgecel"></div>
					            </div>
					            <div class="form-group">
					                <label><i class="fas fa-calendar-alt"></i> Data de Nascimento:</label>
					                <input type="tel" class="form-control input-lg" id="datanascimento" name="datanascimento" value="<?php echo $datanascimento = isset($_POST['datanascimento']) ? $_POST['datanascimento'] : ''; ?>" placeholder="00/00/0000" data-mask="00/00/0000" required onblur="testaDatadeNascimento(this.value, this.id);" />
					                <small>O tarólogo precisa da sua data de nascimento para a consulta</small>
									<div id="datanascimentoNaoValido" style="display: none; clear: both; color: #ff0000; font-size:18px;">
					                    <i class="fas fa-exclamation-circle"></i> Informe sua data de nascimento corretamente.
					                </div>
					            </div>
					            <div class="form-group">
					                <label><i class="fas fa-clock"></i> Tempo da Consulta:</label>
					                <select name="plano" id="plano" class="form-control input-lg" required onblur="CampoPreenchido(plano, this.id);">
										<option value="" selected> -- Selecione -- </option>
										<option value="10">10 Minutos De Consulta</option>  
										<option value="20">20 Minutos De Consulta</option> 
										<option value="30">30 Minutos De Consulta</option> 
										<option value="40">40 Minutos De Consulta</option> 
									</select>
									<small>Informe o tempo total da sua consulta</small>
									<div id="planoNaoValido" style="display: none; clear: both; color: #ff0000; font-size:18px;">
				                        <i class="fas fa-exclamation-circle"></i> Selecione o tempo antes de continuar
				                    </div>
					            </div>
	
					            <div class="form-group">
							    	<center>
							    		<img src="../images/Arrows_down_animated.gif" style="max-width: 55px;">
							    		<button type="button" class="btn btn-lg btn-primary btn-block text-white shadow" name="confirmarcompraconsulta" id="confirmarcompraconsulta"><i class="fas fa-arrow-right"></i> Consultar</button>
							    		<div id="carregando" class="text-center mt-3" style="display:none;">
										  <div class="spinner-border" role="status" aria-hidden="true"></div>
										  Carregando...
										</div>
							    		<small>Clique no botão acima para iniciar...</small>
			    						<p><i class="fas fa-angle-up"></i></br>
			    						<figure class="figure">
									      	<!-- <img class="rounded img-fluid" title="Tarologa Patricia" src="../tarologos_admin/fotoreal/patty2.jpg" alt="Tarologa Patricia">
									      	<p><b><i class="fas fa-address-card"></i> Patrícia</b> é: Especialista em Esoterismo no Tarot de Hórus</p> -->
									      	<figcaption class="figure-caption mt-2">
												<h3 class="text-success"><i class="fas fa-om"></i> Boa Consulta, Gratidão!</h3>
												<small><?php echo date("d/m/Y"); ?> </small>
									      	</figcaption>
									    </figure>
							        </center>
					            </div>
					        </form>


					    </div>
					</div>

			        <div class="row justify-content-center my-3">
						<center>
							<p><i class="fab fa-expeditedssl"></i> O site Tarot de Hórus usa técnologias de última geração na segurança e proteção de dados, com criptografia e certificado SSL.</p>
							<p>
								<img src="../images/sseguranca.webp" class="img-fluid d-none" alt="Site Seguro" title="Site Seguro" style="max-height: 0px;"> <img src="../images/seguranca.png" class="img-fluid" alt="Site Seguro" title="Site Seguro" style="max-height: 45px;"> <img src="../images/selo-sitechecksucuri.webp" class="img-fluid" alt="Site Seguro" title="Site Seguro" style="max-height: 30px;">
							</p>
						</center>
					</div>
					
					<!-- Pagamentos -->
					<div class="row justify-content-center my-3 d-none">
						<?php 
						/* Diretorio que deve ser lido */
						$path = "../images/pagamento";
						/* Abre o diretório */
						@$pasta= opendir($path);
						/* Loop para ler os arquivos do diretorio */
						while (@$arquivo = readdir($pasta)) {
							/* Verificacao para exibir apenas os arquivos e nao os caminhos para diretorios superiores */
							@$ext = strtolower(end(explode(".", $arquivo)));
							if ($arquivo != '.' && $arquivo != '..' && $ext != 'zip' && $ext != 'php' && $ext != 'html' && $arquivo != 'error_log') {
								//$arquivox = limita_caracteres($arquivo, 10, true);
								// Se for imagem
								if ($ext == 'jpg' OR $ext == 'jpeg' OR $ext == 'png' OR $ext == 'gif' OR $ext == 'bmp') {
									?>
									<center>
										<p>
											<img src='<?php echo $path."/".$arquivo; ?>' class="img-fluid" alt="Esotéricos Tarot Online Chat Baralho Cigano Tarólogos" style="max-height:30px;"/>
										</p>
									</center>
									<?php
								}
							}
						}
						?>
				    </div>

				</div>

			</main>

			<footer>
				<div style="background:rgba(9, 8, 8, 0.72);color:#ffffff;padding:20px;font-family:initial;font-size:15px;margin-right:0px;margin-left:0px;border-top:3px solid #f7b334;">
					<center>
						<p>&copy; Tarot de Hórus <?php echo $ano; ?> <i class="glyphicon glyphicon-lock"></i> Site Protegido</br>
						<i class="glyphicon glyphicon-earphone"></i> Suporte de Seg à Sex das 10H às 22H</br>
						<a href="https://api.whatsapp.com/send?phone=5511941190306&text=Olá Tarot de Hórus, pode me ajudar com uma duvida?" style="color:#afb733;"><i class="fab fa-whatsapp"></i> (11) 94119-0306 - Suporte</a></br>
						<i class="fas fa-envelope"></i> contato@tarotdehorus.com.br</br>
						<i class="fas fa-map-marker-alt"></i> Rua Vergueiro, 1000 - Paraíso, São Paulo - SP, 01504-000</p>
						<i class="fas fa-user-lock"></i> Site 100% Seguro</br>
						<i class="fab fa-facebook-square"></i>&nbsp;&nbsp;<i class="fab fa-instagram-square"></i>&nbsp;&nbsp;<i class="fab fa-youtube-square"></i> @TarotDeHorus
					</center>
				</div>
			</footer>

			<div id="depoimentos">
				<button class="pointer btn-group-sm btn-default" data-toggle="modal" data-target="#VerDepoimentos" title='Depoimentos'><i class="fas fa-eye"></i> Ver Depoimentos</button>
			</div>

			<!-- VerDepoimentos -->
			<div class="modal fade" id="VerDepoimentos" tabindex="-1" aria-labelledby="VerDepoimentos" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<h1 class="modal-title text-success" id="VerDepoimentos"><i class="fas fa-medal"></i> Depoimentos</h1>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="opacity: 1 !important;z-index: 99999;">
					          <span aria-hidden="true"><i class="fas fa-times-circle text-danger"></i></span>
					        </button>
						</div>
						<div class="modal-body">
							<?php
							//Estanciando dados dos depoimentos
							$executa = $pdo->query("SELECT * FROM depoimentos WHERE habilitado='SIM' ORDER BY id DESC");
							$encontrados = $executa->rowCount();
							while ($dadoss= $executa->fetch(PDO::FETCH_ASSOC))
							{
								$id_tarologo=$dadoss['id_tarologo'];
								$id_cliente=$dadoss['id_cliente'];
								$mensagem=$dadoss['mensagem'];
								$mensagem = strip_tags($mensagem);
								$mensagem = ucfirst(strtolower($mensagem));
								$pontuacao=$dadoss['pontuacao'];
								$data  = $dadoss['data'];
								$data  = date("d-m-Y", strtotime("$data"));

								//Estancia dados do Tarólogo
								$executa3 = $pdo->query("SELECT * FROM clientes WHERE id='$id_tarologo'");
								while ($dadoss3= $executa3->fetch(PDO::FETCH_ASSOC)) {
								  $tarologo_nome=$dadoss3['nome'];
								}
								?>
								<div class="card card-body mb-3">
							    	<p><i class="fas fa-star"></i> <?php echo '<b>Pontuação:</b> '.$pontuacao; ?><br>
							    	<small class="text-muted">Enviado em: <?php echo $data; ?><br>
							    	Para: <?php echo $tarologo_nome; ?> </small></p>
								    <?php echo $mensagem; ?>
								</div>
								<?php 
							} 
							?>
						</div>
						<div class="modal-footer">
					        <button type="button" class="btn btn-danger" data-dismiss="modal" style="position: fixed;bottom: 0px;"><i class="fas fa-times-circle"></i> Fechar</button>
					    </div>
					</div>
				</div>
			</div>
			<!-- VerDepoimentos -->

		</div>
		<style><?php echo file_get_contents("https://www.tarotdehorus.com.br/assets/dist/css/bootstrap.min.css"); ?></style>
		<style>
			body {
			    overflow-x: hidden;
			    font-family: 'dumbledor_1regular';
			    color: #000;
			    font-size: 20px;
			    background: #000 url('https://www.tarotdehorus.com.br/images/background.webp') 50% 0 fixed no-repeat;
			    background-size: cover !important;
			}
			label, input, button, select, textarea {
			    font-size: 25px !important;
			}
			#header {
			    background: rgba(0, 0, 0, 0.7);
			    color: #f7b334;
			    border-bottom: 3px solid #f7b334;
			}
			#geral {
			    background: rgba(255, 255, 255, 0.8);
			}
			#chat-application {
			    display: none !important;
			}
			#depoimentos {
			    position: fixed;
			    bottom: 0px;
			    padding: 5px;
			    z-index: 999;
			    margin:10px;
			}
			.bordavermelha {
			    color: #ff0000;
			    border: 2px solid #ff0000 !important; /* Borda vermelha de 2px */
			}
			.bordaverde {
				color: #0DC143;
			    border: 2px solid #0DC143 !important; /* Borda verde de 2px */
			}
			.grecaptcha-badge {
			    opacity: 0 !important;
			}
			.title {
			    color: #0e0c0c;
			    text-shadow: 0px 2px 4px #da8345;
			}
			.title2 {
				color: #963f10;
				text-shadow: 0px 2px 4px #da8345;
			}
			@media (max-width: 426px) {
			    body {
			        overflow-x: hidden;
			        font-family: 'dumbledor_1regular';
			        color: #000;
			        font-size: 22px;
			        background: url('images/bgcel.jpg') !important;
			    }
			    #geral {
			        background: rgb(255 255 255 / 63%) !important;
			        padding: 15px;
			    }
			    .container {
			        padding-right: 0px;
			        padding-left: 0px;
			    }
			}
		</style>
		<style>
		    @font-face {
			    font-family: 'dumbledor_1regular';
			    src: url('https://www.tarotdehorus.com.br/fonts/dum1-webfont/dum1-webfont.woff2') format('woff2'),
			         url('https://www.tarotdehorus.com.br/fonts/dum1-webfont/dum1-webfont.woff') format('woff');
			    font-weight: normal;
			    font-style: normal;
			}
		</style>
		<script>
			window.jQuery || document.write('<script src="https://www.tarotdehorus.com.br/assets/dist/js/jquery-3.5.1.min.js"><\/script>')
		</script>
		<script async src="https://www.tarotdehorus.com.br/assets/dist/js/bootstrap.bundle.min.js"></script>
		<script async src="https://kit.fontawesome.com/4587a64295.js" crossorigin="anonymous"></script>
		<script type="text/javascript" src="https://www.tarotdehorus.com.br/scripts/mask/jquery.mask.js"></script>
		<script>
			$(document).ready(function() {
				$('.peso').mask('00.000');
				$('.OnlyNumber').mask('000000000000');
				$('.cardNumber').mask('0000 0000 0000 0000');
				$('.cardExpiryM').mask('00');
				$('.cardExpiryY').mask('00');
				$('.cardCVC').mask('000');
				$('.data-mask').mask('00/00/0000');
				$('.dataNascimento').mask('00-00-0000');
				$('.time').mask('00:00:00');
				$('.date_time').mask('00/00/0000 00:00:00');
				$('.cep').mask('00000-000');
				$('.peso').mask('00.000');
				$('.area').mask('00');
				$('.cell').mask('0.0000-0000');
				$('.phone').mask('0000-00000');
				$('.phone_with_ddd').mask('(00) 0000-0000');
				$('.cel_with_ddd').mask('(00) 00000-0000');
				$('.phone_us').mask('(000) 000-0000');
				$('.mixed').mask('AAA 000-S0S');
				$('.rg').mask('00.000.000-00', {reverse: true});
				$('.cpf').mask('000.000.000-00', {reverse: true});
				$('.cnpj').mask('00.000.000/0000-00', {reverse: true});
				$('.money').mask('000.000.000.000.000,00', {reverse: true});
				$('.money2').mask("#.##0,00", {reverse: true});
				$('.ip_address').mask('0ZZ.0ZZ.0ZZ.0ZZ', {
				translation: {
				  'Z': {
				    pattern: /[0-9]/, optional: true
				  }
				}
				});
				$('.ip_address').mask('099.099.099.099');
				$('.percent').mask('##0,00%', {reverse: true});
				$('.clear-if-not-match').mask("00/00/0000", {clearIfNotMatch: true});
				$('.placeholder').mask("00/00/0000", {placeholder: "__/__/____"});
				$('.fallback').mask("00r00r0000", {
				  translation: {
				    'r': {
				      pattern: /[\/]/,
				      fallback: '/'
				    },
				    placeholder: "__/__/____"
				  }
				});
				$('.selectonfocus').mask("00/00/0000", {selectOnFocus: true});
			});
		</script>

		<script type="text/javascript">
			function Consultar() {
		        $("#nome").focus();
		        $("#nome").addClass('bordavermelha');
		        $("#nomeNaoValido").show();
		    }
		    function CampoPreenchido(field, $this) {
		        var campo = field;
		        var id = $this;
		        if (campo.value.length <= 0){
		          $("#"+id+"").removeClass('bordaverde');
		          $("input[name='nome']").removeClass('azul');
		          $("#"+id+"").addClass('bordavermelha');
		          $("#"+id+"NaoValido").show();
		        } else {
		          $("#"+id+"").removeClass('bordavermelha');
		          $("#"+id+"").addClass('bordaverde');
		          $("#"+id+"NaoValido").hide();
		        }
		    }
		    function testaCelular(valor, $this) {
		        var id = $this;
		        valor = valor.replace(/[ÀÁÂÃÄÅ]/g,"A");
		        valor = valor.replace(/[àáâãäå]/g,"a");
		        valor = valor.replace(/[ÈÉÊË]/g,"E");
		        valor = valor.replace(/[^a-z0-9]/gi,'');
		        if (valor.length == 11) {
		            $("#"+id+"").removeClass('bordavermelha');
		            $("#whatsappNaoValido").hide();
		            $("#msgecel").hide();
		          	$("#"+id+"").addClass('bordaverde');
		        } else {
		        	$("#msgecel").show();
		            $("#"+id+"").focus();
		            $("#"+id+"").removeClass('bordaverde');
		            $("#"+id+"").addClass('bordavermelha');
		            document.getElementById("msgecel").innerHTML="<font color='red'><i class=\"fas fa-exclamation-circle\"></i> O número de celular deve ter 2 digitos para o DD e 9 para o número. </font>";
		        }
		    }
		    function testaDatadeNascimento(valor, $this) {
		        var id = $this;
		        if (valor.length == 10) {
		            $("#"+id+"").removeClass('bordavermelha');
		            $("#whatsappNaoValido").hide();
		          	$("#"+id+"").addClass('bordaverde');
		          	$("#"+id+"NaoValido").hide();
		        } else {
		            $("#"+id+"").focus();
		            $("#"+id+"").removeClass('bordaverde');
		            $("#"+id+"").addClass('bordavermelha');
		            $("#"+id+"NaoValido").show();
		        }
		    }
		    function testaemail(valor, $this) {
		        var emailform = document.forms['Lptarotdehorus'].elements['email'].value;
				stringResultante = emailform.trim();
	            usuario = Lptarotdehorus.email.value.trim().substring(0, Lptarotdehorus.email.value.indexOf("@"));
	            dominio = Lptarotdehorus.email.value.trim().substring(Lptarotdehorus.email.value.indexOf("@") + 1, Lptarotdehorus.email.value.length);
	            if ((usuario.length >=1) &&
	                (dominio.length >=3) && 
	                (usuario.search("@")==-1) && 
	                (dominio.search("@")==-1) &&
	                (usuario.search(" ")==-1) && 
	                (dominio.search(" ")==-1) &&
	                (dominio.search(".")!=-1) &&      
	                (dominio.indexOf(".") >=1)&& 
	                (dominio.lastIndexOf(".") < dominio.length - 1)) {
	                $('#email').removeClass('bordavermelha');
	                $("#email").addClass('bordaverde');
	                $("#emailNaoValido").hide();
	            } else {
	                $("#email").focus();
	                $("#email").removeClass('bordaverde');
	                $("#email").addClass('bordavermelha');
	                $("#emailNaoValido").show();
	            }
		    }
		    $("#confirmarcompraconsulta").click(function(){

		    	$("#carregando").show();
				var errosform = 0;

				// Nome
				var nome = document.forms['Lptarotdehorus'].elements['nome'].value;
				nome = nome.trim();
	            if (nome.length <= 0){
	                $("#nome").focus();
	                $("#nomeNaoValido").show();
	                $("#nome").removeClass('bordaverde');
	                $("#nome").addClass('bordavermelha');
	                errosform++;
	            } else {
	                $("#nome").removeClass('bordavermelha');
	                $("#nome").addClass('bordaverde');
	                $("#nomeNaoValido").hide();
	            }

	            // Email
	            var emailform = document.forms['Lptarotdehorus'].elements['email'].value;
				stringResultante = emailform.trim();
	            usuario = Lptarotdehorus.email.value.trim().substring(0, Lptarotdehorus.email.value.indexOf("@"));
	            dominio = Lptarotdehorus.email.value.trim().substring(Lptarotdehorus.email.value.indexOf("@") + 1, Lptarotdehorus.email.value.length);
	            if ((usuario.length >=1) &&
	                (dominio.length >=3) && 
	                (usuario.search("@")==-1) && 
	                (dominio.search("@")==-1) &&
	                (usuario.search(" ")==-1) && 
	                (dominio.search(" ")==-1) &&
	                (dominio.search(".")!=-1) &&      
	                (dominio.indexOf(".") >=1)&& 
	                (dominio.lastIndexOf(".") < dominio.length - 1)) {
	                $('#email').removeClass('bordavermelha');
	                $("#email").addClass('bordaverde');
	                $("#emailNaoValido").hide();
	            } else {
	                $("#email").focus();
	                $("#email").removeClass('bordaverde');
	                $("#email").addClass('bordavermelha');
	                $("#emailNaoValido").show();
	                errosform++;
	            }

	            // WhatsApp
				var whatsapp = document.forms['Lptarotdehorus'].elements['whatsapp'].value;
				whatsapp = whatsapp.trim();
				whatsapp = whatsapp.replace(/[ÀÁÂÃÄÅ]/g,"A");
		        whatsapp = whatsapp.replace(/[àáâãäå]/g,"a");
		        whatsapp = whatsapp.replace(/[ÈÉÊË]/g,"E");
		        whatsapp = whatsapp.replace(/[^a-z0-9]/gi,'');

	            if (whatsapp.length == 11){
	                $("#whatsapp").removeClass('bordavermelha');
	                $("#whatsapp").addClass('bordaverde');
	                $("#whatsappNaoValido").hide();
	            } else {
	                $("#whatsapp").focus();
	                $("#whatsappNaoValido").show();
	                $("#whatsapp").removeClass('bordaverde');
	                $("#whatsapp").addClass('bordavermelha');
	                errosform++;
	            }

	            // Data de Nascimento
	            var datanascimento = document.forms['Lptarotdehorus'].elements['datanascimento'].value;
				datanascimento = datanascimento.trim();
	            if (datanascimento.length == 10){
	                $("#datanascimento").removeClass('bordavermelha');
	                $("#datanascimento").addClass('bordaverde');
	                $("#datanascimentoNaoValido").hide();
	            } else {
	                $("#datanascimento").focus();
	                $("#datanascimentoNaoValido").show();
	                $("#datanascimento").removeClass('bordaverde');
	                $("#datanascimento").addClass('bordavermelha');
	                errosform++;
	            }

	            // Plano
				$("#planoNaoValido").hide();
				var plano = document.forms['Lptarotdehorus'].elements['plano'].value;
	            if (plano.length == ""){
	                $("#plano").focus();
	                $("#planoNaoValido").show();
	                $("#plano").removeClass('bordaverde');
	                $("#plano").addClass('bordavermelha');
	                errosform++;
	            } else {
	                $("#plano").removeClass('bordavermelha');
	                $("#plano").addClass('bordaverde');
	                $("#planoNaoValido").hide();
	            }

	            // Se não tiver erros, submete
	            if (errosform == 0){
	            	var confirmarcompraconsulta = 'confirmarcompraconsulta';
	            	$("input[name='Cartomantes']").val(confirmarcompraconsulta);
	            	document.getElementById("Lptarotdehorus").submit();
	            } else {
	            	$("#carregando").hide();
	            }
	        });
		</script>
		
		<!-- Preloader -->
		<script type="text/javascript">
		    //<![CDATA[
		    $(window).on('load', function () { // makes sure the whole site is loaded 
		        $('#preloader .inner').fadeOut(); // will first fade out the loading animation 
		        $('#preloader').delay(200).fadeOut('slow'); // will fade out the white DIV that covers the website. 
		        $('body').delay(200).css({'overflow': 'visible'});
		    })
		    //]]>
	    </script>
	</body>
</html>