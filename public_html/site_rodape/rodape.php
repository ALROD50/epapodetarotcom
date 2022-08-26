<?php
date_default_timezone_set("Brazil/East");// seta configurações fusuhorario para Brasil
ini_set ('default_charset', 'UTF-8');// seta o php em UTF 8
ini_set('display_errors',1); // Força o PHP a mostrar os erros.
ini_set('display_startup_erros',1); // Força o PHP a mostrar os erros.
error_reporting(E_ALL); // Força o PHP a mostrar os erros.
?>
<footer>

	<div style="clear:both;"></div>

	<div class="row" style="font-size:17px;">
		<div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-xs-3">
			<h2 class="branco sombratexto">Quem Somos</h2>
			<center><img src="images/Logo-Site.fw.png" alt="Site Templo Qsara" title="Templo Qsara" class="img-fluid" style="max-height: 80px;" /></center>
			<p>Quem é a idealizadora do TEMPLO QSARA? Prazer, meu nome é Aline A. Peres, tenho 45 anos, sou publicitária e terapeuta, sou mãe de um casal de gatos lindos e fofos...</p><a href="quem-somos" class="link-padraodois">Leia mais aqui.</a></p>
		</div>
		<div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-xs-3">
			<h2 class="branco sombratexto">Institucional</h2>
			<p><a href="quem-somos" class=""> Quem Somos</a></p>
			<p><a href="lembrar-senha" class=""> Lembrar-Senha</a></p>
			<p><a href="politica-de-privacidade-e-termos-de-uso" class=""> Termos de Uso</a></p>
			<p><a href="https://forms.gle/nk7uQY3DSQ8o8PGc7" class=""> Trabalhe Conosco</a></p>
			<p><a href="perguntas-frequentes" class=""> FAQ</a></p>
			<p><a href="blog" class=""> Blog</a></p>
		</div>
		<div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-xs-3">
			<h2 class="branco sombratexto">Atendimento</h2>
			<p><i class="far fa-clock branco"></i> Segunda a sábado: 9 às 22h, Domingos e feriados: 10 às 18h</p>
			<p><i class="fab fa-whatsapp branco"></i> (11) 99424-5002</p>
			<p><i class="far fa-envelope branco"></i> temploqsara@gmail.com</p>
		</div>
		<div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-xs-3">
			<h2 class="branco sombratexto">Redes Sociais</h2>
			<p><a href="https://www.facebook.com/temploqsara/" target="_blank" title="Facebook Templo Qsara"><i class="fab fa-facebook-square fa-4x azul efeitodois"></i></a>
			<a href="https://www.instagram.com/temploqsara/" target="_blank" title="Instagram Templo Qsara"><i class="fab fa-instagram-square fa-4x instagram efeitodois"></i></a>
			<!-- <a href="https://www.youtube.com/channel/UCAoHI95gpjGH3UiewFaiU-A?view_as=subscriber" target="_blank" title="Youtube Templo Qsara"><i class="fab fa-youtube-square fa-4x vermelho efeitodois"></i></a> -->
			<a href="https://api.whatsapp.com/send?phone=5511994245002&amp;text=Olá Templo Qsara, pode me ajudar?" target="_blank"><img src="/images/whtzp.png" alt="" class="rounded" style="width:60px; top: -21px; position: relative;"></a></p>
		</div>
	</div>
	
	<hr>
	
	<div class="row justify-content-center" style="margin-bottom:15px;">
		<center>
			<p><i class="fab fa-expeditedssl"></i> O site É Papo de Tarot usa técnologias de última geração na segurança e proteção de dados, com certificado SSL.</p>
			<p>
				<a href="https://www.sslshopper.com/ssl-checker.html#hostname=www.epapodetarot.com.br" target="_blank"><img src="images/seguranca.png" width="138" height="35" alt="Site Seguro" title="Site Seguro"></img></a> <a href="https://sitecheck.sucuri.net/results/www.epapodetarot.com.br" target="_blank"><img src="images/selo-sitechecksucuri.png" width="106" height="35" alt="Site Seguro" title="Site Seguro"></img></a>
			</p>
		</center>
	</div>
	
	<hr>
	
	<!-- Pagamentos -->
	<div class="row justify-content-center" style="margin-bottom:30px;">
		<?php 
		/* Diretorio que deve ser lido */
		$path = "images/pagamento";
		/* Abre o diretório */
		@$pasta= opendir($path);
		/* Loop para ler os arquivos do diretorio */
		while (@$arquivo = readdir($pasta)) {
			/* Verificacao para exibir apenas os arquivos e nao os caminhos para diretorios superiores */
			@$ext = strtolower(end(explode(".", $arquivo)));
			if ($arquivo != '.' && $arquivo != '..' && $ext != 'zip' && $ext != 'php' && $ext != 'html' && $arquivo != 'error_log') {
				//$arquivox = limita_caracteres($arquivo, 10, true);
				// Se for imagem
				if ($ext == 'jpg' OR $ext == 'jpeg' OR $ext == 'png' OR $ext == 'gif' OR $ext == 'bmp' OR $ext == 'webp') {
					?>
					<center>
						<p>
							<a href='https://www.epapodetarot.com.br/comprar-consulta' title='Esotéricos Tarot Online Chat Baralho Cigano Tarólogos'><img src='<?php echo $path."/".$arquivo; ?>' class="img-fluid" alt="Esotéricos Tarot Online Chat Baralho Cigano Tarólogos"/></a>
						</p>
					</center>
					<?php
				}
			}
		}
		?>
    </div>

</footer>