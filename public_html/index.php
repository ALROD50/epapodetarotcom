<?php
header('Content-Type: text/html; charset=utf-8');
date_default_timezone_set("Brazil/East");
ini_set ('default_charset', 'UTF-8');
ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);
session_start();
if (substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip'))
ob_start("ob_gzhandler"); else ob_start();
include "includes/conexaoPdo.php";
include "includes/sessions_cookies.php";
include "includes/globais.php";
include "includes/head.php";
include "includes/functions.php";
include "scripts/PHPMailer-master5.2.22/class.phpmailer.php";
include "scripts/PHPMailer-master5.2.22/class.smtp.php";
?> 
<div class="container">
	<header>
		<?php
		include "includes/topo.php";
		include "includes/menu_site.php";
		?>
	</header>
	<main id="mainsite" role="main">
		<?php
		include "includes/msg.php";
		if ($pagina_atual=="home") {
		    include "site_tarologos/tarologos_home.php";
		} elseif ($pagina_atual=="minha-conta") {
			include "includes/index.php";
		} elseif ($pagina_atual=="fazer-login") {
			include "login/login_site.php";
		} elseif ($pagina_atual=="quem-somos") {
			include "site_pages/quem-somos.php";
		} elseif ($pagina_atual=="perguntas-frequentes") {
			include "site_pages/perguntas-frequentes.php";
		} elseif ($pagina_atual=="lembrar-senha") {
			include "login/lembrar_senha.php";
		} elseif ($pagina_atual=="blog") {
			include "site_blog/site_blog.php";
		} elseif ($pagina_atual=="blog-artigo") {
			include "site_blog/itens_site.php";
		} elseif ($pagina_atual=="faleconosco") {
			include "contato/contato.php";
		} elseif ($pagina_atual=="trabalhe-conosco") {
			include "contato/trabalhe_conosco.php";
		} elseif ($pagina_atual=="politica-de-privacidade-e-termos-de-uso") {
			include "site_pages/termos.php";
		} elseif ($pagina_atual=="tarologos") {
			include "site_tarologos/tarologos.php";
		} elseif ($pagina_atual=="tarologo") {
			include "site_tarologos/tarologo_perfil.php";
		} elseif ($pagina_atual=="consultar") {
			include "site_tarologos/consultar.php";
		} elseif ($pagina_atual=="aviseme-quando-disponivel") {
			include "aviseme/aviseme_site.php";
		} elseif ($pagina_atual=="consultarporemail") {
			include "mensagens/consultar_email_site.php";
		} elseif ($pagina_atual=="comprar-consulta") {
			include "comprar/comprar.php";
		} elseif ($pagina_atual=="depoimentos-tarlogos") {
			include "site_tarologos/depoimentos_site.php";
		} elseif ($pagina_atual=="registre-se") {
			include "site_pages/cadastrar.php";
		} elseif ($pagina_atual=="loja") {
			include "loja_site/anuncios.php";
		} elseif ($pagina_atual=="loja-item") {
			include "loja_site/anuncios_item.php";
		} elseif ($pagina_atual=="carrinho-compras") {
			include "loja_carrinho/carrinho.php";
		} elseif ($pagina_atual=="pagamentos") {
			include "checkout/pagar.php";
		} else {
			echo "<script>document.location.href='https://www.epapodetarot.com.br/404.php'</script>";
		}
		include "site_rodape/rodape.php";
		include "includes/modal.php";
		include "includes/rodape.php";
		?>
	</main>

	<div id="copy">
		<p>Copyright © <?php echo $data_ano; ?> Tarot de Horus - Todos os Direitos Reservados - Desenvolvimento: <a href="https://www.novasystems.com.br/" target="_blank" class="link-padraoum">Agência Nova Systems - Marketing Digital.</a></p>
	</div>
</div>
<?php 
if ($usuario_nivel == 'TAROLOGO') {
	?>
	<video height="1" width="1" autoplay="" loop="" muted="" controls="">
		<source src="https://www.epapodetarot.com.br/blackvideo.mp4">
	</video>
	<?php
}
?>
