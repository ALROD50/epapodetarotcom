<?php
// Seleciona os Resultados
$result = $pdo->query("SELECT * FROM loja_produtos WHERE alias='$URLSUBCATEGORIA' AND status='Ativo' AND estoque>0");
$row = $result->rowCount();

if ($row > 0) {

	while ($dadoss66 = $result->fetch(PDO::FETCH_ASSOC)){ 
		$id_anuncio=$dadoss66['id'];
		$titulo=$dadoss66['titulo'];
		$alias=$dadoss66['alias'];
		$descricao=$dadoss66['descricao'];
		$foto_abertura=$dadoss66['foto_abertura'];
		$fotos=$dadoss66['fotos'];
		$altura=$dadoss66['altura'];
		$largura=$dadoss66['largura'];
		$comprimento=$dadoss66['comprimento'];
		$peso=$dadoss66['peso'];
		$precobd=$dadoss66['preco'];
		$preco = MostraValorDinheiroCorretamente($precobd);
		$categoria=$dadoss66['categoria'];
		$estoque=$dadoss66['estoque'];
		$status=$dadoss66['status'];
		$meta_descricao=$dadoss66['meta_descricao'];
		$meta_keywords=$dadoss66['meta_keywords'];
		$visualizacoes=$dadoss66['visualizacoes'];
	}

	$executa66 = $pdo->query("SELECT * FROM loja_categorias WHERE id='$categoria'");
    while ($dadoss66 = $executa66->fetch(PDO::FETCH_ASSOC)){ 
        $categoria_nome=$dadoss66['titulo'];
        $categoria_alias=$dadoss66['alias'];
    }

	// Registra Visita
	@$visualizacoes = $visualizacoes + 1;
	$query = $pdo->query("UPDATE loja_produtos SET 
		visualizacoes='$visualizacoes'
	WHERE id='$id_anuncio'");
	?>

	<!-- Lightbox2 -->
		<link rel="stylesheet" href="scripts/lightbox2-master/css/lightbox.min.css" type="text/css" media="screen" />
	<!-- Lightbox2 -->

   <!-- Go to www.addthis.com/dashboard to customize your tools -->
   <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-59681b17bd25eb95"></script>

    <!-- Breadcumbs -->
    <div class="row" style="margin-top:15px;">
    	<div class="col-md-12">
        	<div style="padding:10px; background:#fff; margin-left: 0px; margin-right: 0px;">
            	<?php echo "<a href='home'>Página Inicial</a> / <a href='loja'>Loja Virtual</a> / <a href='loja/$categoria_alias'>$categoria_nome</a> / $titulo"; ?>
        	</div>
    	</div>
    </div>

	<!-- Redes Sociais -->
	<div class="row" style="margin-top:10px;">
		<div class="col-md-12">
		    <!-- Compartilhar-->
		    <div class="addthis_inline_share_toolbox" style="float: right;"></div>
		</div>
	</div>

	<div class="row" style="margin-top:10px;">
		<div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-xs-12">
			<!-- Foto de Abertura -->
			<?php echo "<img class='img-thumbnail' src='../loja_admin/foto_abertura/$foto_abertura' />"; ?>
			<!-- Fotos -->
			<div style="display:block;">
			  <?php
			  if (!empty($fotos)) {
			    /* Diretorio que deve ser lido */
			    $path = "/home/epapodetarotcom/public_html/loja_admin/fotos/".$fotos;
			    $diretorio = dir($path);
			    /* Abre o diretório */
			    $pasta = opendir($path);
			    /* Loop para ler os arquivos do diretorio */
			    while ($arquivo = readdir($pasta)) {
			      /* Verificacao para exibir apenas os arquivos e nao os caminhos para diretorios superiores */
			      //$ext = strtolower(end(explode(".", $arquivo)));
			      $ext = explode(".", $arquivo);
			      $ext = end($ext);
			      $ext = strtolower($ext);
			      if ($arquivo != '.' && $arquivo != '..' && $ext != 'php') {
			        ?>
			        <div style='margin:10px 10px 10px 0px; float:left;'>
			          <a href='<?php echo "../loja_admin/fotos/$fotos/$arquivo"; ?>' title='<?php echo $titulo; ?>' rel="lightbox[plants]">
			            <img src='<?php echo "../loja_admin/fotos/".$fotos."/thumb.php?img=".$arquivo; ?>' width='70' height='70' alt="<?php echo $titulo; ?>" class='img-thumbnail' id="efeitofoto" />
			          </a>
			        </div>
			        <?php
			      }
			    }
			    $diretorio->close();
			  }
			?>
			</div>
			<div style="clear:both;"></div>
		</div>
		<div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-xs-12" style="border:solid 1px #ccc; padding: 0 15px 15px 15px; box-shadow: 5px 5px 10px #ccc;">
			<h1 style="color:#333;"><?php echo $titulo; ?></h1>
	    	<h3><?php echo $preco; ?></h3>
	    	<p><?php echo $estoque; ?> Disponíveis</p>
			<form id="addCarrinho" name="addCarrinho" method="post" action="carrinho-compras" class="form-horizontal" style="padding: 5px 5px 0px 5px;">
				<input type="hidden" name="id_anuncio" value="<?php echo $id_anuncio; ?>" />
				<input type="hidden" name="preco" value="<?php echo $precobd; ?>" />
				<input type="hidden" name="altura" value="<?php echo $altura; ?>" />
				<input type="hidden" name="largura" value="<?php echo $largura; ?>" />
				<input type="hidden" name="comprimento" value="<?php echo $comprimento; ?>" />
				<input type="hidden" name="peso" value="<?php echo $peso; ?>" />

				<div class="form-group">
		            <label for="">Quantidade:</label>
		            <select name="quantidadeselecionada" id="quantidadeselecionada" class="form-control" required> 
		                <option value="1" selected>1 Unidade(s)</option>
		                <?php 
		                for ($i=0; $i < $estoque; $i++) { 
		                	?>
		                	<option value="<?php echo $i; ?>"><?php echo $i; ?> Unidade(s)</option>
		                	<?php
		                }
		                ?>
		            </select>
		        </div>

				<div class="form-group">
					<button name="enviarAddCarrinho" id="enviarAddCarrinho" class="btn btn-lg btn-block btn-success"><i class="fas fa-shopping-cart center"></i> COMPRAR</button>
				</div>
			</form>

			<hr style="border-top: 1px solid #ccc;">
			
			<h3 style="color: #333;"><img src="../images/correios-logo-2.png" alt="" style="max-width:50px;"> Calcular Frete</h3>

			<?php 
			// Verifica frete grátis
			if ($altura == "0" AND $largura == "0" AND $comprimento == "0" AND $peso == "0") {

				echo "<p><span style='color:#000;font-size: 19px;'>Produto Digital</span></br>";
				echo "<span style='color:#000;font-size: 19px;'>Entrega via E-mail </span></br>";
				echo "<span style='color:#000;font-size: 19px;'>R$ 00,00 - Frete Grátis</span></p>";

			} else {

				?>
				<!-- Calcula Frete Normal -->
				<div class="row">
					<div class="form-group">
						<label for="exampleInputEmail1">Digite Seu CEP</label>
						<input type="text" class="form-control cep" id="cep" placeholder="00000-000">
						<small class="form-text text-muted"><a href="http://www.consultaenderecos.com.br/busca-endereco" target="_blank">Não sei meu CEP</a></small>
					</div>
				</div>
				
				<div class="row">
					<button onclick="calculo();" class="btn btn-md btn-info"><i class="fas fa-shipping-fast"></i> Calcular Frete</button>
				</div>
				
				<div class="row">
					<div class="col-md-12" id="retorno2" style="display: none">
						<div class='spinner-border' role='status'><span class='sr-only'>Loading...</span></div>
					</div>
					<div id="retorno"></div>
				</div>

			    <!-- JavaScript FRETE -->
			    <script type="text/javascript">
				    function calculo(){
				    	var quantidadeselecionada = $("#quantidadeselecionada").val();

				    	altura      = '<?php echo $altura; ?>';
		                largura     = '<?php echo $largura; ?>';
		                comprimento = '<?php echo $comprimento; ?>';

				    	var altura = altura * quantidadeselecionada;
				    	var largura = largura * quantidadeselecionada;
				    	var comprimento = comprimento * quantidadeselecionada;

				    	$("#retorno2").show();
				    	var cep = $("#cep").val();
					    $.post('https://www.epapodetarot.com.br/loja_site/calcularfrete.php',
		                {
		                  cep : cep,
		                  altura: altura,
		                  largura: largura,
		                  comprimento: comprimento,
		                  peso: '<?php echo $peso; ?>',
		                  valor: '<?php echo $precobd; ?>'
		                }, 
		                function(retorno){
		                  $("#retorno").html(retorno);
		                  $("#retorno2").hide();
		                });
		            }
			    </script>
				<?php
			}
			?>

		</div>
	</div>

	<!-- Descrição -->
	<div class="row" style="margin-top:10px;">
		<div class="card card-body" style="background:#fff; color:#383C3F;">
			<h1 style="margin-top:0px;">Descrição</h1>
			<p><b>Categoria: </b> <?php echo $categoria_nome; ?></p>
			<?php echo $descricao; ?>
		</div>
	</div>

   <?php
} else {
	?>
	<div class="row" style="margin-top:20px;">
		<div class="col-md-12">
			<div class="card card-body" style="background:#fff; color:#383C3F;">
				</br>
					<center><p>Ops...</p></center>
					<center><b>Parece que este anúncio não esta mais disponível...</b></center>
				</br>
			</div>
		</div>
	</div>
	<?php
}
?>

<!-- Lightbox2 -->
<script src="scripts/lightbox2-master/js/lightbox-plus-jquery.min.js"></script>
<!-- Lightbox2 -->