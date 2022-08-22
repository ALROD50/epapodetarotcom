<?php
date_default_timezone_set("Brazil/East"); // seta configurações fusuhorario para Brasil
ini_set ('default_charset', 'UTF-8'); // seta o php em UTF 8
$page = (isset($_GET['pg'])) ? $page = $_GET['pg'] : $page = "index.php";
switch ($page) {
	case "index.php": $title = "Gostaria de falar com um cartomante?"; break;
	case "page2.php": $title = "Escolha um cartomante"; break;
	case "page3.php": $title = "Qual o seu nome?"; break;
	case "page4.php": $title = "Qual o seu e-mail?"; break;
	case "page5.php": $title = "Informe seu WhatsApp"; break;
	default: $title = "É Papo de Tarot"; break;
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
		<title><?php echo $title; ?></title>
		<meta name="keywords" content="É Papo de Tarot, Consultas de Tarot Online, Tarot, Buzios, Baralho Cigano, Tarô, Consultas via Chat, Taro, Cartomancia, Taro, Búzios, Runas, Numerologia, Reiki, Umbanda, Candomblé, Trabalhos Espirituais, Consultas Espirituais, Consultas Espirituais a distância, Jogo de Búzios a distância, Jogo de Baralho Cigano Online, Consultas Espirituais Online, Cartomancia, Sensitivos, Videntes, Consultas Esotéricas, Magia, Leitura de Baralho Cigano, Leitura Cartas de Tarot, Leitura Tarô do Amor, Jogar Cartas Online, Ele Me Ama, Ele Me Trai?" />
		<meta name="description" content="É Papo de Tarot - Consultas de Tarot Online: Tarot, Buzios, Baralho Cigano, Tarô Consultas via Chat, Conselhos Videntes ao Vivo, Consultas Tarô, Faça seu cadastro e compre seus créditos" />
		<meta name="author" content="Agência Nova Systems Marketing Digital"/>
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
		<link rel="shortcut icon" href="https://www.epapodetarot.com.br/images/favicon.ico" />
		<link rel="stylesheet" href="https://www.epapodetarot.com.br/fonts/dum1-webfont/stylesheet.css" type="text/css" charset="utf-8" media="all"/>
		<link rel="stylesheet" type="text/css" href="css/stilos.css" media="all"/>
		<!--[if lt IE 9]>
	      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	    <![endif]-->
	</head>
	<body role="document">