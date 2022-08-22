<h3 class="text-success mt-2">Editar Meus Dados</h3>
<br>

<?php
$DataPicker ="SIM";
$TinyMce    ="SIM";
$Mask       ="SIM";
$executa66 = $pdo->query("SELECT * FROM clientes WHERE id='$usuario_id'"); //se conecta no banco e concatena os dados
while ($dadoss66 = $executa66->fetch(PDO::FETCH_ASSOC)){ 
    $id=$dadoss66['id'];
    $nome=$dadoss66['nome'];
    $email=$dadoss66['email'];
    $usuario=$dadoss66['usuario'];
    $especialidade_taro=$dadoss66['especialidade_taro'];
    $infos=$dadoss66['infos'];
    $videochamada=$dadoss66['videochamada'];
}

//Função que mostra os erros da validação
$erros = null;
function ErrosCadastro($nomev, $emailv, $emailv2, $emailv3, $usuariov, $usuariov2) { ?>
    <div class="alert alert-danger" role="alert">
        <button type="button" class="close" data-dismiss="alert">×</button>
          <h4>Erro</h4>
          <p><?php echo $nomev; ?></p>
          <p><?php echo $emailv; ?></p>
          <p><?php echo $emailv2; ?></p>
          <p><?php echo $usuariov; ?></p>
          <p><?php echo $emailv3; ?></p>
          <p><?php echo $usuariov2; ?></p>
    </div> 
<?php  }

// SALVA ALTERAÇÃO
if ( isset($_POST["salva"]) ) {

    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $email = trim($_POST['email']);
    $usuario = trim($_POST['usuario']);
    $senha_post = md5(trim($_POST['senha']));
    $especialidade_taro = $_POST['especialidade_taro'];
    $infos = addslashes($_POST['infos']);
    $videochamada=$_POST['videochamada'];

    // Verifica se e-mail ja existe no sistema
    if (!empty($_POST['email']) ) { // se existem o post email faça o seguinte:
        $sqlmail = $pdo->query("SELECT * FROM clientes WHERE email ='$email' AND id != '$id' ");
        if ($sqlmail->rowCount() >= 1){
            $erros++;
            $emailv3="E-mail <b>$email</b> ja existe no sistema!";
        } else { $emailv3 = null; }
    } else { $emailv3 = null; }

    // Verifica se usuario ja existe no sistema
    if (!empty($_POST['usuario']) ) { 
        $sqlusuario = $pdo->query("SELECT * FROM clientes WHERE usuario ='$usuario' AND id != '$id' ");
        if ($sqlusuario->rowCount() >= 1){
            $erros++;
            $usuariov2="Usuário <b>$usuario</b> ja existe no sistema!";
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

    if(strlen($email)<8 || substr_count($email, "@")!=1 || substr_count($email, ".")==0)
    {
        $erros++;
        $emailv2 = "Por favor, digite seu <b>E-mail</b> corretamente.<br />";
    } else { $emailv2 = null; }

    // Se tiver mais de um erro mostra a mensagem de erro
    if($erros >= 1) {
        ErrosCadastro($nomev, $emailv, $emailv2, $emailv3, $usuariov, $usuariov2);
    } else {

        $query = $pdo->query( "UPDATE clientes SET 
            nome='$nome',
            email='$email',
            usuario='$usuario',
            especialidade_taro='$especialidade_taro',
            infos='$infos',
            videochamada='$videochamada'
        WHERE id='$id'");

        if ( !empty($_POST['senha']) ) {
            $query = $pdo->query( "UPDATE clientes SET 
                senha='$senha_post'
            WHERE id='$id'");
        }
        
        $msgs = "Dados Atualizados com sucesso";
        echo "<script>document.location.href='minha-conta/?pg=area_tarologos/resumo.php&msgs=$msgs'</script>";
                
        }// fechamento validação
} // fechamento gravação
?>

<form name="editar_tarologos" method="post" action="" enctype="multipart/form-data" style="color:#505254;" class="form-inline">

    <input type="hidden" name="id" value="<?php echo $id; ?>"/>

    <div style="margin:10px; display:inline-block;">
        Nome:&nbsp;&nbsp;
        <input type="text" name="nome" value="<?php echo $nome; ?>" class="form-control"/>
    </div>

    <div style="margin:10px; display:inline-block;">
        Email:&nbsp;&nbsp;
        <input type="text" name="email" value="<?php echo $email; ?>" class="form-control"/>
    </div>

    <div style="margin:10px; display:inline-block;">
        Oráculos:&nbsp;&nbsp;
        <input type="especialidade_taro" name="especialidade_taro" value="<?php echo @$especialidade_taro; ?>" class="form-control"/>&nbsp;&nbsp;
    </div>

    <div style="margin:10px; display:inline-block;">
        Habilitar VídeoChamadas:&nbsp;&nbsp;
        <select name="videochamada" class="form-control">&nbsp;&nbsp;
            <option value="<?php echo $videochamada; ?>"><?php echo $videochamada; ?></option> 
            <option value="SIM">SIM</option> 
            <option value="NAO">NÃO</option>
        </select>
    </div>

    <div style="clear:both;"></div>

    <div class="row card  col-md-12">
      <div class="card-body">
            <p>Dados de Login do usuário:</p>

            <div style="float:left; margin-right:10px;">
                *Usuário:&nbsp;&nbsp;
                <input type="text" name="usuario" value="<?php echo $usuario; ?>" class="form-control"/>&nbsp;&nbsp;
            </div>

            <div style="float:left; margin-right:10px;">
                *Senha:&nbsp;&nbsp;
                <input type="password" name="senha" value="" class="form-control"/>&nbsp;&nbsp;
            </div>
        </div>
    </div>

    <div style="clear:both;"></div>

    <div class="row mt-3 col-md-12">
        <p>Descrição</p>
        <textarea name="infos" class="form-control"/><?php echo $infos; ?></textarea>
    </div>

    <div style="clear:both;"></div>

    <div class="row mt-3 col-md-12">
    	<p>
            <input class="btn btn-success" type="submit" name="salva" value="Atualizar Dados" />
        </p>
    </div>

</form>