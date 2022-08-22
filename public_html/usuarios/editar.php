<h3 class="text-success">Editar Usuário do Sistema</h3>
<?php
$id = @$_GET['id'];
$executa66 = $pdo->query("SELECT * FROM clientes WHERE id='$id'");
while ($dadoss66 = $executa66->fetch(PDO::FETCH_ASSOC)){ 

$nome=$dadoss66['nome'];
$data_registro=$dadoss66['data_registro'];
$new_data_registro = date("d-m-Y", strtotime("$data_registro"));
$email=$dadoss66['email'];
$email = trim($email);
$status=$dadoss66['status'];
$usuario=$dadoss66['usuario'];
$usuario = trim($usuario);
$nivel=$dadoss66['nivel'];
}
?>

<?php // SALVA ALTERAÇÃO
if ( isset($_POST["salva"]) ) {

$id = $_POST['id'];
$nome = $_POST['nome'];
$email = trim($_POST['email']);
$usuario = trim($_POST['usuario']);
$senha_post = md5(trim($_POST['senha']));
$status = $_POST['status'];
$nivel = $_POST['nivel'];

// Verifica se e-mail ja existe no sistema
$erros = null;

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

if(strlen($email)<8 || substr_count($email, "@")!=1 || substr_count($email, ".")==0)
{
$erros++;
$emailv2 = "Por favor, digite seu <b>E-mail</b> corretamente.<br />";
} else { $emailv2 = null; }

// Se tiver mais de um erro mostra a mensagem de erro
if($erros >= 1) {
    
    $msge  = $nomev;
    $msge .= $emailv;
    $msge .= $emailv2;
    $msge .= $emailv3;
    $msge .= $usuariov;
    $msge .= $usuariov2;
    echo "<script>document.location.href='minha-conta/?pg=usuarios/usuarios.php&msge=$msge'</script>";

} else {

    $data = date('Y-m-d');

    $query = $pdo->query("UPDATE clientes SET 

    nome='$nome',
    data_registro='$data',
    email='$email',
    status='$status',
    usuario='$usuario',
    nivel='$nivel'

    WHERE id='$id'");
    if ( !empty($_POST['senha']) ) {
            
        $query = $pdo->query("UPDATE clientes SET 
        senha='$senha_post'
    WHERE id='$id'");
    }
    
    $msgs = "Dados Atualizados com sucesso";
    echo "<script>document.location.href='minha-conta/?pg=usuarios/usuarios.php&msgs=$msgs'</script>";
    exit();
            
    } // fechamento validação
} // fechamento gravação
?>

<form name="clientes" id="clientes" method="post" action=""  class="form-inline"  enctype="multipart/form-data">

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
    *Status:&nbsp;&nbsp;
    <select name="status" class="form-control">&nbsp;&nbsp;
    <?php echo '<option value="'.$status.'">'.$status.'</option>'; ?>
    <option value="ATIVO">ATIVO</option>
    <option value="CANCELADO">CANCELADO</option>
    <option value="SUSPENSO">SUSPENSO</option>
    </select>
</div>

<div class="row col-md-12 my-3 card">
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

        <div style="float:left; margin-right:10px;">
            *Nível:&nbsp;&nbsp;
            <select name="nivel" class="form-control">&nbsp;&nbsp;
            <?php echo '<option value="'.$nivel.'">'.$nivel.'</option>'; ?> 
            <option value="ADMIN">ADMIN</option>
            </select>
        </div>

    </div>
</div>

    <div class="row col-md-12 my-3">
    	<p>
            <input class="btn btn-success" type="submit" name="salva" value="Salvar Edição" />
            <input class="btn btn-info" type="button" name="Cancel" value="Cancelar" onclick="window.location = 'minha-conta/?pg=usuarios/usuarios.php' " /> 
        </p>
    </div>
</form>