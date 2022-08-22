<h3 class="text-success mt-3">Editar Tarólogo</h3>
<hr>
<?php
$TinyMce="SIM";
$habilitareditor='completo';
$id = @$_GET['id'];
$executa66 = $pdo->query("SELECT * FROM clientes WHERE id='$id'"); //se conecta no banco e concatena os dados

while ($dadoss66 = $executa66->fetch(PDO::FETCH_ASSOC)){ 
    $nome=$dadoss66['nome'];
    $alias=$dadoss66['alias'];
    $email=$dadoss66['email'];
    $email = trim($email);
    $status=$dadoss66['status'];
    $usuario=$dadoss66['usuario'];
    $usuario = trim($usuario);
    $especialidade_taro=$dadoss66['especialidade_taro'];
    $infos=$dadoss66['infos'];
    $logo=$dadoss66['logo'];
    $infos2=$dadoss66['infos2'];
    $nome2=$dadoss66['nome2'];
    $fotoreal=$dadoss66['fotoreal'];
    $videochamada=$dadoss66['videochamada'];
}

// SALVA ALTERAÇÃO
if (isset($_POST["salva"])) {

    //se tiver arquivo selecionado, faz o upload
    if(empty($_FILES['arquivo']['name'])) { 
        $nome_final = $logo;
    } else {
        //deleta o logo que estava lá antes.
        $filepath = "/home/tarotdehoruscom/public_html/tarologos_admin/fotos/".$logo;
        @unlink ($filepath);
        include "recebe_upload.php";
        $nome_final = $nome_final;
    }

    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $alias = $_POST['alias'];
    $status = $_POST['status'];
    $email = trim($_POST['email']);
    $usuario = trim($_POST['usuario']);
    $senha_post = md5(trim($_POST['senha']));
    $especialidade_taro = $_POST['especialidade_taro'];
    $infos = addslashes($_POST['infos']);
    $infos2 = strip_tags($_POST['infos2']);
    $nome2=$_POST['nome2'];
    $fotoreal=$_POST['fotoreal'];
    $videochamada=$_POST['videochamada'];

    $erros = null;

    // Verifica se e-mail ja existe no sistema
    if (!empty($_POST['email']) ) { // se o campo e-mail estiver vazio não faz verificação
        $sqlmail = $pdo->query("SELECT * FROM clientes WHERE email ='$email' && id != '$id' ");
        if ($sqlmail->rowCount() >= 1){
            $erros++;
            $emailv3="E-mail <b>$email</b> ja existe no sistema!<br />";
        } else { $emailv3 = null; }
    } else { $emailv3 = null; }

    // Verifica se usuario ja existe no sistema
    if (!empty($_POST['usuario']) ) { 
        $sqlusuario = $pdo->query("SELECT * FROM clientes WHERE usuario ='$usuario' && id != '$id' ");
        if ($sqlusuario->rowCount() >= 1){
            $erros++;
            $usuariov2="Usuário <b>$usuario</b> ja existe no sistema!<br />";
        } else { $usuariov2 = null; }
    } else { $usuariov2 = null; }

    // validação dos campos vazios
    if (empty($_POST['nome'])) { 
        $erros++;
        $nomev="Nome vazio, por favor preencha o nome corretamente.<br />"; 
    } else { $nomev = null; }

    if (empty($_POST['email'])) { 
        $erros++;
        $emailv="E-mail vazio, por favor preencha o e-mail corretamente.<br />"; 
    } else { $emailv = null; }

    if (empty($_POST['usuario'])) { 
        $erros++;
        $usuariov="Usuário vazio, por favor preencha o usuário corretamente.<br />"; 
    } else { $usuariov = null; }

    /*verifica email, se digitado incorretamente*/
    $email = str_replace (" ", "", $email);
    $email = str_replace ("/", "", $email);
    $email = str_replace ("@.", "@", $email);
    $email = str_replace (".@", "@", $email);
    $email = str_replace (",", ".", $email);
    $email = str_replace (";", ".", $email);

    if(strlen($email)<8 || substr_count($email, "@")!=1 || substr_count($email, ".")==0) {
        $erros++;
        $emailv2 = "Por favor, digite seu <b>E-mail</b> corretamente.<br />";
    } else { 
        $emailv2 = null; 
    }

    // Se tiver mais de um erro mostra a mensagem de erro
    if($erros >= 1) {
        $msge  = "<h3>Erro na atualização do cadastro!</h3><br>";
        $msge .= $nomev;
        $msge .= $emailv;
        $msge .= $emailv2;
        $msge .= $emailv3;
        $msge .= $usuariov;
        $msge .= $usuariov2;
        echo "<script>document.location.href='minha-conta/?pg=tarologos_admin/view.php&id=$id&msge=$msge'</script>";
    } else {
        // fim da validação
        // se não tiver encontrado erros o cadastro é realizado normalmente.
        //consulta sql - pega as variaveis da url acima e altera do banco de dados - WHERE define de qual linha ou usuário sera alterada.
        $query = $pdo->query("UPDATE clientes SET 
            nome='$nome',
            alias='$alias',
            email='$email',
            status='$status',
            usuario='$usuario',
            especialidade_taro='$especialidade_taro',
            infos='$infos',
            infos2='$infos2',
            logo='$nome_final',
            nome2='$nome2',
            fotoreal='$fotoreal',
            videochamada='$videochamada'
        WHERE id='$id'");
        if (!empty($_POST['senha'])) {
            $query = $pdo->query("UPDATE clientes SET 
            senha='$senha_post'
        WHERE id='$id'");
        }
        $msgs = "Dados Atualizados com sucesso";
        echo "<script>document.location.href='minha-conta/?pg=tarologos_admin/view.php&id=$id&msgs=$msgs'</script>";
        exit(); 
    }
}
?>

<form name="tarologos" id="tarologos" method="post" action=""  class="form-inline"  enctype="multipart/form-data">

<input type="hidden" name="id" value="<?php echo $id; ?>"/>

<div style="margin:10px; display:inline-block;">
    Enviar foto:&nbsp;&nbsp;
    <input type="file" name="arquivo" class="form-control"/>
</div>

<div style="margin:10px; display:inline-block;">
    Nome:&nbsp;&nbsp;
    <input type="text" name="nome" value="<?php echo $nome; ?>" class="form-control"/>
</div>

<div style="margin:10px; display:inline-block;">
    Alias:&nbsp;&nbsp;
    <input type="text" name="alias" value="<?php echo $alias; ?>" class="form-control"/>
</div>

<div style="margin:10px; display:inline-block;">
    Email:&nbsp;&nbsp;
    <input type="text" name="email" value="<?php echo $email; ?>" class="form-control"/>
</div>

<div style="margin:10px; display:inline-block;">
    Status:&nbsp;&nbsp;
    <select name="status" class="form-control">&nbsp;&nbsp;
        <option value="<?php echo $status; ?>"><?php echo $status; ?></option> 
        <option value="ATIVO">ATIVO</option> 
        <option value="CANCELADO">CANCELADO</option>
        <option value="SUSPENSO">SUSPENSO</option>
    </select>
</div><br>

<div style="margin:10px; display:inline-block;">
    Oráculos:&nbsp;&nbsp;
    <input type="especialidade_taro" name="especialidade_taro" value="<?php echo @$especialidade_taro; ?>" style="width: 100%;" class="form-control"/>&nbsp;&nbsp;
</div>

<div style="margin:10px; display:inline-block;">
    Nome Fantasia:&nbsp;&nbsp;
    <input type="text" name="nome2" value="<?php echo $nome2; ?>" class="form-control"/>
</div>

<div style="margin:10px; display:inline-block;">
    Foto Real:&nbsp;&nbsp;
    <input type="text" name="fotoreal" value="<?php echo $fotoreal; ?>" class="form-control"/>
</div>

<div style="margin:10px; display:inline-block;">
    Habilitar VídeoChamadas:&nbsp;&nbsp;
    <select name="videochamada" class="form-control">&nbsp;&nbsp;
        <option value="<?php echo $videochamada; ?>"><?php echo $videochamada; ?></option> 
        <option value="SIM">SIM</option> 
        <option value="NAO">NÃO</option>
    </select>
</div><br>

<div class="row col-md-12 card mb-4">
  <div class="card-body">

        <p>Dados de Login do usuário:</p>

        <div style="display:inline-block; margin-right:10px;">
            *Usuário:&nbsp;&nbsp;
            <input type="text" name="usuario" value="<?php echo $usuario; ?>" class="form-control"/>&nbsp;&nbsp;
        </div>

        <div style="display:inline-block; margin-right:10px;">
            *Senha:&nbsp;&nbsp;
            <input type="password" name="senha" value="" class="form-control"/>&nbsp;&nbsp;
        </div>

    </div>
</div>

<div style="clear:both;"></div>

<p>Descrição:</p>
<div class="row col-md-12 my-3">
    <textarea name="infos" class="form-control" style="width:100%;"><?php echo $infos; ?></textarea>
</div>

<p>Perfil Tarólogo:</p>
<div class="row col-md-12 my-3">
    <textarea name="infos2" class="form-control" style="width:100%;"><?php echo $infos2; ?></textarea>
</div>

<div class="row col-md-12 my-3">
    <p>
        <input class="btn btn-success" type="submit" name="salva" value="Salvar Edição" />
    </p>
</div>
</form>