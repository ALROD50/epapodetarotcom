<h3 class="text-success">Editar Artigo</h3>
<hr>
<?php
$TinyMce="SIM";
$habilitareditor='completo';
$id = @$_GET['id'];
//Função que mostra os erros da validação
function ErrosCadastro($campovaziov, $fotosv) { ?>
    <div class="alert alert-danger" role="alert">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <h4>Erro - Alerta!</h4>
        <?php echo $campovaziov; ?>
        <?php echo $fotosv; ?>
    </div> 
<?php  }
$executa66 = $pdo->query("SELECT * FROM blog_itens WHERE id='$id'");
while ($aux = $executa66->fetch(PDO::FETCH_ASSOC)) { 
	$foto_abertura_db=$aux['foto_abertura'];
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

if ( isset($_POST["editarartigo"]) ) {

	$categoria = $_POST['categoria'];
	$titulo = trim($_POST['titulo']);
	$texto = $_POST['texto'];
	$texto = preg_replace("/'/", "", $texto);
	$status = $_POST['status'];
	$meta_descricao = $_POST['meta_descricao'];
	$meta_keywords = $_POST['meta_keywords'];
	$foto_abertura = @$_POST['foto_abertura'];

	$alias = TransformaAlias($titulo);

	/*variavel que conta os erros*/
	$erros           = null;
	$fotos           = null;
	$conta           = 0;
	$upload_mensagem = null;
	$fotosv          = null;

	// validação dos campos vazios
	if ($categoria=="" OR $titulo=="" OR $texto=="") { 
	    $erros++;
	    $campovaziov = "Campo(s) vazio(s), por favor preencha os campos obrigatórios marcados com * (estrela).<br>"; 
	}

	// Verifica se título ja existe no sistema
	if ($_POST['titulo']) {
	    $sqltitulo = $pdo->query("SELECT * FROM blog_itens WHERE titulo='$titulo' && id != '$id'");
	    if ($sqltitulo->rowCount() >= 1){
	        $erros++;
	        $campovaziov="O título <b>$titulo</b> ja existe no sistema!<br>";
	    } 
	}

	// Chama o arquivo com a classe WideImage - Resize Image
	include '/home/epapodetarotcom/public_html/scripts/wideimage-11.02.19-full/lib/WideImage.php';

	// Verifica se foi enviado a foto de abertura
	if(!empty($_FILES['foto_abertura']['name']['0'])) {

	    // Deleta a foto que estava lá antes.
        $filepath = "/home/epapodetarotcom/public_html/images/blog/foto_abertura/".$foto_abertura_db;
        unlink ($filepath);

	    $img  = $_FILES['foto_abertura'];
		$name = $img['name'];
		$tmp  = $img['tmp_name'];

	 	$ext = explode(".", $name);
	    $ext = end($ext);
	    $ext = strtolower($ext);

		$pasta = '/home/epapodetarotcom/public_html/images/blog/foto_abertura/';
		$nome_foto_abertura  =  uniqid().'.'.$ext; 

		//Faz o upload da imagem para o servidor
		$upload  = move_uploaded_file($tmp, $pasta.$nome_foto_abertura);
		$pasta = '/home/epapodetarotcom/public_html/images/blog/foto_abertura/'.$nome_foto_abertura;

		// Then you can load an image:
		$image = WideImage::load($pasta);
		// After the image is loaded, you can perform operations on it:
		$resized = $image->resize(500, 500);
		// And finally, save the image:
		$resized->saveToFile($pasta);
	    
	} else {
	    
	    $nome_foto_abertura = $foto_abertura_db;
	}

	// Se tiver mais de um erro mostra a mensagem de erro
	if($erros >= 1) {


	} else {

		$query = $pdo->query("UPDATE blog_itens SET 
            titulo='$titulo',
            alias='$alias',
            texto='$texto',
            foto_abertura='$nome_foto_abertura',
            categoria='$categoria',
            status='$status',
            meta_descricao='$meta_descricao',
            meta_keywords='$meta_keywords'
        WHERE id='$id'");

	    $msgs="Artigo Atualizado Com Sucesso!";
	    echo "<script>document.location.href='minha-conta/?pg=site_blog/itens.php&msgs=$msgs'</script>";
    } 
}
?>
<p><span class="small">(*) Preenchimento obrigatório.</span></p>

<form name="Produtos" method="post" action="" class="form-horizontal" enctype="multipart/form-data" novalidate>

    <div class="form-group">
        <label for="">* Categoria:</label>
	    <select name="categoria" class="form-control" required>
            <option value="<?php echo $categoria_id; ?>" selected><?php echo @$categoria_nome; ?></option>
            <?php 
            $sql = $pdo->query("SELECT * FROM blog_categoria ORDER BY titulo ASC");
            if ($sql->rowCount() == 0) {
                echo '<option value="">Nenhum dado encontrado...</option>';
            } else { 
                while ($nomes_encontrados = $sql->fetch(PDO::FETCH_ASSOC)){
                    echo '<option value="'.$nomes_encontrados['id'].'">'.$nomes_encontrados['titulo'].'</option>';
                }
            }
            ?>
	    </select>
    </div>

    <div class="form-group">
        <label for="">* Título:</label>
        <input type="text" name="titulo" class="form-control" value="<?php echo $titulo; ?>" required >
    </div>

    <div class="form-group">
        <label for="">* Foto Principal:</label>
        <?php 
          echo "<br><img src='../images/blog/foto_abertura/$foto_abertura_db' height='100'/><br>";
        ?>
        <p></p>
        <div>
            <span style="margin-right: 10px; margin-top: 8px; float: left;">Alterar Foto:</span>
            <input type="file" id="foto_abertura" name="foto_abertura" class="btn btn-primary">
        </div>
    </div>

    <div class="form-group">
        <label for="">* Post:</label>
        <textarea class="form-control" name="texto"><?php echo $texto; ?></textarea>
    </div>

    <div class="form-group">
        <label for="">* Estatus:</label>
        <select name="status" class="form-control" required> 
        	<option value="<?php echo $status; ?>" selected><?php echo $status; ?></option>
            <option value="Ativo">Ativo</option> 
            <option value="Desativado">Desativado</option> 
        </select>
    </div>

    <div class="form-group">
        <label for="">Meta Descriçãos:</label>
        <input type="text" name="meta_descricao" class="form-control" value="<?php echo $meta_descricao; ?>" >
    </div>

    <div class="form-group">
        <label for="">Meta Keyworks:</label>
        <input type="text" name="meta_keywords" class="form-control" value="<?php echo $meta_keywords; ?>" >
    </div>
    
    <input class="btn btn-primary" type="submit" name="editarartigo" value="Atualizar Artigo"/>

</form>