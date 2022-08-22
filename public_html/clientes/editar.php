<h3 class="text-success">Editar Cliente</h3>
<hr>
<?php
$DataPicker ="SIM";
$TinyMce    ="SIM";
$Mask       ="SIM";
$id = @$_GET['id'];
$executa66 = $pdo->query("SELECT * FROM clientes WHERE id='$id'");
while ($dadoss66 = $executa66->fetch(PDO::FETCH_ASSOC)){ 

    $nome=$dadoss66['nome'];
    $email=$dadoss66['email'];
    $usuario=$dadoss66['usuario'];
    $telefone=$dadoss66['telefone'];
    $receber_email=$dadoss66['receber_email'];
    $conversa_no_email=$dadoss66['conversa_no_email'];
    $endereco=$dadoss66['endereco'];
    $cidade=$dadoss66['cidade'];
    $estado=$dadoss66['estado'];
    $como_nos_conheceu=$dadoss66['como_nos_conheceu'];
    $data_nascimento=$dadoss66['data_nascimento'];
    $data_nascimento = MostraDataCorretamente ($data_nascimento);
}

if ( isset($_POST["salva"]) ) {

    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $email = trim($_POST['email']);
    $usuario = trim($_POST['usuario']);
    $senha_post = md5(trim($_POST['senha']));
    $telefone = trim($_POST['telefone']);
    $receber_email = trim($_POST['receber_email']);
    $endereco           = trim(addslashes($_POST['endereco']));
    $cidade             = trim(addslashes($_POST['cidade']));
    $estado             = trim(addslashes($_POST['estado']));
    $como_nos_conheceu  = trim(addslashes($_POST['como_nos_conheceu']));
    $conversa_no_email  = trim(addslashes($_POST['conversa_no_email']));
    $data_nascimento    = $_POST['data_nascimento'];
    $data_nascimento    = MudaDataGravarBanco ($data_nascimento);

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

    if(strlen($email)<8 || substr_count($email, "@")!=1 || substr_count($email, ".")==0)
    {
        $erros++;
        $emailv2 = "Por favor, digite seu <b>E-mail</b> corretamente.<br />";
    } else { $emailv2 = null; }

    // Se tiver mais de um erro mostra a mensagem de erro
    if($erros >= 1) {
        
        $msge  = "<h3>Erro na atualização do cadastro!</h3><br>";
        $msge .= $nomev;
        $msge .= $emailv;
        $msge .= $emailv2;
        $msge .= $emailv3;
        $msge .= $usuariov;
        $msge .= $usuariov2;
        echo "<script>document.location.href='minha-conta/?pg=clientes/view.php&id=$id&msge=$msge'</script>";

    } else {

        $query = $pdo->query( "UPDATE clientes SET 
            nome='$nome',
            email='$email',
            status='$status',
            usuario='$usuario',
            infos='$infos',
            telefone='$telefone',
            receber_email='$receber_email',
            endereco='$endereco',
            cidade='$cidade',
            estado='$estado',
            como_nos_conheceu='$como_nos_conheceu',
            conversa_no_email='$conversa_no_email',
            data_nascimento='$data_nascimento'
        WHERE id='$id'");
            
        if ( !empty($_POST['senha']) ) {
            $query = $pdo->query( "UPDATE clientes SET 
                senha='$senha_post'
            WHERE id='$id'");
        }

        $msgs = "Dados Atualizados com sucesso";
        echo "<script>document.location.href='minha-conta/?pg=clientes/view.php&id=$id&msgs=$msgs'</script>";
        exit();
            
    } // fechamento validação
} // fechamento gravação
?>

<form name="clientes" id="clientes" method="post" action=""  class="form-inline" >

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
        Sua Data de Nascimento:&nbsp;&nbsp;
        <input type="text" name="data_nascimento" class="form-control" id="datepickerx" data-mask="00-00-0000" value="<?php echo $data_nascimento; ?>" required autocomplete="off" />
    </div>

    <div style="margin:10px; display:inline-block;">
        Telefone com DDD:&nbsp;&nbsp;
        <input type="text" name="telefone" class="form-control" value="<?php echo $telefone; ?>" required/>
    </div>

    <div style="margin:10px; display:inline-block;">
        Receber Novidades por e-mail:&nbsp;&nbsp;
        <select name="receber_email" class="form-control">
            <?php echo '<option value="'.$receber_email.'">'.$receber_email.'</option>'; ?>
            <option value="SIM">Sim</option>
            <option value="NAO">Não</option>
        </select>
    </div>

    <div style="margin:10px; display:inline-block;">
        Receber conversas do chat no meu e-mail?&nbsp;&nbsp;
        <select name="conversa_no_email" class="form-control">
            <?php echo '<option value="'.$conversa_no_email.'">'.$conversa_no_email.'</option>'; ?>
            <option value="SIM">Sim</option>
            <option value="NAO">Não</option>
        </select>
    </div>

    <div style="margin:10px; display:inline-block;">
        Endereço:&nbsp;&nbsp;
        <input type="text" class="form-control" name="endereco" value="<?php echo $endereco; ?>" autofocus />
    </div>

    <div style="margin:10px; display:inline-block;">
        Cidade:&nbsp;&nbsp;
        <input type="text" class="form-control" name="cidade" value="<?php echo $cidade; ?>" autofocus />
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
        <select name="como_nos_conheceu" class="form-control"> <option value="<?php echo $como_nos_conheceu; ?>"><?php echo $como_nos_conheceu; ?></option>
            <option value="ANÚNCIOS SITES">ANÚNCIOS SITES</option>
            <option value="GOOGLE">GOOGLE</option>
            <option value="FACEBOOK">FACEBOOK</option>
            <option value="INDICAÇÃO">INDICAÇÃO</option>
            <option value="JORNAL">JORNAL</option>
            <option value="REVISTA">REVISTA</option>
            <option value="OUTROS">OUTROS</option>
        </select>
    </div>

    <div class="panel panel-default">
      <div class="panel-body">

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

	<div class="row col-12 my-3">
        <input class="btn btn-success mr-3" type="submit" name="salva" value="Atualizar Dados" />
        <input class="btn btn-info" type="button" name="Cancel" value="Cancelar" onclick="window.location = 'minha-conta/?pg=clientes/clientes.php' " /> 
    </div>

</form>