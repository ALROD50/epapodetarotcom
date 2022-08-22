<h3 class="text-success">Criar Nova Categoria da Loja</h3>
<hr>
<?php 
$TinyMce="SIM";
$habilitareditor='completo';
if(isset($_POST['envia'])) {

	$nome = $_POST['nome'];
	$alias = transformaAlias($nome);
	$descricao = $_POST['descricao'];

	$pdo->query("INSERT INTO loja_categorias (
		titulo,
		alias,
		descricao
	) VALUES (
		'$nome',
		'$alias',
		'$descricao'
	)");

    $msgs="Categoria Criada Com Sucesso!";
    echo "<script>document.location.href='minha-conta/?pg=loja_admin/categorias.php&msgs=$msgs'</script>";
}

?>
<span class="small">(*) Preenchimento obrigatório.</span>
<p>

<form name="categorias" method="post" action="" class="form-inline" enctype="multipart/form-data">

	<div style="margin:10px; display:inline-block;">
	    Nome:&nbsp;&nbsp;
	    <input type="text" name="nome" value="" required class="form-control"/>
	</div>

	<br>

	<div style="margin:10px; display:inline-block;">
	    Descrição:&nbsp;&nbsp;
	    <textarea class="form-control" name="descricao"></textarea>
	</div>

	<br>

	<input class="btn btn-primary" type="submit" name="envia" value="Criar"/>

</form>
