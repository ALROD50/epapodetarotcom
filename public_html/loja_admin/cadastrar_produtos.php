<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script type="text/javascript">
    function Voltar() {
        document.location.href="minha-conta/?pg=loja_admin/produtos.php&topo=true";
    }

    function preloader(){
        $("#preloader").show();
    }

    $(function(){
        $(".btn-toggle").click(function(e){
            e.preventDefault();
            el = $(this).data('element');
            $(el).toggle();
        });
    });
</script>

<h3 class="text-success">Cadastrar Novo Produto</h3>
<hr>
<?php
$TinyMce    ="SIM";
$habilitareditor='completo';
$Mask       ="SIM";
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

	$categoria = $_POST['categoria'];
	$titulo = trim($_POST['titulo']);
	$preco = $_POST['preco'];
	$preco = MudaValorDinheiroGravar($preco);
	$descricao = $_POST['descricao'];
	$status = $_POST['status'];
	$estoque = $_POST['estoque'];
	$peso = $_POST['peso'];
	$comprimento = $_POST['comprimento'];
	$altura = $_POST['altura'];
	$largura = $_POST['largura'];
	$meta_descricao = $_POST['meta_descricao'];
	$meta_keywords = $_POST['meta_keywords'];
	$foto_abertura = @$_POST['foto_abertura'];
	$fotos = @$_POST['fotos'];

	//alias
	$alias = TransformaAlias($titulo);

	/*variavel que conta os erros*/
	$erros           = null;
	$fotos           = null;
	$conta           = 0;
	$upload_mensagem = null;
	$fotosv          = null;

	// validação dos campos vazios
	if (empty($_POST['categoria']) || empty($_POST['titulo']) || empty($_POST['preco']) || empty($_POST['descricao']) || empty($_POST['estoque']) || $comprimento=="" || $altura=="" || $largura=="") { 
	    $erros++;
	    $campovaziov = "Campo(s) vazio(s), por favor preencha os campos obrigatórios marcados com * (estrela).<br>"; 
	}

	// Verifica se título ja existe no sistema
	if ($_POST['titulo']) {
	    $sqltitulo = $pdo->query("SELECT * FROM loja_produtos WHERE titulo='$titulo' ");
	    if ($sqltitulo->rowCount() >= 1){
	        $erros++;
	        $campovaziov="O título <b>$titulo</b> ja existe no sistema!<br>";
	    } 
	}

	// Chama o arquivo com a classe WideImage
	include '/home/tarotdehoruscom/public_html/scripts/wideimage-11.02.19-full/lib/WideImage.php';

	// Verifica se foi enviado fotos
	if (!empty($_FILES['fotos']['name']['0'])) {

	    $sizeFile    = $_FILES['fotos']['size']['0'];
	    $name        = $_FILES['fotos']['name'];
	    $tmp_name    = $_FILES['fotos']['tmp_name'];
	    $allowedExts = array("gif", "jpeg", "jpg", "png", "bmp");
	    $nome_da_pasta = date("Y.m.d-H.i.s").'_'.uniqid();
	    // Cria uma nova pasta
	    mkdir(dirname(__FILE__) . "/fotos/$nome_da_pasta", 0777, true);
	    $dir         = 'loja_admin/fotos/'.$nome_da_pasta.'/';

	    // Copia o arquivo thumb.php para a pasta das fotos
	    $thumbDir        = '/home/tarotdehoruscom/public_html/loja_admin/thumb.php';
	    $CopiathumbDir   = '/home/tarotdehoruscom/public_html/loja_admin/fotos/'.$nome_da_pasta.'/thumb.php';
	    if (!copy($thumbDir, $CopiathumbDir)) {
	        $erros++;
	        $fotosv = "Erro ao criar o thump.php.<br>";
	    }

	    // Contagem dos arquivos 
	    $conta = 0; 

	    for ($i = 0; $i < count($tmp_name); $i++) {         
	        
	        // Separa a extensão
	        $ext = explode(".", $name[$i]);
		    $ext = end($ext);
		    $ext = strtolower($ext);

	        // Muda o nome da imagem
	        $name[$i] = uniqid().'.'.$ext;

	        // Verifica se a extensão esta no array
	        if(in_array($ext, $allowedExts)  ) {
	            $fotos = $nome_da_pasta;

	            // Depois verifica se é possível mover o arquivo para a pasta escolhida
	            if (move_uploaded_file($_FILES['fotos']['tmp_name'][$i], $dir . $name[$i])) {
	                
	                // Then you can load an image:
	                $image = WideImage::load($dir . $name[$i]);
	                // After the image is loaded, you can perform operations on it:
	                $resized = $image->resize(900, 768);
	                // And finally, save the image:
	                $resized->saveToFile($dir . $name[$i]);

	                // Upload efetuado com sucesso, exibe uma mensagem e um link para o arquivo
	                $upload_mensagem = "O Seu Arquivo Foi Enviado Com Sucesso!";
	                $conta++;
	                
	            } else {
	                // Não foi possível fazer o upload, provavelmente a pasta está incorreta
	                $erros++;
	                $fotosv = "Não foi possível enviar os arquivos, tente novamente.<br>";
	            }
	        } else {
	            // Essa extensão não pode ser enviada
	            $erros++;
	            $fotosv = "Essa extensão de arquivo não pode ser enviada, tente novamente com outro formato de arquivo.<br>";
	            $fotosv .= "Extensões permitidas: .gif, .jpeg, .jpg, .png, .bmp<br>";
	        }
	    }
		
	} else {

	    // Se não foi enviadas fotos, então apenas cria uma pasta para as fotos, e copia o arquivo thumb.php
	    $fotos = date("Y.m.d-H.i.s").'_'.uniqid();
	    mkdir(dirname(__FILE__) . "/fotos/$fotos", 0777, true);
	    // Copia o arquivo thumb.php para a pasta das fotos
	    $thumbDir        = '/home/tarotdehoruscom/public_html/loja_admin/thumb.php';
	    $CopiathumbDir   = '/home/tarotdehoruscom/public_html/loja_admin/fotos/'.$fotos.'/thumb.php';
	    if (!copy($thumbDir, $CopiathumbDir)) {
	        $erros++;
	        $fotosv = "Erro ao criar o thump.php.<br>";
	    }
	}

	// Verifica se foi enviado a foto de abertura
	if(!empty($_FILES['foto_abertura']['name']['0'])) {
	    
	    $img  = $_FILES['foto_abertura'];
		$name = $img['name'];
		$tmp  = $img['tmp_name'];

	 	$ext = explode(".", $name);
	    $ext = end($ext);
	    $ext = strtolower($ext);

		$pasta   =  'loja_admin/foto_abertura/'; //Pasta onde a imagem será salva
		$nome_foto_abertura  =  uniqid().'.'.$ext; 

		//Faz o upload da imagem para o servidor
		$upload  = move_uploaded_file($tmp, $pasta.$nome_foto_abertura);
		$pasta = '/home/tarotdehoruscom/public_html/'.$pasta.$nome_foto_abertura;

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
	    $filepath = "loja_admin/foto_abertura/".$nome_foto_abertura;
	    @unlink ($filepath);
	    $nome_foto_abertura = null;

	    // Deleta Fotos - Pasta Inteira
	    $uploaddir = "/home/tarotdehoruscom/public_html/loja_admin/fotos/".$fotos;
	    @$dir_contents = scandir($uploaddir);
	    if(is_dir($uploaddir)) {
	        foreach($dir_contents as $content) {
	            @unlink($uploaddir.'/'.$content); // Deleta os arquivos
	            @rmdir($uploaddir); // Deleta a pasta
	        }
	    }
	    $fotos = null;

	    ErrosCadastro($campovaziov, $fotosv);

	} else {

		// fim da validação
		// se não tiver encontrado erros o cadastro é realizado normalmente.
	 
	    $pdo->query("INSERT INTO loja_produtos (
	        titulo,
	        alias,
	        descricao,
	        foto_abertura,
	        fotos,
	        altura,
	        largura,
	        comprimento,
	        peso,
	        preco,
	        categoria,
	        estoque,
	        status,
	        meta_descricao,
	        meta_keywords
	    ) VALUES (
	        '$titulo',
	        '$alias',
	        '$descricao',
	        '$nome_foto_abertura',
	        '$fotos',
	        '$altura',
	        '$largura',
	        '$comprimento',
	        '$peso',
	        '$preco',
	        '$categoria',
	        '$estoque',
	        '$status',
	        '$meta_descricao',
	        '$meta_keywords'
	    )");

	    $msgs="Produto Cadastrado Com Sucesso!";
	    echo "<script>document.location.href='minha-conta/?pg=loja_admin/produtos.php&msgs=$msgs'</script>";
    }
}

?>
<p><span class="small">(*) Preenchimento obrigatório.</span></p>

<form name="Produtos" method="post" action="" class="form-horizontal" enctype="multipart/form-data" style="padding: 15px;"  novalidate>

    <div class="card card-body" style="padding:35px;" >

        <center><p><b style="font-size:18px;">Dados Básicos</b></p></center>

        <hr style="border-top: 1px solid #ccc;">

        <div class="form-group">
            <label for="">* Categoria:</label>
		    <select name="categoria" class="form-control" required>
			    <option value="" selected="selected">  --  Categoria  --  </option>
			    <?php 
			      $sql = $pdo->query("SELECT * FROM loja_categorias ORDER BY titulo ASC");
			      if ($sql->rowCount() == 0) {
			          echo '<option value="">Nenhum dado encontrado...</option>';
			      } else { 
			        while ($nomes_encontrados = $sql->fetch(PDO::FETCH_ASSOC)){
			        echo '<option value="'.$nomes_encontrados['id'].'">'.$nomes_encontrados['titulo'].'</option>';
			        } }
			    ?>
		    </select>
        </div>

        <hr style="border-top: 1px solid #ccc;">

        <div class="form-group">
            <label for="">* Nome do Produto:</label>
            <input type="text" name="titulo" class="form-control" placeholder="Digite o Nome do Produto..." value="<?php echo $titulo = isset($_POST['titulo']) ? $_POST['titulo'] : ''; ?>" required >
        </div>

        <div class="form-group">
            <label for="">* Preço R$:</label>
            <input type="text" name="preco" class="form-control money2" placeholder="R$ 00,00" value="<?php echo $preco = isset($_POST['preco']) ? $_POST['preco'] : ''; ?>" required >
        </div>

        <div class="form-group">
            <label for="">* Descrição:</label>
            <textarea class="form-control" name="descricao" cols="30" rows="10"><?php echo $descricao = isset($_POST['descricao']) ? $_POST['descricao'] : ''; ?></textarea>
        </div>

        <div class="form-group">
            <label for="">* Estatus:</label>
            <select name="status" class="form-control" required  > 
                <option value="Ativo" selected="selected">Ativo</option> 
                <option value="Desativado">Desativado</option> 
            </select>
        </div>

        <div class="form-group">
            <label for="">* Estoque:</label>
            <input type="text" name="estoque" class="form-control OnlyNumber" placeholder="Quantidade do produto em estoque disponível" value="<?php echo $estoque = isset($_POST['estoque']) ? $_POST['estoque'] : ''; ?>" required  >
        </div>
        
    </div>

    <div class="card card-body" style="padding:35px;">

        <center><p><b style="font-size:18px;">Dimenções do Produto e Peso</b></p></center>

        <!-- Box Regras Pacotes Correios -->
        <div class="panel panel-info" id="BoxRegrasCorreios" style="display: none;">
            <div class="panel-heading">
                <h4>Regras de Dimensões do Pacote nos Correios</h4>
            </div>
            <div class="panel-body">
                <img src="https://www.tarotdehorus.com.br/images/frete.png" alt="">
            </div>
        </div>

        <!-- Box Exemplos de Pesos -->
        <div class="panel panel-info" id="BoxExemplosPeso" style="display: none;">
            <div class="panel-heading">
                <h4>Exemplos de Pesos</h4>
            </div>
            <div class="panel-body">
                <p>300 gramas = 00.300</p>
                <p>500 gramas = 00.500</p>
                <p>1 kg       = 01.000</p>
                <p>2,5 kg     = 02.500</p>
                <p>6 kg       = 06.000</p>
                <p>Peso máximo permitido nos corretios = 30kg</p>
            </div>
        </div>

        <div class="row">
            <div class="col-md-5" style="margin:10px;">
		        <div class="form-group">
		        	<label for="">* Peso Gramas:</label> <a role="button" class="btn-toggle" data-element="#BoxExemplosPeso"><i class="fas fa-question-circle"></i></a>
		            <input type="text" name="peso" class="form-control peso" placeholder="Em gramas" value="<?php echo $peso = isset($_POST['peso']) ? $_POST['peso'] : ''; ?>" required>
		        </div>
            </div>

            <div class="col-md-5" style="margin:10px;">
		        <div class="form-group">
		            <label for="">* Comprimento:</label> <a role="button" class="btn-toggle" data-element="#BoxRegrasCorreios"><i class="fas fa-question-circle"></i></a>
		            <input type="text" name="comprimento" class="form-control cardCVC" placeholder="Em centimetros" value="<?php echo $comprimento = isset($_POST['comprimento']) ? $_POST['comprimento'] : ''; ?>" required>
		        </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-5" style="margin:10px;"> 
		        <div class="form-group">
		            <label for="">* Altura:</label> <a role="button" class="btn-toggle" data-element="#BoxRegrasCorreios"><i class="fas fa-question-circle"></i></a>
		            <input type="text" name="altura" class="form-control cardCVC" placeholder="Em centimentos" value="<?php echo $altura = isset($_POST['altura']) ? $_POST['altura'] : ''; ?>" required>
		        </div>
            </div>

            <div class="col-md-5" style="margin:10px;">
		        <div class="form-group">
		            <label for="">* Largura:</label> <a role="button" class="btn-toggle" data-element="#BoxRegrasCorreios"><i class="fas fa-question-circle"></i></a>
		            <input type="text" name="largura" class="form-control cardCVC" placeholder="Em centimentos" value="<?php echo $largura = isset($_POST['largura']) ? $_POST['largura'] : ''; ?>" required>
		        </div>
            </div>
        </div>
    </div>

    <div class="card card-body" style="padding:35px;">

        <center><p><b style="font-size:18px;">SEO - Otimização Para Buscadores</b></p></center>

        <div class="form-group">
            <label for="">Meta Descriçãos:</label>
            <input type="text" name="meta_descricao" class="form-control" placeholder="Descrição Curta... " value="<?php echo $meta_descricao = isset($_POST['meta_descricao']) ? $_POST['meta_descricao'] : ''; ?>" >
        </div>

        <div class="form-group">
            <label for="">Meta Keyworks:</label>
            <input type="text" name="meta_keywords" class="form-control" placeholder="Palavra 1, Palavra 2, Palavra 3, ... " value="<?php echo $meta_keywords = isset($_POST['meta_keywords']) ? $_POST['meta_keywords'] : ''; ?>" >
        </div>
        
    </div>

    <div class="card card-body" style="padding:35px;">

        <center><p><b style="font-size:18px;">Mídias</b></p></center>
        
        <div class="form-group">
            <label for="">Foto Principal:</label>
            <input type="file" id="foto_abertura" name="foto_abertura" class="btn btn-primary" >
        </div>

        <div class="form-group">
            <label for="">Fotos:</label>
            <input type="file" id="fotos" name="fotos[]" multiple class="btn btn-primary">
        </div>
        
    </div>

    <input class="btn btn-primary" type="submit" name="envia" value="Cadastrar Produto" onclick="preloader()"/>
    <input class="btn btn-info" type="button" name="Cancel" value="Cancelar" onclick="Voltar()" />

    <div id="preloader" style="display:none;">
        <img src="img/ajax-loader.gif" alt="Carregando"> <b>Carregando Aguarde...</b>
    </div>

</form>

