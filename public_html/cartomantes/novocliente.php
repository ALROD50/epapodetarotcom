<?php
$pdo = conexao();
function geraSenhaa($tamanho = 6, $maiusculas = true, $numeros = true, $simbolos = false) {
	$lmin       = 'abcdefghijklmnopqrstuvwxyz';
    $lmai       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $num        = '1234567890';
    $simb       = '!@#$%*-';
    $retorno    = '';
    $caracteres = '';
    $caracteres .= $lmin;
    if ($maiusculas) $caracteres .= $lmai;
    if ($numeros) $caracteres .= $num;
    if ($simbolos) $caracteres .= $simb;
    $len = strlen($caracteres);
    for ($n = 1; $n <= $tamanho; $n++) {
        $rand = mt_rand(1, $len);
        $retorno .= $caracteres[$rand-1];
    }
    return $retorno;
}
// Verifica se e-mail ja existe no sistema  
$email = trim(addslashes($_GET['email']));
$sqlmailx = $pdo->query("SELECT * FROM clientes WHERE email='$email'");
while ($dadoss3=$sqlmailx->fetch(PDO::FETCH_ASSOC)){
  $telefone=$dadoss3['telefone'];
}

if ($sqlmailx->rowCount() >= 1){


    if ($telefone=="") { 
        echo "<script>document.location.href='https://www.epapodetarot.com.br/cartomantes/index.php?pg=page5.php&email=$email'</script>";
        exit();
    }
    
    // o email ja esta cadastrado no sistema não cadastra de novo
    $tarologo = $_SESSION['id_tarologo'];
    $nome = $_SESSION['nome'];
    echo "<script>document.location.href='https://www.epapodetarot.com.br/comprar-consulta/$tarologo/chat/?msgs=Parabéns $nome, você já tem cadastro no site!<br>Vamos%20Realizar%20Sua%20Consulta!'</script>";
    exit();

} else {

	// email novo, realizando o cadastro do cliente
	$data_registro = date("Y-m-d H:i:s");
	$senha         = geraSenhaa();
	$senha2        = md5($senha);
	$nome          = $_SESSION['nome'];
    $nome = ucwords(strtolower($nome));
    $queryInsert   = $pdo->query("INSERT INTO clientes (
        nome,
        email,
        usuario,
        senha,
        aceita_termos_uso,
        receber_email,
        data_registro,
        nivel
    ) VALUES (
        '$nome',
        '$email',
        '$email',
        '$senha2',
        'SIM',
        'SIM',
        '$data_registro',
        'CLIENTE'
    )");
    
    // Faz login
    $id_gerado = $pdo->lastInsertId();
    
    // Logando novo cliente
    $query = $pdo->query("SELECT * FROM clientes WHERE id='$id_gerado' AND status!='CANCELADO' LIMIT 1");
	$resultado = $query->fetch(PDO::FETCH_ASSOC);
	
    #### Sistema de login com Cookies -----------------------------------
    @setcookie("UsuarioID", $resultado['id'], time()+3600*24*30*12*5, "/", NULL);
    @setcookie("UsuarioNome", $resultado['nome'], time()+3600*24*30*12*5, "/", NULL);
    @setcookie("UsuarioNivel", $resultado['nivel'], time()+3600*24*30*12*5, "/", NULL);
    @setcookie("UsuarioStatus", $resultado['status'], time()+3600*24*30*12*5, "/", NULL);
    @$usuario_id     = $_COOKIE["UsuarioID"];
    @$usuario_nome   = $_COOKIE["UsuarioNome"];
    @$usuario_nivel  = $_COOKIE["UsuarioNivel"];
    @$usuario_status = $_COOKIE["UsuarioStatus"];
    #### Sistema de login com Cookies -----------------------------------
	
    //Registrar usuário como online
	$datacompleta2 = date("Y-m-d H:i:s");
	$query = $pdo->query("UPDATE clientes SET 
		online='online',
		time='$datacompleta2'
	WHERE id='$id_gerado'");
	$_SESSION['usuario_id'] = $id_gerado;

    ###################### EMAIL ##############################
    $memaildestinatario = $email;
    $mnomedestinatario  = $nome;
    $massunto           = "Bem Vindo";
    $mmensagem          = "
        <p>Olá <b>$nome</b>, </p>
        Obrigado por se registrar em nosso site, abaixo segue os seus dados de cadastro e login.<br/>
        <strong>NOME:</strong> $nome <br/>
        <strong>E-MAIL:</strong> $email <br/>
        <strong>USUÁRIO:</strong> $email <br/>
        <strong>SENHA:</strong> $senha <br/>
        <br/>
        <br/>
        <b>É Papo de Tarot</b> <br/>
        contato@epapodetarot.com.br <br/>
        Site: www.epapodetarot.com.br <br/>
    ";
    EnviarEmail($memaildestinatario, $mnomedestinatario, $massunto, $mmensagem);
    ###################### EMAIL ##############################

    // Adiciona cliente no autoresponder ID 15
    // ADICIONA OS E-MAILS NA LISTA DA CAMPANHA
    $data_hoje = date('Y-m-d H:i:s');
    $pdo->query("INSERT INTO mail_lista (
        id_camp,
        nome,
        email,
        data
    ) VALUES (
        '15',
        '$nome',
        '$email',
        '$data_hoje'
    )");

    echo "<script>document.location.href='https://www.epapodetarot.com.br/cartomantes/index.php?pg=page5.php&email=$email'</script>";
    exit();

}
?>