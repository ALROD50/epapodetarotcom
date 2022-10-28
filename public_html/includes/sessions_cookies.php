<?php 
date_default_timezone_set("Brazil/East"); // seta configurações fusuhorario para Brasil
ini_set ('default_charset', 'UTF-8'); // seta o php em UTF 8
$pdo=conexao();

#### Recupera Cookies -----------------------------------
@$usuario_id     = $_COOKIE["UsuarioID"];
@$usuario_nome   = $_COOKIE["UsuarioNome"];
@$usuario_nivel  = $_COOKIE["UsuarioNivel"];
@$usuario_status = $_COOKIE["UsuarioStatus"];
#### Recupera Cookies -----------------------------------

// Cria a Sessão de Produtos No Carrinho Caso Não Exista
if (!isset($_SESSION['id_cliente_carrinho'])) {
    $_SESSION['id_cliente_carrinho'] = uniqid();
    $id_cliente_carrinho_session = $_SESSION['id_cliente_carrinho'];
} else {
    $id_cliente_carrinho_session = $_SESSION['id_cliente_carrinho'];
}

// var_dump($_COOKIE);
// exit();

$server             = $_SERVER['SERVER_NAME'];
$endereco           = $_SERVER ['REQUEST_URI'];
$endereco_atual     = "https://" . $server . $endereco;
$endereco           = array_filter(explode('/',$endereco));
$URLSESSAO          = @$endereco[1];

if(isset($_POST['loginsite'])){

    // Tira os espaços das variaveis
    $usuario = trim($_POST['usuario']);
    $senha = trim($_POST['senha']);
    $senha2 = md5($senha);
    $erros = null;

    // Captcha ###############################################################
        $url = "https://www.google.com/recaptcha/api/siteverify";
        $data = [
          'secret' => "6LfIKpwhAAAAANDvMK29MCEGmhSDJ3s7RAxHCERj",
          'response' => $_POST['token2'],
           // 'remoteip' => $_SERVER['REMOTE_ADDR']
        ];
        $options = array(
            'http' => array(
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($data)
          )
        );
        $context  = stream_context_create($options);
        $response = file_get_contents($url, false, $context);
        $res = json_decode($response, true);
        if($res['success'] == true) {
          // OK, Your inquiry successfully submitted
          $captchav = null;
        } else {
          $erros++;
          $captchav="Você não é um humano!";
        }
    // Captcha ###############################################################


    if ($erros >= 1) {

        echo "<script>document.location.href='$URLSESSAO/?msge=You are not a human.'</script>";

    } else {

        // Validação do usuário/senha digitados
        $sql = "SELECT * FROM clientes WHERE usuario='$usuario' AND senha='$senha2' AND status!='CANCELADO' LIMIT 1";
        $query = $pdo->query($sql);

        if ($query->rowCount() != 1) {

            echo "<script>document.location.href='$URLSESSAO/?msge=Nome de usuário ou senha inválida!'</script>";

        } else {
       
            $resultado = $query->fetch(PDO::FETCH_ASSOC);
            date_default_timezone_set("Brazil/East");
            #### Sistema de login com Cookies -----------------------------------
            setcookie("UsuarioID", $resultado['id'], time()+3600*24*30*12*5, "/", NULL);
            setcookie("UsuarioNome", $resultado['nome'], time()+3600*24*30*12*5, "/", NULL);
            setcookie("UsuarioNivel", $resultado['nivel'], time()+3600*24*30*12*5, "/", NULL);
            setcookie("UsuarioStatus", $resultado['status'], time()+3600*24*30*12*5, "/", NULL);
            #### Sistema de login com Cookies -----------------------------------

            //Registrar usuário como online
            $usuario_id     = $resultado['id'];
            $usuario_nivel  = $resultado['nivel'];
            $usuario_status = $resultado['status'];
            $datacompleta2  = date("Y-m-d H:i:s");
            $queryxx = $pdo->query("UPDATE clientes SET 
              online='online',
              time='$datacompleta2'
            WHERE id='$usuario_id'");

            // Acessando o sistema
            $sql_globais = $pdo->query("SELECT * FROM clientes WHERE id='$usuario_id' LIMIT 1"); 
            while ($dados_globais=$sql_globais->fetch(PDO::FETCH_ASSOC)){
                $globais_nome=$dados_globais['nome'];
                $globais_email=$dados_globais['email'];
            }
            $datacompletahoje = date("d-m-Y H:i:s");

            // Redireciona o visitante
            if ($usuario_nivel=="CLIENTE"){

                if ($URLSESSAO=='carrinho-compras') {
                    echo "<script>document.location.href='https://www.epapodetarot.com.br/carrinho-compras/?msgs=Você foi logado com sucesso!'</script>";
                } elseif ($URLSESSAO=='comprar-consulta') {
                    echo "<script>document.location.href='https://www.epapodetarot.com.br/comprar-consulta/chat/?msgs=Você foi logado com sucesso!'</script>";
                } else {
                    echo "<script>document.location.href='https://www.epapodetarot.com.br/tarologos/?msgs=Você foi logado com sucesso!'</script>";
                }
              
            } else {
              echo "<script>document.location.href='https://www.epapodetarot.com.br/minha-conta/?msgs=Você foi logado com sucesso!'</script>";
            }
        }
    }
}

if(isset($_POST['enviacadastrar'])) {

    // Pega os posts e gera as variaveis
    $nome               = trim(addslashes($_POST['nome']));
    $email              = trim(addslashes($_POST['email']));
    $senha              = trim(addslashes($_POST['senha']));
    $senha2             = md5($senha);
    $data_nascimento    = trim(addslashes($_POST['data_nascimento']));
    @$data_nascimento   = date("Y-m-d", strtotime("$data_nascimento"));
    $whatsapp           = trim(addslashes($_POST['whatsapp']));
    $erros = null;

    // Captcha ###############################################################
        $url = "https://www.google.com/recaptcha/api/siteverify";
        $data = [
          'secret' => "6LfIKpwhAAAAANDvMK29MCEGmhSDJ3s7RAxHCERj",
          'response' => $_POST['token'],
                  // 'remoteip' => $_SERVER['REMOTE_ADDR']
        ];

        $options = array(
          'http' => array(
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($data)
          )
        );

        $context  = stream_context_create($options);
        $response = file_get_contents($url, false, $context);
        $res = json_decode($response, true);

        if($res['success'] == true) {
            // OK, Your inquiry successfully submitted
            $captchav = null;
        } else {
            $erros++;
            $captchav="You are not a human.";
        }
    // Captcha ###############################################################

    // Nome e Sobrenome Teste
    $nome = preg_replace("/[][><}{)(:;,!?*%~^`&#@]/", "", $nome);
    $regex = "/^[A-zÀ-ú]{2,}\ [A-zÀ-ú]{2,}/";
    $resultado = preg_match($regex, $nome);
    if (!$resultado) { 
      $erros++;
      $nomev="Por favor preencha o nome e sobrenome corretamente."; 
    } else { $nomev = null; }

    // Verifica se e-mail ja existe no sistema
    if (!empty($_POST['email']) ) { // se o campo e-mail estiver vazio não faz verificação

      $sqlmail = $pdo->query("SELECT * FROM clientes WHERE email ='$email' ");
      if ($sqlmail->rowCount() >= 1){
        $erros++;
        $emailv3="E-mail <b>$email</b> ja existe no sistema!";
      } else { $emailv3 = null; }
    } else {$emailv3 = null;}

    if (empty($_POST['email'])) { 
      $erros++;
      $emailv="E-mail vazio, por favor preencha o e-mail corretamente."; 
    } else { $emailv = null; }

    if (empty($_POST['senha'])) { 
      $erros++;
      $senhav="Senha vazio, por favor preencha a senha corretamente."; 
    } else { $senhav = null; }

    if (empty($_POST['whatsapp'])) { 
        $erros++;
        $whatsappv="Telefone vazio, por favor preencha o celular corretamente."; 
    } else { $whatsappv = null; }

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
      $emailv2 = "Por favor, digite seu <b>E-mail</b> corretamente.";
    } else {
      $emailv2 = null;
    }

    // Se tiver mais de um erro mostra a mensagem de erro
    if($erros >= 1) {

        if (!empty($nomev)) { echo "<script>document.location.href='https://www.epapodetarot.com.br/$URLSESSAO/?msge=Nome de usuário ou senha inválidos!'</script>"; }
        if (!empty($emailv)) { echo "<script>document.location.href='https://www.epapodetarot.com.br/$URLSESSAO/?msge=E-mail vazio, por favor preencha o e-mail corretamente.'</script>"; }
        if (!empty($emailv2)) { echo "<script>document.location.href='https://www.epapodetarot.com.br/$URLSESSAO/?msge=Por favor, digite seu <b>E-mail</b> corretamente.'</script>"; }
        if (!empty($emailv3)) { echo "<script>document.location.href='https://www.epapodetarot.com.br/$URLSESSAO/?msge=E-mail <b>$email</b> ja existe no sistema!'</script>"; }
        if (!empty($senhav)) { echo "<script>document.location.href='https://www.epapodetarot.com.br/$URLSESSAO/?msge=Senha vazio, por favor preencha a senha corretamente.'</script>"; }
        if (!empty($whatsappv)) { echo"<script>document.location.href='https://www.epapodetarot.com.br/$URLSESSAO/?msge=Telefone vazio, por favor preencha o celular corretamente'</script>"; }
        if (!empty($captchav)) { echo"<script>document.location.href='https://www.epapodetarot.com.br/$URLSESSAO/?msge=You are not a human.'</script>"; }

    } else {

        $data_registro = date("Y-m-d H:i:s");
        $queryInsert = $pdo->query("INSERT INTO clientes (
            nome,
            email,
            usuario,
            senha,
            receber_email,
            aceita_termos_uso,
            data_registro,
            nivel,
            conversa_no_email,
            data_nascimento,
            telefone
        ) VALUES (
            '$nome',
            '$email',
            '$email',
            '$senha2',
            'SIM',
            'SIM',
            '$data_registro',
            'CLIENTE',
            'SIM',
            '$data_nascimento',
            '$whatsapp'
        )");
        $id_gerado = $pdo->lastInsertId();

        /* -----------------Mandando E-mail---------------------- */
            $seuemail = $email;/*email de destino*/
            $assunto  = "Bem Vindo";/*assunto*/

            /*Configuramos os cabe?alhos do e-mail*/
            $headers  = "MIME-Version: 1.0 \r\n";
            $headers .= "Content-type: text/html; charset=utf-8 \r\n";
            $headers .= "From: epapodetarot@gmail.com \r\n";
            $headers .= "Bcc: epapodetarot@gmail.com \r\n";

            /*Configuramos o conte?do do e-mail*/
            $conteudo  = "Obrigado por se registrar em nosso site, abaixo segue os seus dados de cadastro e login.<br/>";
            $conteudo .= "<br/>";
            $conteudo .= "Dados do acesso: <br/>";
            $conteudo .= "<strong>NOME:</strong> $nome<br/>";
            $conteudo .= "<strong>USUÁRIO:</strong> $email<br/>";
            $conteudo .= "<strong>E-MAIL:</strong> $email<br/>";
            $conteudo .= "<br/>";
            $conteudo .= "<br/>";
            $conteudo .= "www.epapodetarot.com.br<br/>";

            /*Enviando o e-mail...*/
            //$enviando = mail($seuemail, $assunto, $conteudo, $headers);
        /* -----------------Mandando E-mail---------------------- */

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

        // Adicionar crédito grátis
        // $data_hoje = date('Y-m-d H:i:s');
        // $reference = uniqid();
        // $q = $pdo->query("INSERT INTO controle (
        //     id_nome_cliente,
        //     minutos,
        //     valor,
        //     minutos_dispo,
        //     cod_pagamento,
        //     status,
        //     data,
        //     metodo
        // ) VALUES (
        //     '$id_gerado',
        //     '5 Minutos',
        //     '0.00',
        //     '5',
        //     '$reference', 
        //     'PAGO', 
        //     '$data_hoje',
        //     'Bônus'
        // )");

        // Logando novo cliente
        $sql = "SELECT * FROM clientes WHERE id = '$id_gerado' AND status != 'CANCELADO' LIMIT 1";
        $query = $pdo->query($sql);
        if ($query->rowCount() < 1) {

            echo "<script>document.location.href='$URLSESSAO/?msge=Nome de usuário inválido!'</script>";

        } else {

            $resultado = $query->fetch(PDO::FETCH_ASSOC);
            date_default_timezone_set("Brazil/East");
            #### Sistema de login com Cookies -----------------------------------
            setcookie("UsuarioID", $resultado['id'], time()+3600*24*30*12*5, "/", NULL);
            setcookie("UsuarioNome", $resultado['nome'], time()+3600*24*30*12*5, "/", NULL);
            setcookie("UsuarioNivel", $resultado['nivel'], time()+3600*24*30*12*5, "/", NULL);
            setcookie("UsuarioStatus", $resultado['status'], time()+3600*24*30*12*5, "/", NULL);
            @$usuario_id     = $_COOKIE["UsuarioID"];
            @$usuario_nome   = $_COOKIE["UsuarioNome"];
            @$usuario_nivel  = $_COOKIE["UsuarioNivel"];
            @$usuario_status = $_COOKIE["UsuarioStatus"];
            #### Sistema de login com Cookies -----------------------------------
            
            //Registrar usuário como online
            $usuario_id    = $resultado['id'];
            $datacompleta2 = date("Y-m-d H:i:s");
            $query = $pdo->query("UPDATE clientes SET 
                online='online',
                time='$datacompleta2'
            WHERE id='$usuario_id'");

        // Redireciona o visitante
            if ($URLSESSAO=='carrinho-compras') {
                echo "<script>document.location.href='https://www.epapodetarot.com.br/carrinho-compras/chat/?msgs=Parabéns, sua conta foi criada com sucesso!'</script>";
            } elseif ($URLSESSAO=='comprar-consulta') {
                echo "<script>document.location.href='https://www.epapodetarot.com.br/comprar-consulta/chat/?msgs=Parabéns, sua conta foi criada com sucesso!'</script>";
            } else {
                echo "<script>document.location.href='https://www.epapodetarot.com.br/tarologos/?msgs=Parabéns, sua conta foi criada com sucesso!'</script>";
            }
        }
    }
}

// Adiciona novo produto Loja
if (isset($_POST['enviarAddCarrinho'])) {

    // Variaveis do Novo Produtos, vido do botão comprar
    $id_anuncio            = $_POST['id_anuncio'];
    $quantidadeselecionada = $_POST['quantidadeselecionada'];
    $preco                 = $_POST['preco'];
    $alturaCart            = $_POST['altura'];
    $larguraCart           = $_POST['largura'];
    $comprimentoCart       = $_POST['comprimento'];
    $pesoCart              = $_POST['peso'];
    $id_cliente            = $_SESSION['id_cliente_carrinho'];
    $data                  = date('Y-m-d H:m:s');

    $precoCart = $preco * $quantidadeselecionada;

    // Salva no Carrinho
    $pdo->query("INSERT INTO loja_carrinho (
        id_cliente,
        id_produto,
        quantidade,
        preco,
        altura,
        largura,
        comprimento,
        peso,
        data
    ) VALUES (
        '$id_cliente',
        '$id_anuncio',
        '$quantidadeselecionada',
        '$precoCart',
        '$alturaCart',
        '$larguraCart',
        '$comprimentoCart',
        '$pesoCart',
        '$data'
    )");
}

// logar admin como cliente
if (isset($_POST["logar_como_cliente"])) {

    $id = @$_GET['id'];
    $query = $pdo->query("SELECT * FROM clientes WHERE id = '$id' LIMIT 1");
  
    if ($query->rowCount() == 1) {

        $resultado = $query->fetch(PDO::FETCH_ASSOC);
        #### Sistema de login com Cookies -----------------------------------
        setcookie("UsuarioID", $resultado['id'], time()+3600*24*30*12*5, "/", NULL);
        setcookie("UsuarioNome", $resultado['nome'], time()+3600*24*30*12*5, "/", NULL);
        setcookie("UsuarioNivel", $resultado['nivel'], time()+3600*24*30*12*5, "/", NULL);
        setcookie("UsuarioStatus", $resultado['status'], time()+3600*24*30*12*5, "/", NULL);
        $usuario_id     = $_COOKIE["UsuarioID"];
        $usuario_nome   = $_COOKIE["UsuarioNome"];
        $usuario_nivel  = $_COOKIE["UsuarioNivel"];
        $usuario_status = $_COOKIE["UsuarioStatus"];
        #### Sistema de login com Cookies -----------------------------------

        $datacompleta2 = date("Y-m-d H:i:s");
        $query = $pdo->query( "UPDATE clientes SET 
            online='online',
            time='$datacompleta2'
        WHERE id='$id'");

        echo "<script>document.location.href='minha-conta/?msgs=Parabéns, você foi logado com sucesso!'</script>";
    }
}