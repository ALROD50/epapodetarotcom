<?php
date_default_timezone_set("Brazil/East"); // seta configurações fusuhorario para Brasil
ini_set ('default_charset', 'UTF-8'); // seta o php em UTF 8
$pdo=conexao();
// Sistema de URL
$server             = $_SERVER['SERVER_NAME'];
$endereco           = $_SERVER ['REQUEST_URI'];
$endereco_atual     = "https://" . $server . $endereco;
$endereco           = array_filter(explode('/',$endereco));
$URLSESSAO          = @$endereco[1];
$URLCATEGORIA       = @$endereco[2];
$URLSUBCATEGORIA    = @$endereco[3];
$URLSUBSUBCATEGORIA = @$endereco[4];
$URLSUB5CATEGORIA   = @$endereco[5];
$pagina_atual       = null;
$home       ="../index.php";
$DataPicker ="NAO";
$TinyMce    ="NAO";
$Mask       ="NAO";
$ScriptsLoja="NAO";
$Checkout   ="NAO";
$AMPimage   ="SIM";
$display    ="";
$msg        ="";
$conversaodogoogle="";
$mostrarconversaogoogleads=null;
$habilitareditor = 'simples';
$dataHora = date("d/m/Y h:i:s");
$data_hoje = date('Y-m-d H:i:s');
$data_dia = date("d");
$data_mes = date("m");
$data_ano = date("Y");
// Configurações de sistema
$sql_config = $pdo->query ("SELECT * FROM config WHERE id='1' "); 
while ($mostrar_config = $sql_config->fetch(PDO::FETCH_ASSOC)){
    $config_id         =  $mostrar_config['id'];
    $config_paypal     =  $mostrar_config['paypal'];
    $config_pagseguro  =  $mostrar_config['pagseguro'];
    $config_transf_manual     =  $mostrar_config['transf_manual'];
    $config_valor_minutos     =  $mostrar_config['valor_minutos'];
    $config_porcentagem_tarologo =  $mostrar_config['porcentagem_tarologo'];
    $config_bonus_plano  =  $mostrar_config['bonus_plano'];
    $config_preco_consulta_email =  $mostrar_config['preco_consulta_email'];
}
//Verifica se usuario esta online
$row_onlinex="";
$sql_onlinex=$pdo->query("SELECT * FROM clientes WHERE id='$usuario_id' ");
while ($mostrarx=$sql_onlinex->fetch(PDO::FETCH_ASSOC)) { 
  $row_onlinex=$mostrarx['online'];
  $email_usuario=$mostrarx['email'];
  $nome_usuario=$mostrarx['nome'];
}
// Meta Tags Global
$keywords="É Papo de Tarot, Consultas de Tarot Online, Tarot, Buzios, Baralho Cigano, Tarô, Consultas via Chat, Taro, Cartomancia, Taro, Búzios, Runas, Numerologia, Reiki, Umbanda, Candomblé, Trabalhos Espirituais, Consultas Espirituais, Consultas Espirituais a distância, Jogo de Búzios a distância, Jogo de Baralho Cigano Online, Consultas Espirituais Online, Cartomancia, Sensitivos, Videntes, Consultas Esotéricas, Magia, Leitura de Baralho Cigano, Leitura Cartas de Tarot, Leitura Tarô do Amor, Jogar Cartas Online, Ele Me Ama, Ele Me Trai?, Tarot on-line por minuto, Tarot por minuto, tarô cigano, baralho de marselha";
$metadescription="É Papo de Tarot - Consultas de Tarot Online: Tarot, Buzios, Baralho Cigano, Tarô Consultas via Chat, Conselhos Videntes ao Vivo, Consultas Tarô, Faça seu cadastro e compre seus créditos";
$metaimage="https://www.epapodetarot.com.br/images/metapropertyimg/home.webp";
// Página Atual
if ($URLSESSAO=='' OR $URLSESSAO=='home' OR $URLSESSAO=='index.php') {
	$pagina_atual="home";
	@$title="Home - É Papo de Tarot - ".$nome_usuario;
} elseif ($URLSESSAO=='minha-conta') {
	$pagina_atual="minha-conta";
	@$title="Minha Conta: ".$nome_usuario." - É Papo de Tarot";
} elseif ($URLSESSAO=='fazer-login') {
	$pagina_atual="fazer-login";
	$title="Login / Entrar - É Papo de Tarot";
	require_once "/home/epapodetarotcom/public_html/login/LoginEntrar_facebook.php"; 
	require_once "/home/epapodetarotcom/public_html/login/LoginEntrar_google.php";
} elseif ($URLSESSAO=='quem-somos') {
	$pagina_atual="quem-somos";
	$title="Quem Somos - É Papo de Tarot";
} elseif ($URLSESSAO=='perguntas-frequentes') {
	$pagina_atual="perguntas-frequentes";
	$title="Perguntas Frequentes - É Papo de Tarot";
} elseif ($URLSESSAO=='lembrar-senha') {
	$pagina_atual="lembrar-senha";
	$title="Lembrar Senha - É Papo de Tarot";
} elseif ($URLSESSAO=='blog') {
	$pagina_atual="blog";
	$title="Blog - É Papo de Tarot";
	$sql = $pdo->query("SELECT * FROM blog_categoria WHERE alias='$URLCATEGORIA'");
	$row = $sql->rowCount();
	if ($row > 0){
		while ($mostrar = $sql->fetch(PDO::FETCH_ASSOC)) { 
			$idCategoria=$mostrar['id'];
			$tituloCategoria=$mostrar['titulo'];
		}
		$title=$tituloCategoria.' - Blog - É Papo de Tarot';
		$CategoriaBlogAtiva='SIM';
	} else {
		$CategoriaBlogAtiva='NAO';
	}
} elseif ($URLSESSAO=='blog-artigo') {
	$pagina_atual="blog-artigo";
	$sql = $pdo->query("SELECT * FROM blog_itens WHERE alias='$URLSUBCATEGORIA' AND status='Ativo'");
	$row = $sql->rowCount();
	if ($row > 0){
		while ($mostrar = $sql->fetch(PDO::FETCH_ASSOC)) { 
			$artigo_id=$mostrar['id'];
			$titulo=$mostrar['titulo'];
			$foto_abertura=$mostrar['foto_abertura'];
			$meta_descricao=$mostrar['meta_descricao'];
			$meta_keywords=$mostrar['meta_keywords'];
			$categoria=$mostrar['categoria'];
		}
		$executa66 = $pdo->query("SELECT * FROM blog_categoria WHERE id='$categoria'");
	    while ($dadoss66 = $executa66->fetch(PDO::FETCH_ASSOC)){ 
	        $categoria_nome=$dadoss66['titulo'];
	    }
		$title=$titulo.' - '.$categoria_nome;
		$keywords=$meta_keywords;
		$metadescription=$meta_descricao;
		$metaimage="https://www.epapodetarot.com.br/images/blog/foto_abertura/$foto_abertura";
	} else {
		$pagina_atual="blog-artigo";
		$title="Página Não Encontrada - É Papo de Tarot";
	}
} elseif ($URLSESSAO=='faleconosco') {
	$pagina_atual="faleconosco";
	$title="Contato - É Papo de Tarot";
} elseif ($URLSESSAO=='trabalhe-conosco') {
	$pagina_atual="trabalhe-conosco";
	$title="Trabalhe Conosco - É Papo de Tarot";
} elseif ($URLSESSAO=='politica-de-privacidade-e-termos-de-uso') {
	$pagina_atual="politica-de-privacidade-e-termos-de-uso";
	$title="Termos de Uso e Política de Privacidade";
} elseif ($URLSESSAO=='tarologos') {
	$pagina_atual="tarologos";
	$title="Tarologos - Consultores Profissionais";
} elseif ($URLSESSAO=='tarologo') {
	$pagina_atual="tarologo";
	$sql = $pdo->query("SELECT * FROM clientes WHERE nivel='TAROLOGO' AND alias ='$URLCATEGORIA' ");
	$row = $sql->rowCount();
	if ($row > 0){
		while ($mostrar = $sql->fetch(PDO::FETCH_ASSOC)) { 
			$id_tarologo=$mostrar['id'];
			$nome=$mostrar['nome'];
			$especialidades=$mostrar['especialidade_taro'];
			$descricao=$mostrar['infos2'];
			$logo=$mostrar['logo'];
		}
		$title='Taróloga(o) - '.$nome;
		$keywords=$especialidades.', chat online, tarologos, tarot online, tarotcards, tarotonline, baralhocigano, tarot egipicio, horóscopo, astrologia, fengshui, runas, deusas do egito, tratamento holístico';
		$metadescription=$nome.', '.$descricao;
		$metaimage="https://www.epapodetarot.com.br/tarologos_admin/fotos/$logo";
	} else {
		$pagina_atual="naoencontrado";
		$title="Página Não Encontrada - É Papo de Tarot";
	}
} elseif ($URLSESSAO=='consultar') {
	$pagina_atual="consultar";
	$title="Chamando Tarologo - Consultores Profissionais";
} elseif ($URLSESSAO=='aviseme-quando-disponivel') {
	$pagina_atual="aviseme-quando-disponivel";
	$title="Avise-me Quando Estiver Disponível - Consultores Profissionais";
} elseif ($URLSESSAO=='consultarporemail') {
	$pagina_atual="consultarporemail";
	$title="Consulta Por E-mail - Consultores Profissionais";
} elseif ($URLSESSAO=='comprar-consulta') {
	$pagina_atual="comprar-consulta";
	@$title="Comprar Consulta ".$nome_usuario." - Chat, WhatsApp, E-mail, Video, Telefone - É Papo de Tarot";
	$metaimage="https://www.epapodetarot.com.br/images/metapropertyimg/tarotdehorus.webp";
	require_once "/home/epapodetarotcom/public_html/login/LoginEntrar_facebook.php"; 
	require_once "/home/epapodetarotcom/public_html/login/LoginEntrar_google.php";
} elseif ($URLSESSAO=='depoimentos-tarlogos') {
	$pagina_atual="depoimentos-tarlogos";
	$title="Depoimentos Tarólogos - É Papo de Tarot";
} elseif ($URLSESSAO=='registre-se') {
	$pagina_atual="registre-se";
	$title="Cadastre-se - É rápido e fácil - É Papo de Tarot";
	require_once "/home/epapodetarotcom/public_html/login/LoginEntrar_facebook.php"; 
	require_once "/home/epapodetarotcom/public_html/login/LoginEntrar_google.php";
} elseif ($URLSESSAO=='loja') {
	$pagina_atual="loja";
	$title="Loja Virtual - É Papo de Tarot - Produtos Esotéricos";
	$metaimage="https://www.epapodetarot.com.br/images/metapropertyimg/tarotdehorus.webp";
	
	$sql = $pdo->query("SELECT * FROM loja_categorias WHERE alias='$URLCATEGORIA'");
	$row = $sql->rowCount();
	if ($row > 0){
		while ($mostrar = $sql->fetch(PDO::FETCH_ASSOC)) { 
			$idCategoria=$mostrar['id'];
			$tituloCategoria=$mostrar['titulo'];
		}
		$title=$tituloCategoria.' - Loja Virtual - É Papo de Tarot - Produtos Esotéricos';
		$CategoriaLojaAtiva='SIM';
	} else {
		$CategoriaLojaAtiva='NAO';
	}
    $ScriptsLoja="SIM";
} elseif ($URLSESSAO=='loja-item') {
	$pagina_atual="loja-item";
	$sql = $pdo->query("SELECT * FROM loja_produtos WHERE alias='$URLSUBCATEGORIA' AND status='Ativo' AND estoque>0");
	$row = $sql->rowCount();
	if ($row > 0){
		while ($mostrar = $sql->fetch(PDO::FETCH_ASSOC)) { 
			$titulo=$mostrar['titulo'];
			$foto_abertura=$mostrar['foto_abertura'];
			$meta_descricao=$mostrar['meta_descricao'];
			$meta_keywords=$mostrar['meta_keywords'];
			$categoria=$mostrar['categoria'];
		}
		$executa66 = $pdo->query("SELECT * FROM loja_categorias WHERE id='$categoria'");
	    while ($dadoss66 = $executa66->fetch(PDO::FETCH_ASSOC)){ 
	        $categoria_nome=$dadoss66['titulo'];
	    }
		$title=$titulo.' - '.$categoria_nome;
		$keywords=$meta_keywords;
		$metadescription=$meta_descricao;
		$metaimage="https://www.epapodetarot.com.br/loja_admin/foto_abertura/$foto_abertura";
		$Mask="SIM";
		$ScriptsLoja="SIM";
	} else {
		$pagina_atual="loja";
		$title="Página Não Encontrada - É Papo de Tarot";
	}
} elseif ($URLSESSAO=='pagamentos') {
	$pagina_atual="pagamentos";
	@$title="Pagamento ".$nome_usuario." - É Papo de Tarot";
	$conversaodogoogle="
		<!-- Event snippet for Adicionar ao carrinho conversion page -->
		<script>
		  gtag('event', 'conversion', {'send_to': 'AW-623703979/fGTaCK6Syd4BEKvvs6kC'});
		</script>
	";
	$mostrarconversaogoogleads="sim";
} elseif ($URLSESSAO=='carrinho-compras') {
	$pagina_atual="carrinho-compras";
	$title="Carrinho de Compras - É Papo de Tarot";
	require_once "/home/epapodetarotcom/public_html/login/LoginEntrar_facebook.php"; 
} else {
	$pagina_atual="naoencontrado";
	$title="404 - Página Não Encontrada - É Papo de Tarot";
}
?>