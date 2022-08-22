<h3 class="text-success">Editar Meus Dados</h3>
<hr>
<?php
$DataPicker ="SIM";
$TinyMce    ="SIM";
$Mask       ="SIM";
$id=$usuario_id;
$dadoss ="SELECT * FROM clientes WHERE id='$id'";
$executa=$pdo->query( $dadoss); 

while ($dadoss= $executa->fetch(PDO::FETCH_ASSOC)){ 

  $id=$dadoss['id'];
  $nome=$dadoss['nome'];
  $email=$dadoss['email'];
  $usuario=$dadoss['usuario'];
  // $conversa_no_email=$dadoss['conversa_no_email'];
  $telefone=$dadoss['telefone'];
  $skype=$dadoss['skype'];
  $endereco=$dadoss['endereco'];
  $cidade=$dadoss['cidade'];
  $estado=$dadoss['estado'];
  $como_nos_conheceu=$dadoss['como_nos_conheceu'];
  $receber_email=$dadoss['receber_email'];
  $numero=$dadoss['numero'];
  $cep=$dadoss['cep'];
  $complemento=$dadoss['complemento'];
  $bairro=$dadoss['bairro'];
  $cpf=$dadoss['cpf'];
  $data_nascimento=$dadoss['data_nascimento'];
  $data_nascimento = date("d-m-Y", strtotime("$data_nascimento"));
  if ($data_nascimento == "30-11--0001") {
    $data_nascimento = "00-00-0000";
  }
}
?>
<?php 
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
?>
<?php // SALVA ALTERAÇÃO
if ( isset($_POST["salva"]) ) {

$id                 = $_POST['id'];
$nome               = trim(addslashes($_POST['nome']));
$email              = trim(addslashes($_POST['email']));
$usuario            = trim(addslashes($_POST['usuario']));
$senha_post         = md5(trim($_POST['senha']));
@$aceita_termos_uso = $_POST['aceita_termos_uso'];
// @$conversa_no_email = $_POST['conversa_no_email'];
$telefone           = trim(addslashes($_POST['telefone']));
@$data_nascimento   = $_POST['data_nascimento'];
@$data_nascimento   = date("Y-m-d", strtotime("$data_nascimento"));
$endereco       = trim(addslashes($_POST['endereco']));
$cidade         = trim(addslashes($_POST['cidade']));
$estado         = trim(addslashes($_POST['estado']));
$como_nos_conheceu = trim(addslashes($_POST['como_nos_conheceu']));
$numero = trim(addslashes($_POST['numero']));
$cep = trim(addslashes($_POST['cep']));
$complemento = trim(addslashes($_POST['complemento']));
$bairro = trim(addslashes($_POST['bairro']));
$cpf = trim(addslashes($_POST['cpf']));

// Verifica se e-mail ja existe no sistema
if (!empty($_POST['email']) ) { // se o campo e-mail estiver vazio não faz verificação
    $sqlmail = $pdo->query("SELECT * FROM clientes WHERE email ='$email' && id != '$id' ");
    if ($sqlmail->rowCount() >= 1){
        $erros++;
        $emailv3="E-mail <b>$email</b> ja existe no sistema!";
    } else { $emailv3 = null; }
} else { $emailv3 = null; }

// Verifica se usuario ja existe no sistema
if (!empty($_POST['usuario']) ) { 
    $sqlusuario = $pdo->query("SELECT * FROM clientes WHERE usuario ='$usuario' && id != '$id' ");
    if ($sqlusuario->rowCount() >= 1){
        $erros++;
        $usuariov2="Usuário <b>$usuario</b> ja existe no sistema!";
    } else { $usuariov2 = null; }
} else { $usuariov2 = null; }

// validação dos campos vazios 
if (empty($_POST['nome'])) { 
    $erros++;
    $nomev="Nome vazio, por favor preencha o nome corretamente."; 
} else { $nomev = null; }

if (empty($_POST['email'])) { 
    $erros++;
    $emailv="E-mail vazio, por favor preencha o e-mail corretamente."; 
} else { $emailv = null; }

if (empty($_POST['usuario'])) { 
    $erros++;
    $usuariov="Usuário vazio, por favor preencha o usuário corretamente."; 
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
} else { $emailv2 = null; }

// Se tiver mais de um erro mostra a mensagem de erro
if($erros >= 1) {
  ErrosCadastro($nomev, $emailv, $emailv2, $emailv3, $usuariov, $usuariov2);
} else {

  $query = $pdo->query( "UPDATE clientes SET 
    nome='$nome',
    email='$email',
    usuario='$usuario',
    telefone='$telefone',
    receber_email='$receber_email',
    endereco='$endereco',
    cidade='$cidade',
    estado='$estado',
    como_nos_conheceu='$como_nos_conheceu',
    data_nascimento='$data_nascimento',
    numero='$numero',
    cep='$cep',
    complemento='$complemento',
    bairro='$bairro',
    cpf='$cpf'
  WHERE id='$id'");

  if ( !empty($_POST['senha']) ) {
      
    $query = $pdo->query( "UPDATE clientes SET 
      senha='$senha_post'
    WHERE id='$id'");
  }
      
  $msgs = "Dados Atualizados com sucesso";
  echo "<script>document.location.href='minha-conta/?pg=area_cliente/resumo.php&msgs=$msgs'</script>";
  exit();
  }
}
?>
<form name="clientes" method="post" action="" enctype="multipart/form-data" style="color:#505254;" class="form-inline">

<input type="hidden" name="id" value="<?php echo $id; ?>"/>

<div class="row">

<div style="margin:10px; display:inline-block;">
    Seu Nome Completo:&nbsp;&nbsp;
    <input type="text" name="nome" class="form-control" value="<?php echo $nome; ?>" required />
</div>

<div style="margin:10px; display:inline-block;">
    Seu Melhor Email:&nbsp;&nbsp;
    <input type="text" name="email" class="form-control" value="<?php echo $email; ?>" required/>
</div>

<div style="margin:10px; display:inline-block;">
    Sua Data de Nascimento:&nbsp;&nbsp;
    <input type="text" name="data_nascimento" class="form-control" data-mask="00-00-0000" placeholder="00-00-0000" value="<?php echo $data_nascimento; ?>" required autocomplete="off" />
</div>

<div style="margin:10px; display:inline-block;">
  CPF:&nbsp;&nbsp;
  <input type="text" class="form-control cpf"  name="cpf" value="<?php echo $cpf; ?>" required />
</div>

<div style="margin:10px; display:inline-block;">
    Telefone com DDD:&nbsp;&nbsp;
    <input type="text" name="telefone" class="form-control cel_with_ddd" value="<?php echo $telefone; ?>" required/>
</div>

<div style="margin:10px; display:inline-block;">
    Receber novidades por e-mail:&nbsp;&nbsp;
    <input type="text" name="receber_email" class="form-control" value="<?php echo $receber_email; ?>" required/>
</div>

<div style="margin:10px; display:inline-block;">
  CEP:&nbsp;&nbsp;
  <input type="text" class="form-control cep" name="cep" id="cep" value="<?php echo $cep; ?>" required  />
</div>

<div style="margin:10px; display:inline-block;">
    Endereço:&nbsp;&nbsp;
    <input type="text" class="form-control"  name="endereco" value="<?php echo $endereco; ?>" required />
</div>

<div style="margin:10px; display:inline-block;">
    Número:&nbsp;&nbsp;
    <input type="text" class="form-control"  name="numero" value="<?php echo $numero; ?>" required />
</div>

<div style="margin:10px; display:inline-block;">
    Complemento:&nbsp;&nbsp;
    <input type="text" class="form-control"  name="complemento" value="<?php echo $complemento; ?>" required />
</div>

<div style="margin:10px; display:inline-block;">
    Bairro:&nbsp;&nbsp;
    <input type="text" class="form-control"  name="bairro" value="<?php echo $bairro; ?>" required />
</div>

<div style="margin:10px; display:inline-block;">
    Cidade:&nbsp;&nbsp;
    <input type="text" class="form-control"  name="cidade" value="<?php echo $cidade; ?>" required />
</div>

<div style="margin:10px; display:inline-block;">
    Estado:&nbsp;&nbsp;
    <select name="estado" class="form-control"> <option value="<?php echo $estado; ?>"><?php echo $estado; ?></option>
        <option value="AC">Acre</option> 
        <option value="AL">Alagoas</option> 
        <option value="AM">Amazonas</option> 
        <option value="AP">Amapá</option> 
        <option value="BA">Bahia</option> 
        <option value="CE">Ceará</option> 
        <option value="DF">Distrito Federal</option> 
        <option value="ES">Espírito Santo</option> 
        <option value="GO">Goiás</option> 
        <option value="MA">Maranhão</option> 
        <option value="MT">Mato Grosso</option> 
        <option value="MS">Mato Grosso do Sul</option> 
        <option value="MG">Minas Gerais</option> 
        <option value="PA">Pará</option> 
        <option value="PB">Paraíba</option> 
        <option value="PR">Paraná</option> 
        <option value="PE">Pernambuco</option> 
        <option value="PI">Piauí</option> 
        <option value="RJ">Rio de Janeiro</option> 
        <option value="RN">Rio Grande do Norte</option> 
        <option value="RO">Rondônia</option> 
        <option value="RS">Rio Grande do Sul</option> 
        <option value="RR">Roraima</option> 
        <option value="SC">Santa Catarina</option> 
        <option value="SE">Sergipe</option> 
        <option value="SP">São Paulo</option> 
        <option value="TO">Tocantins</option>
    </select>
</div>

<div style="margin:10px; display:inline-block;">
    Como nos conheceu?&nbsp;&nbsp;
    <select name="como_nos_conheceu" class="form-control" required> <option value="<?php echo $como_nos_conheceu; ?>"><?php echo $como_nos_conheceu; ?></option>
        <option value="Anúncios Google">Anúncios Google</option>
        <option value="Anúncios Facebook">Anúncios Facebook</option>
        <option value="Instagram">Instagram</option>
        <option value="Google">Google</option>
        <option value="Youtube">Youtube</option>
        <option value="E-mail">E-mail</option>
        <option value="Indicação">Indicação</option>
        <option value="Outro">Outro</option>
    </select>
</div>

<div style="clear:both;"></div>

<div class="row card col-md-12">
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

<div class="row mt-3  col-md-12">
    <input class="btn btn-success" type="submit" name="salva" value="Salvar Edição" />
</div>

</form>