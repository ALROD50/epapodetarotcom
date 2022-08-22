<h3 class="text-success">Editar Categoria da Loja</h3>
<hr>
<?php
$TinyMce="SIM";
$habilitareditor='completo';
$id = @$_GET['id'];
$executa66 = $pdo->query("SELECT * FROM loja_categorias WHERE id='$id'");
while ($dadoss66 = $executa66->fetch(PDO::FETCH_ASSOC)) { 
	$titulo    = $dadoss66['titulo'];
	$alias     = $dadoss66['alias'];
	$descricao = $dadoss66['descricao'];
}
?>

<?php // SALVA ALTERAÇÃO
if ( isset($_POST["envia"]) ) {

	$nome = $_POST['nome'];
	$alias = transformaAlias($nome);
	$descricao = $_POST['descricao'];

    $query = $pdo->query("UPDATE loja_categorias SET 
	    titulo='$nome',
	    alias='$alias',
	    descricao='$descricao'
    WHERE id='$id'");
    
    $msgs = "Dados Atualizados com sucesso";
    echo "<script>document.location.href='minha-conta/?pg=loja_admin/categorias.php&msgs=$msgs'</script>";
    exit(); 
}
?>

<form name="categorias" method="post" action="" class="form-inline" enctype="multipart/form-data">

	<div style="margin:10px; display:inline-block;">
	    Nome:&nbsp;&nbsp;
	    <input type="text" name="nome" value="<?php echo $titulo; ?>" required class="form-control"/>
	</div>

	<br>

	<div style="margin:10px; display:inline-block;">
	    Descrição:&nbsp;&nbsp;
	    <textarea class="form-control" name="descricao"><?php echo $descricao; ?></textarea>
	</div>

	<br>

	<input class="btn btn-primary" type="submit" name="envia" value="Atualizar"/>

</form>