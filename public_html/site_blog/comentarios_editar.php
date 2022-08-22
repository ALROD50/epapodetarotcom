<h3 class="text-success">Editar Comentário</h3>
<hr>
<?php
$habilitareditor='completo';
$id = @$_GET['id'];
$executa = $pdo->query("SELECT * FROM blog_comentarios WHERE id='$id'");
$encontrados = $executa->rowCount();
while ($dadoss= $executa->fetch(PDO::FETCH_ASSOC)) {
	$mensagem=$dadoss['mensagem'];
	$status=$dadoss['status'];
}

if ( isset($_POST["editarcomentarioblog"]) ) {

	$mensagem = $_POST['mensagem'];
	$status = $_POST['status'];

	$query = $pdo->query("UPDATE blog_comentarios SET 
        mensagem='$mensagem',
        status='$status'
    WHERE id='$id'");

    $msgs="Comentário Atualizado Com Sucesso!";
    echo "<script>document.location.href='minha-conta/?pg=site_blog/comentarios_admin.php&msgs=$msgs'</script>";
}
?>
<p><span class="small">(*) Preenchimento obrigatório.</span></p>

<form name="FormComentarios" method="post" action="" class="form-horizontal" enctype="multipart/form-data" novalidate>

    <div class="form-group">
        <label for="">Estatus:</label>
        <select name="status" class="form-control"> 
        	<option value="<?php echo $status; ?>" selected><?php echo $status; ?></option>
            <option value="Ativo">Ativo</option> 
            <option value="Desativado">Desativado</option> 
        </select>
    </div>

    <div class="form-group">
        <label for="">Mensagem:</label>
        <textarea class="form-control" name="mensagem"><?php echo $mensagem; ?></textarea>
    </div>
    
    <input class="btn btn-primary" type="submit" name="editarcomentarioblog" value="Atualizar Comentário"/>

</form>