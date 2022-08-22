<?php
ini_set('display_errors',1); // Força o PHP a mostrar os erros.
ini_set('display_startup_erros',1); // Força o PHP a mostrar os erros.
error_reporting(E_ALL); // Força o PHP a mostrar os erros.
ini_set("log_errors_max_len",2048);
date_default_timezone_set("Brazil/East"); // seta configurações fusuhorario para Brasil
ini_set ('default_charset', 'UTF-8'); // seta o php em UTF 8
?>

<h3 class="text-success">Novo Artigo</h3>
<hr>

<?php
$TinyMce="SIM";
$habilitareditor='completo';
//Função que mostra os erros da validação
function ErrosCadastro($campovaziov, $fotosv) { ?>
    <div class="alert alert-danger" role="alert">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <h4>Erro - Alerta!</h4>
        <?php echo $campovaziov; ?>
        <?php echo $fotosv; ?>
    </div> 
<?php  }

if(isset($_POST['envia'])) {

	$data = date('Y-m-d H:i:s');
	$categoria = $_POST['categoria'];
	$titulo = trim($_POST['titulo']);
	$texto = $_POST['texto'];
	$status = $_POST['status'];
	$meta_descricao = $_POST['meta_descricao'];
	$meta_keywords = $_POST['meta_keywords'];
	$foto_abertura = @$_POST['foto_abertura'];

	//alias
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
	    $sqltitulo = $pdo->query("SELECT * FROM blog_itens WHERE titulo='$titulo' ");
	    if ($sqltitulo->rowCount() >= 1){
	        $erros++;
	        $campovaziov="O título <b>$titulo</b> ja existe no sistema!<br>";
	    } 
	}

	// Chama o arquivo com a classe WideImage - Resize Image
	include '/home/epapodetarotcom/public_html/scripts/wideimage-11.02.19-full/lib/WideImage.php';

	// Verifica se foi enviado a foto de abertura
	if(!empty($_FILES['foto_abertura']['name']['0'])) {
	    
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
		$resized = $image->resize(840, 840);
		// And finally, save the image:
		$resized->saveToFile($pasta);
	    
	} else {
	    
	    $nome_foto_abertura = null;
	}

	// Se tiver mais de um erro mostra a mensagem de erro
	if($erros >= 1) {

	    // se der erro deleta foto de abertura, pasta de fotos e videos
	    // Deleta Foto de Abertura
	    $filepath = "site_blog/foto_abertura/".$nome_foto_abertura;
	    @unlink ($filepath);
	    $nome_foto_abertura = null;

	    ErrosCadastro($campovaziov, $fotosv);

	} else {

		// fim da validação
		// se não tiver encontrado erros o cadastro é realizado normalmente.
	 
	    $pdo->query("INSERT INTO blog_itens (
	        titulo,
	        alias,
	        texto,
	        foto_abertura,
	        data,
	        categoria,
	        status,
	        meta_descricao,
	        meta_keywords
	    ) VALUES (
	        '$titulo',
	        '$alias',
	        '$texto',
	        '$nome_foto_abertura',
	        '$data',
	        '$categoria',
	        '$status',
	        '$meta_descricao',
	        '$meta_keywords'
	    )");

	    $msgs="Artigo Criado Com Sucesso!";
	    echo "<script>document.location.href='minha-conta/?pg=site_blog/itens.php&msgs=$msgs'</script>";
    }
}

?>
<p><span class="small">(*) Preenchimento obrigatório.</span></p>

<form name="Produtos" method="post" action="" class="form-horizontal" enctype="multipart/form-data" novalidate>

    <div class="form-group">
        <label for="">* Categoria:</label>
	    <select name="categoria" class="form-control" required>
			<option value="" selected="selected">  --  Categoria  --  </option>
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
        <input type="text" name="titulo" class="form-control" placeholder="Titulo do artigo" value="<?php echo $titulo = isset($_POST['titulo']) ? $_POST['titulo'] : ''; ?>" required >
    </div>

    <div class="form-group">
        <label for="">Foto Principal:</label>
        <input type="file" id="foto_abertura" name="foto_abertura" class="btn btn-primary" >
    </div>

    <div class="form-group">
        <label for="">* Post:</label>
        <textarea class="form-control" name="texto"><?php echo $texto = isset($_POST['texto']) ? $_POST['texto'] : ''; ?></textarea>
    </div>

    <div class="form-group">
        <label for="">* Estatus:</label>
        <select name="status" class="form-control" required  > 
            <option value="Ativo" selected="selected">Ativo</option> 
            <option value="Desativado">Desativado</option> 
        </select>
    </div>

    <div class="form-group">
        <label for="">Meta Descriçãos:</label>
        <input type="text" name="meta_descricao" class="form-control" placeholder="Descrição Curta... " value="<?php echo $meta_descricao = isset($_POST['meta_descricao']) ? $_POST['meta_descricao'] : ''; ?>" >
    </div>

    <div class="form-group">
        <label for="">Meta Keyworks:</label>
        <input type="text" name="meta_keywords" class="form-control" placeholder="Palavra 1, Palavra 2, Palavra 3, ... " value="<?php echo $meta_keywords = isset($_POST['meta_keywords']) ? $_POST['meta_keywords'] : ''; ?>" >
    </div>
    
    <input class="btn btn-primary" type="submit" name="envia" value="Criar Artigo"/>

</form>