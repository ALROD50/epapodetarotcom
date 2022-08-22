<!-- Filtro, Lista de Anúncios Resultados -->
<div class="row mt-3">
	<div class="col-xl-2 col-lg-2 col-md-12 col-sm-12 col-xs-12 px-0">
		<?php include "site_blog/site_categorias.php"; ?>
	</div>

	<div class="col-xl-10 col-lg-10 col-md-12 col-sm-12 col-xs-12 pr-0">

		<?php 
		$executa66 = $pdo->query("SELECT * FROM blog_itens WHERE id='$artigo_id'");
			while ($aux = $executa66->fetch(PDO::FETCH_ASSOC)) { 
		$foto_abertura=$aux['foto_abertura'];
		$id=$aux['id'];
		$titulo=$aux['titulo'];
		$texto=$aux['texto'];
		$data=$aux['data'];
		$data = MostraDataCorretamente($data);
		$visualizacoes=$aux['visualizacoes'];
		$categoria=$aux['categoria'];
		$status=$aux['status'];
		$alias=$aux['alias'];
		$meta_descricao=$aux['meta_descricao'];
		$meta_keywords=$aux['meta_keywords'];
		$executa66 = $pdo->query("SELECT * FROM blog_categoria WHERE id='$categoria'");
		while ($dadoss66 = $executa66->fetch(PDO::FETCH_ASSOC)){ 
			$categoria_id=$dadoss66['id'];
			$categoria_nome=$dadoss66['titulo'];
			$categoria_alias=$dadoss66['alias'];
		}
		}

		// Registra Visita
		$visualizacoes = $visualizacoes + 1;
		$query = $pdo->query("UPDATE blog_itens SET 
			visualizacoes='$visualizacoes'
		WHERE id='$artigo_id'");
		?>

		<h1><i class="far fa-newspaper"></i> Blog</h1>

		<!-- Go to www.addthis.com/dashboard to customize your tools -->
		<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-59681b17bd25eb95"></script>

		<h2 class="azul"><?php echo $titulo; ?></h2>
		<div class="addthis_inline_share_toolbox"></div>

		<p><small class="text-muted"><?php echo $categoria_nome; ?></small></p>

		<div class="col-xl-5 col-lg-5 col-md-5 col-sm-12 col-xs-12 px-0 py-0">
			<img src="<?php echo 'https://www.epapodetarot.com.br/images/blog/foto_abertura/'.$foto_abertura; ?>" class="rounded img-fluid" alt="<?php echo $titulo; ?>" title="Blog - É Papo de Tarot <?php echo $titulo; ?>">
		</div>

		<?php echo $texto; ?>

		<div class="row col-md-12 mb-3 mt-3 pl-0">
			<?php include "site_blog/comentarios.php"; ?>
		</div>
	</div>
</div>

<hr style="border-top: 1px solid #590905;">

<div class="row col-md-12">
	<?php include "site_blog/itens_rodape.php"; ?>
</div>