<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>

<!-- Lightbox2 -->
<link rel="stylesheet" href="https://www.epapodetarot.com.br/scripts/lightbox2-master/css/lightbox.min.css" type="text/css" media="screen" />
<!-- Lightbox2 -->

<style type="text/css">
    .deletafoto {
        background: url('img/delete.gif');
        border: none;
        width: 16px;
        height: 16px;
        position: absolute;
    }
    #formdeleta {
        position: relative;
    }
</style>

<?php
$TinyMce    ="SIM";
$habilitareditor='completo';
$Mask       ="SIM";
$id = @$_GET['id'];

// Deleta fotos individuais do anuncio
if(isset($_GET['delfoto'])) {
    $arquivo = $_GET['arquivo'];
    $path = $_GET['path'];

    //deleta a foto que estava lá antes.
    $filepath = $path."/".$arquivo;
    unlink ($filepath);

    $msgs="Foto Deletada Com Sucesso!";
    echo "<script>document.location.href='minha-conta/?pg=loja_admin/editar.php&id=$id&msgs=$msgs'</script>";
}

$executa66 = $pdo->query("SELECT * FROM loja_produtos WHERE id='$id'");
while ($dadoss66 = $executa66->fetch(PDO::FETCH_ASSOC)){ 
    $titulo=$dadoss66['titulo'];
    $alias=$dadoss66['alias'];
    $descricao=$dadoss66['descricao'];
    $foto_abertura_db=$dadoss66['foto_abertura'];
    $fotos=$dadoss66['fotos'];
    $altura=$dadoss66['altura'];
    $largura=$dadoss66['largura'];
    $comprimento=$dadoss66['comprimento'];
    $peso=$dadoss66['peso'];
    $preco=$dadoss66['preco'];
    $preco = MostraValorDinheiroCorretamenteNoCifrao($preco);
    $categoria=$dadoss66['categoria'];
    $estoque=$dadoss66['estoque'];
    $status=$dadoss66['status'];
    $meta_descricao=$dadoss66['meta_descricao'];
    $meta_keywords=$dadoss66['meta_keywords'];
    $visualizacoes=$dadoss66['visualizacoes'];
}
?>

<h3 class="text-success">Editar Produto: #<?php echo $id.' - '.$titulo; ?></h3>

<?php
//Função que mostra os erros da validação
function ErrosCadastro($campovaziov, $fotosv, $foto_aberturav) { ?>
    <div class="alert alert-danger" role="alert">
        <button type="button" class="close" data-dismiss="alert">×</button>
          <h4>Erro - Alerta!</h4>
          <?php echo $campovaziov; ?>
          <?php echo $fotosv; ?>
          <?php echo $foto_aberturav; ?>
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
    $fotosForm = @$_POST['fotos'];

    //alias
    $alias = TransformaAlias($titulo);

    /*variavel que conta os erros*/
    $erros           = null;
    $conta           = 0;
    $upload_mensagem = null;
    $fotosv          = null;
    $foto_aberturav  = null;

    // validação dos campos vazios
    if (empty($_POST['categoria']) || empty($_POST['titulo']) || empty($_POST['preco']) || empty($_POST['descricao']) || empty($_POST['estoque']) || $comprimento=="" || $altura=="" || $largura=="" ) { 
        $erros++;
        $campovaziov = "Campo(s) vazio(s), por favor preencha os campos obrigatórios marcados com * (estrela).<br>"; 
    }

    // Verifica se título ja existe no sistema
    if ($_POST['titulo']) {
        $sqltitulo = $pdo->query("SELECT * FROM loja_produtos WHERE titulo ='$titulo' && id != '$id'");
        if ($sqltitulo->rowCount() >= 1){
            $erros++;
            $campovaziov="O título <b>$titulo</b> ja existe no sistema!<br>";
        }
    }

    // Chama o arquivo com a classe WideImage
    include '/home/epapodetarotcom/public_html/scripts/wideimage-11.02.19-full/lib/WideImage.php';

    // Verifica se foi enviado a foto de abertura
    if(!empty($_FILES['foto_abertura']['name']['0'])) {

        // Deleta a foto que estava lá antes.
        $filepath = "/home/epapodetarotcom/public_html/loja_admin/foto_abertura/".$foto_abertura_db;
        unlink ($filepath);

        // Enviando nova foto
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
        $pasta = '/home/epapodetarotcom/public_html/'.$pasta.$nome_foto_abertura;

        // Then you can load an image:
        $image = WideImage::load($pasta);
        // After the image is loaded, you can perform operations on it:
        $resized = $image->resize(840, 840);
        // And finally, save the image:
        $resized->saveToFile($pasta);
        
    } else {
        
        $nome_foto_abertura = $foto_abertura_db;
    }
                
    // Verifica se foi enviado fotos
    if (!empty($_FILES['fotos']['name']['0'])) {

        $sizeFile    = $_FILES['fotos']['size']['0'];
        $name        = $_FILES['fotos']['name'];
        $tmp_name    = $_FILES['fotos']['tmp_name'];
        $allowedExts = array("gif", "jpeg", "jpg", "png", "bmp");
        $nome_da_pasta = $fotos;
        $dir = 'loja_admin/fotos/'.$nome_da_pasta.'/';

        // Copia o arquivo thumb.php para a pasta das fotos
        $thumbDir        = '/home/epapodetarotcom/public_html/loja_admin/thumb.php';
        $CopiathumbDir   = '/home/epapodetarotcom/public_html/loja_admin/fotos/'.$nome_da_pasta.'/thumb.php';
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

                    $upload_mensagem = "Suas Fotos Foram Enviadas Com Sucesso!";
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
    }

    // Se tiver mais de um erro mostra a mensagem de erro
    if($erros >= 1) {

        // Fotos de Abertura - Verifica se esta sendo enviado nova Foto de Abertura
        if (!empty($_FILES['foto_abertura']['name']['0'])) {
            // Deleta Foto de Abertura
            $filepath = "/home/epapodetarotcom/public_html/loja_admin/foto_abertura/".$nome_foto_abertura;
            unlink ($filepath);
            $nome_foto_abertura = null;;
        }

        ErrosCadastro($campovaziov, $fotosv, $foto_aberturav);

    } else {

        // fim da validação
        // se não tiver encontrado erros o cadastro é realizado normalmente.
     
        $query = $pdo->query("UPDATE loja_produtos SET 

            titulo='$titulo',
            alias='$alias',
            descricao='$descricao',
            foto_abertura='$nome_foto_abertura',
            fotos='$fotos',
            altura='$altura',
            largura='$largura',
            comprimento='$comprimento',
            peso='$peso',
            preco='$preco',
            categoria='$categoria',
            estoque='$estoque',
            status='$status',
            meta_descricao='$meta_descricao',
            meta_keywords='$meta_keywords',
            visualizacoes='$visualizacoes'

        WHERE id='$id'");

        $msgs = "Produto Atualizado Com Sucesso!<br>";
        $msgs .= $upload_mensagem;
        echo "<script>document.location.href='minha-conta/?pg=loja_admin/editar.php&id=$id&msgs=$msgs'</script>";
    } 
} 
?>
<p><span class="small">(*) Preenchimento obrigatório.</span></p>

<form id='Produtos' name="Produtos" method="post" action="" class="form-horizontal" enctype="multipart/form-data" style="padding: 15px;"  novalidate>

    <center><p><b style="font-size:18px;">Dados Básicos</b></p></center>

    <hr style="border-top: 1px solid #ccc;">

    <div class="form-group">
        <label for="">* Categoria:</label>
        <select name="categoria" class="form-control" required>
            <option value="" selected="selected">  --  Categoria  --  </option>
            <?php 
            $executa66 = $pdo->query("SELECT * FROM loja_categorias WHERE id='$categoria'");
            while ($dadoss66 = $executa66->fetch(PDO::FETCH_ASSOC)){ 
                $categoria_nome=$dadoss66['titulo'];
            }
            ?>
            <option value="<?php echo $categoria; ?>" selected><?php echo $categoria_nome; ?></option>
            <?php 
            $sql = $pdo->query("SELECT * FROM loja_categorias ORDER BY titulo ASC");
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

    <hr style="border-top: 1px solid #ccc;">

    <div class="form-group">
        <label for="">* Nome do Produto:</label>
        <input type="text" name="titulo" class="form-control" placeholder="Digite o Nome do Produto..." value="<?php echo $titulo = isset($_POST['titulo']) ? $_POST['titulo'] : $titulo; ?>" required >
    </div>

    <div class="form-group">
        <label for="">* Preço R$:</label>
        <input type="text" name="preco" class="form-control money2" placeholder="R$ 00,00" value="<?php echo $preco = isset($_POST['preco']) ? $_POST['preco'] : $preco; ?>" required >
    </div>

    <div class="form-group">
        <label for="">* Descrição:</label>
        <textarea class="form-control" name="descricao" cols="30" rows="10"><?php echo $descricao; ?></textarea>
    </div>

    <div class="form-group">
        <label for="">* Estatus:</label>
        <select name="status" class="form-control" required  > 
            <option value="<?php echo $status; ?>" selected><?php echo $status; ?></option>
            <option value="Ativo" selected="selected">Ativo</option> 
            <option value="Desativado">Desativado</option> 
        </select>
    </div>

    <div class="form-group">
        <label for="">* Estoque:</label>
        <input type="text" name="estoque" class="form-control OnlyNumber" placeholder="Quantidade do produto em estoque disponível" value="<?php echo $estoque = isset($_POST['estoque']) ? $_POST['estoque'] : $estoque; ?>" required  >
    </div>

    <center><p><b style="font-size:18px;">Dimenções do Produto e Peso</b></p></center>

    <!-- Box Regras Pacotes Correios -->
    <div class="panel panel-info" id="BoxRegrasCorreios" style="display: none;">
        <div class="panel-heading">
            <h4>Regras de Dimensões do Pacote nos Correios</h4>
        </div>
        <div class="panel-body">
            <img src="https://www.epapodetarot.com.br/images/frete.png" alt="">
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
                <input type="text" name="peso" class="form-control peso" placeholder="Ex: 00.500... 01.000..." value="<?php echo $peso = isset($_POST['peso']) ? $_POST['peso'] : $peso; ?>" required>
            </div>
        </div>

        <div class="col-md-5" style="margin:10px;">
            <div class="form-group">
                <label for="">* Comprimento:</label> <a role="button" class="btn-toggle" data-element="#BoxRegrasCorreios"><i class="fas fa-question-circle"></i></a>
                <input type="text" name="comprimento" class="form-control cardCVC" placeholder="Em centimetros" value="<?php echo $comprimento = isset($_POST['comprimento']) ? $_POST['comprimento'] : $comprimento; ?>" required>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-5" style="margin:10px;"> 
            <div class="form-group">
                <label for="">* Altura:</label> <a role="button" class="btn-toggle" data-element="#BoxRegrasCorreios"><i class="fas fa-question-circle"></i></a>
                <input type="text" name="altura" class="form-control cardCVC" placeholder="Em centimentos" value="<?php echo $altura = isset($_POST['altura']) ? $_POST['altura'] : $altura; ?>" required>
            </div>
        </div>

        <div class="col-md-5" style="margin:10px;">
            <div class="form-group">
                <label for="">* Largura:</label> <a role="button" class="btn-toggle" data-element="#BoxRegrasCorreios"><i class="fas fa-question-circle"></i></a>
                <input type="text" name="largura" class="form-control cardCVC" placeholder="Em centimentos" value="<?php echo $largura = isset($_POST['largura']) ? $_POST['largura'] : $largura; ?>" required>
            </div>
        </div>
    </div>

    <center><p><b style="font-size:18px;">SEO - Otimização Para Buscadores</b></p></center>

    <div class="form-group">
        <label for="">Meta Descriçãos:</label>
        <input type="text" name="meta_descricao" class="form-control" placeholder="Descrição Curta... " value="<?php echo $meta_descricao = isset($_POST['meta_descricao']) ? $_POST['meta_descricao'] : $meta_descricao; ?>" >
    </div>

    <div class="form-group">
        <label for="">Meta Keyworks:</label>
        <input type="text" name="meta_keywords" class="form-control" placeholder="Palavra 1, Palavra 2, Palavra 3, ... " value="<?php echo $meta_keywords = isset($_POST['meta_keywords']) ? $_POST['meta_keywords'] : $meta_keywords; ?>" >
    </div>
    
    <center><p><b style="font-size:18px;">Mídias</b></p></center>
    
    <div class="form-group">
        <label for="">* Foto Principal:</label>
        <?php 
          echo "<br><img src='loja_admin/foto_abertura/$foto_abertura_db' height='100'/><br>";
        ?>
        <p></p>
        <div>
            <span style="margin-right: 10px; margin-top: 8px; float: left;">Alterar Foto:</span>
            <input type="file" id="foto_abertura" name="foto_abertura" class="btn btn-primary">
        </div>
    </div>

    <hr style="border-top: 1px solid #ccc;">

    <div class="form-group">
        <label for="">Fotos:</label>
        <br>
        <?php
        if (!empty($fotos)) {
            /* Diretorio que deve ser lido */
            $path = "loja_admin/fotos/".$fotos;
            $diretorio = dir($path);
            /* Abre o diretório */
            $pasta = opendir($path);
            /* Loop para ler os arquivos do diretorio */
            while ($arquivo = readdir($pasta)) {
                /* Verificacao para exibir apenas os arquivos e nao os caminhos para diretorios superiores */
                // Separa a extensão
                $ext = explode(".", $arquivo);
                $ext = end($ext);
                $ext = strtolower($ext);
                if ($arquivo != '.' && $arquivo != '..' && $ext != 'php') {
                    ?>
                    <div id='container' style='margin:0px 10px 10px 0px; float:left;'>
                        <div id='' style='position: relative;'>
                            <a href='<?php echo "minha-conta/?pg=loja_admin/editar.php&id=$id&delfoto=delfoto&arquivo=$arquivo&path=$path"; ?>'><i class="fas fa-minus-circle text-danger"></i>Excluir</a>
                        </div>
                        <a href='<?php echo $path."/".$arquivo; ?>' title='<?php echo $titulo; ?>' rel="lightbox[plants]">
                            <img src='<?php echo $path."/thumb.php?img=".$arquivo; ?>' alt="<?php echo $titulo; ?>" class='img-thumbnail' />
                        </a>
                    </div>
                    <?php
                }
            }
            $diretorio->close();
          } else {
            echo "Não existem imagens para este anúncio...";
        }
        ?>
        <div style="clear:both;"></div>
        <p></p>
        <div>
            <span style="margin-right: 10px; margin-top: 8px; float: left;">Enviar novas fotos:</span>
            <input type="file" id="fotos" name="fotos[]" multiple class="btn btn-primary">
        </div>
    </div>

   <hr style="border-top: 1px solid #ccc;">

    <input class="btn btn-primary" type="submit" name="envia" value="Atualizar Produto" onclick="preloader()"/>
    <input class="btn btn-info" type="button" name="Cancel" value="Cancelar" onclick="Voltar()" />

    <div id="preloader" style="display:none;">
      <img src="img/ajax-loader.gif" alt="Carregando"> <b>Carregando Aguarde...</b>
    </div>
</form>

<script type="text/javascript">
    function Voltar() {
        document.location.href="minha-conta/?pg=loja_admin/produtos.php&topo=true";
    }
</script>
<script type="text/javascript">
    function preloader(){
        $("#preloader").show();
    }
</script>

<!-- Lightbox2 -->
<script src="https://www.epapodetarot.com.br/scripts/lightbox2-master/js/lightbox-plus-jquery.min.js"></script>
<!-- Lightbox2 -->

<script>
    $(function(){
        $(".btn-toggle").click(function(e){
            e.preventDefault();
            el = $(this).data('element');
            $(el).toggle();
        });
    });
</script>