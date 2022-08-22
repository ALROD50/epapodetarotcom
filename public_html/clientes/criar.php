<h3 class="text-success">Cadastrar Novo Cliente</h3>
<hr>
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

if(isset($_POST['envia'])) {

    $data_registro =  date("Y-m-d H:i:s");
    $new_data_registro = date("y-m-d", strtotime("$data_registro"));
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $email = trim($email);
    $telefone = $_POST['telefone'];
    @$novidades = $_POST['novidades'];
    @$conversa_no_email = $_POST['conversa_no_email'];
    $usuario = $_POST['usuario'];
    $usuario = trim($usuario);
    $senha = $_POST['senha'];
    $senha = trim($senha);
    $senha2 = md5($senha);

    if ($conversa_no_email == '') {
       $conversa_no_email = "SIM";
    }

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

    if(strlen($email)<8 || substr_count($email, "@")!=1 || substr_count($email, ".")==0) {
        $erros++;
        $emailv2 = "Por favor, digite seu <b>E-mail</b> corretamente.<br />";
    } else { 
        $emailv2 = null; 
    }

    // Se tiver mais de um erro mostra a mensagem de erro
    if($erros >= 1) {
        ErrosCadastro($nomev, $emailv, $emailv2, $emailv3, $usuariov, $usuariov2, $senhav);
    } else {

        // fim da validação
        // se não tiver encontrado erros o cadastro é realizado normalmente.
     
        $pdo->query( "INSERT INTO clientes (
            nome,
            email,
            usuario,
            senha,
            receber_email,
            aceita_termos_uso,
            conversa_no_email,
            data_registro,
            telefone,
            nivel
        ) VALUES (
            '$nome',
            '$email',
            '$usuario',
            '$senha2',
            '$novidades',
            'SIM',
            '$conversa_no_email',
            '$data_registro',
            '$telefone',
            'CLIENTE'
        )");

        $msgs="Cliente Criado Com Sucesso!";
        echo "<script>document.location.href='minha-conta/?pg=clientes/clientes.php&msgs=$msgs'</script>";

    } // fechamento validação
} // fechamento gravação

?>
<span class="small">(*) Preenchimento obrigatório.</span>
<p>

<form name="clientes" method="post" action="" class="form-inline" enctype="multipart/form-data">

    <div style="margin:10px; display:inline-block;">
        *Nome:&nbsp;&nbsp;
        <input type="text" name="nome" value="<?php echo @$nome; ?>" class="form-control"/>
    </div>

    <div style="margin:10px; display:inline-block;">
        *Email:&nbsp;&nbsp;
        <input type="text" name="email" value="<?php echo @$email; ?>" class="form-control"/>
    </div>

    <div style="margin:10px; display:inline-block;">
        *Telefone com DDD:&nbsp;&nbsp;
        <input type="text" name="telefone" value="<?php echo @$telefone; ?>" class="form-control"/>
    </div>

    <div style="margin:10px; display:inline-block;">
        *Receber Novidades por E-mail&nbsp;&nbsp;
        <input type="checkbox" class=""  name="novidades" value="SIM" class="form-control"/>
    </div>

    <div style="margin:10px; display:inline-block;">
        *Não quero receber as consultas por e-mail:&nbsp;&nbsp;
        <input type="checkbox" class=""  name="conversa_no_email" value="NAO" class="form-control"/>
    </div>

    <div class="panel panel-default">
      <div class="panel-body">

        <p>Dados de Login do usuário:</p>

        <div style="float:left; margin-right:10px;">
            *Usuário:&nbsp;&nbsp;
            <input type="text" name="usuario" value="<?php echo @$usuario; ?>" class="form-control"/>&nbsp;&nbsp;
        </div>

        <div style="float:left; margin-right:10px;">
            *Senha:&nbsp;&nbsp;
            <input type="password" name="senha" value="<?php echo @$senha; ?>" class="form-control"/>&nbsp;&nbsp;
        </div>

      </div>
    </div>

    <input class="btn btn-primary" type="submit" name="envia" value="Criar Cliente"/>
    <input class="btn btn-info" type="button" name="Cancel" value="Cancelar Cadastro" onclick="window.history.back();" /> 
</form>

<script>
    $('.voltar').click(function() {
    history.back()
});
</script>