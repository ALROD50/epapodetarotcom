<h3 class="text-success">Criar Nova Categoria da Loja</h3>
<hr>

<?php
$TinyMce="SIM";
$habilitareditor='completo';
if(isset($_POST['criacategoriablog'])) {

	$nome = $_POST['nome'];
	$alias = transformaAlias($nome);
	$descricao = $_POST['descricao'];

	$pdo->query("INSERT INTO blog_categoria (
		titulo,
		alias,
		descricao
	) VALUES (
		'$nome',
		'$alias',
		'$descricao'
	)");

    $msgs="Categoria Criada Com Sucesso!";
    echo "<script>document.location.href='minha-conta/?pg=site_blog/categorias.php&msgs=$msgs'</script>";
}
?>
<span class="small">(*) Preenchimento obrigatório.</span>

<form name="categorias" method="post" action="" class="form-inline" enctype="multipart/form-data">

	<div class="row col-md-12">
	    Nome:&nbsp;&nbsp;
	    <input type="text" name="nome" value="" required class="form-control"/>
	</div>

	<div class="row col-md-12 mb-3">
	    Descrição:&nbsp;&nbsp;
	    <textarea class="form-control" name="descricao"></textarea>
	</div>

	<input class="btn btn-primary" type="submit" name="criacategoriablog" value="Criar"/>

</form>
