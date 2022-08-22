<h3 class="text-success">Editar Categoria do Blog</h3>
<hr>
<?php
$TinyMce="SIM";
$habilitareditor='completo';
$id = @$_GET['id'];
$executa66 = $pdo->query("SELECT * FROM blog_categoria WHERE id='$id'");
while ($dadoss66 = $executa66->fetch(PDO::FETCH_ASSOC)) { 
	$titulo    = $dadoss66['titulo'];
	$alias     = $dadoss66['alias'];
	$descricao = $dadoss66['descricao'];
}

if ( isset($_POST["categoriaseditar"]) ) {

	$nome = $_POST['nome'];
	$alias = transformaAlias($nome);
	$descricao = $_POST['descricao'];

    $query = $pdo->query("UPDATE blog_categoria SET 
	    titulo='$nome',
	    alias='$alias',
	    descricao='$descricao'
    WHERE id='$id'");
    
    $msgs = "Dados Atualizados com sucesso";
    echo "<script>document.location.href='minha-conta/?pg=site_blog/categorias.php&msgs=$msgs'</script>";
    exit(); 
}
?>

<form name="categorias" method="post" action="" class="form-inline" enctype="multipart/form-data">

	<div class="row col-md-12 mb-3">
	    Nome:&nbsp;&nbsp;
	    <input type="text" name="nome" value="<?php echo $titulo; ?>" required class="form-control"/>
	</div>

	<div class="row col-md-12 mb-3">
	    Descrição:&nbsp;&nbsp;
	    <textarea class="form-control" name="descricao"><?php echo $descricao; ?></textarea>
	</div>

	<input class="btn btn-primary" type="submit" name="categoriaseditar" value="Atualizar"/>

</form>