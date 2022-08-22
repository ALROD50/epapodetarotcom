<h3 class="text-success">Criar Usuário Administrativo</h3>
<?php 
//Função que mostra os erros da validação
$erros = null;
function ErrosCadastro($nomev, $emailv, $emailv2, $emailv3, $usuariov, $usuariov2, $senhav) { ?>
    <div class="alert alert-danger" role="alert">
        <button type="button" class="close" data-dismiss="alert">×</button>
          <h4>Info - Alerta!</h4>
          <p><?php echo $nomev; ?></p>
          <p><?php echo $emailv; ?></p>
          <p><?php echo $emailv2; ?></p>
          <p><?php echo $usuariov; ?></p>
          <p><?php echo $senhav; ?></p>
          <p><?php echo $emailv3; ?></p>
          <p><?php echo $usuariov2; ?></p>
    </div> 
<?php  }

if(isset($_POST['envia'])){

$nome = $_POST['nome'];
$email = trim($_POST['email']);
$usuario = trim($_POST['usuario']);
$senha_post = md5(trim($_POST['senha']));
$status = $_POST['status'];
$nivel = $_POST['nivel'];

// Verifica se e-mail ja existe no sistema
if (!empty($_POST['email']) ) { // se o campo e-mail estiver vazio não faz verificação
    $sqlmail = $pdo->query("SELECT * FROM clientes WHERE email ='$email' ");
    if ($sqlmail->rowCount() >= 1){
        $erros++;
        $emailv3="E-mail <b>$email</b> ja existe no sistema!";
    } else { $emailv3 = null; }
} else { $emailv3 = null; }

// Verifica se usuario ja existe no sistema
if (!empty($_POST['usuario']) ) { 
    $sqlusuario = $pdo->query("SELECT * FROM clientes WHERE usuario ='$usuario' ");
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

if (empty($_POST['senha'])) { 
    $erros++;
    $senhav="Senha vazio, por favor preencha a senha corretamente."; 
} else { $senhav = null; }

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
    ErrosCadastro($nomev, $emailv, $emailv2, $emailv3, $usuariov, $usuariov2, $senhav);
} else {

// fim da validação
// se não tiver encontrado erros o cadastro é realizado normalmente.

$data = date('Y-m-d');
 
$q = $pdo->query("INSERT INTO clientes (
    nome,
    data_registro,
    email,
    status,
    usuario,
    senha,
    nivel
    ) VALUES (
    '$nome',
    '$data',
    '$email',
    '$status',
    '$usuario',
    '$senha',
    '$nivel'
    )");
    $msgs="Usuário Criado Com Sucesso!";
    echo "<script>document.location.href='minha-conta/?pg=usuarios/usuarios.php&msgs=$msgs'</script>";

    } // fechamento validação
} // fechamento gravação

?>
<span class="small">(*) Preenchimento obrigatório.</span>
<p>

<form name="clientes" method="post" action="" class="form-inline" enctype="multipart/form-data">

<div style="margin:10px; display:inline-block;">
    Nome:&nbsp;&nbsp;
    <input type="text" name="nome" value="<?php echo @$nome; ?>" class="form-control"/>
</div>

<div style="margin:10px; display:inline-block;">
    Email:&nbsp;&nbsp;
    <input type="text" name="email" value="<?php echo @$email; ?>" class="form-control"/>
</div>

<div style="margin:10px; display:inline-block;">
    *Status:&nbsp;&nbsp;
    <select name="status" class="form-control">&nbsp;&nbsp;
    <option value="ATIVO">ATIVO</option>
    </select>
</div>

<div class="row col-md-12 my-3 card">
  <div class="card-body">

    <p>Dados de Login do usuário:</p>

    <div style="float:left; margin-right:10px;">
        *Usuário:&nbsp;&nbsp;
        <input type="text" name="usuario" value="<?php echo @$usuario; ?>" class="form-control"/>&nbsp;&nbsp;
    </div>

    <div style="float:left; margin-right:10px;">
        *Senha:&nbsp;&nbsp;
        <input type="password" name="senha" value="" class="form-control"/>&nbsp;&nbsp;
    </div>

    <div style="float:left; margin-right:10px;">
        *Nível:&nbsp;&nbsp;
        <select name="nivel" class="form-control">&nbsp;&nbsp;
            <option value="ADMIN">ADMIN</option>
        </select>
    </div>
  </div>
</div>

<div class="row col-md-12 my-3">
    <input class="btn btn-primary mr-2" type="submit" name="envia" value="Criar Usuário"/>

    <input class="btn btn-info" type="button" name="Cancel" value="Cancelar" onclick="window.history.back();" /> 
</div>

</form>

<script>
    $('.voltar').click(function() {
    history.back()
});
</script>