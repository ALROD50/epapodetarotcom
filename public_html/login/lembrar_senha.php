<script src="https://www.google.com/recaptcha/api.js?render=6LekxqsZAAAAAP-YFkg74ENqbRiYepBfdxkt1bez"></script>
<?php
if(isset($_POST['envia'])){

  // Pega os posts e gera as variaveis
  $email = $_POST['email'];
  $erros = null;

  // Captcha ###############################################################
    $url = "https://www.google.com/recaptcha/api/siteverify";
    $data = [
      'secret' => "6LekxqsZAAAAAKopDTGnipBCuJQWYWkQ38hY4LvO",
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

  if ($erros >= 1) {
      
  } else {

    // Verifica se o e-mail existe no sistema
    $sqlmail = $pdo->query("SELECT * FROM clientes WHERE email ='$email' LIMIT 1 ");
    $row = $sqlmail->rowCount();

    if ($email == "") {
      $msge="O e-mail <b>$email</b> não foi encontrado no sistema!".'</br>';
      MsgErro ($msge);
    
    } elseif ($row == 1) {

      while ($resultado = $sqlmail->fetch(PDO::FETCH_ASSOC)){
        $id = $resultado['id'];
        $usuario = $resultado['usuario'];
        $nome = $resultado['nome'];
        $email = $resultado['email'];
      }
      $msgs="Sua nova senha foi enviado para <b>$email</b>.".'</br>';
      $msgs.="Verifique sua caixa de entrada, lixo eletrônico ou caixa de spam.";
      
      MsgSucesso ($msgs);

      $senha = geraSenha(10);

      $q = $pdo->query("UPDATE clientes SET senha = md5('$senha')  WHERE id='$id' ");

      $massunto  = "Sua nova senha no Tarot de Hórus";
      $conteudo  = "<p>Uma nova senha de acesso à sua conta no site foi gerada, guarde as informações abaixo para acessar sua conta em nosso site.</p>";
      $conteudo .= "<strong>Dados de Acesso:</strong> <br />";
      $conteudo .= "<strong>Usuário:</strong> $usuario<br />";
      $conteudo .= "<strong>Nova Senha:</strong> $senha<br />";
      $conteudo .= "<br/>";
      $conteudo .= "<br/>";
      $conteudo .= "www.tarotdehorus.com.br<br/>";
      EnviarEmail($email, $nome, $massunto, $conteudo);

    } else {
      $msge="O e-mail <b>$email</b> não foi encontrado no sistema!".'</br>';
      MsgErro ($msge);
    }
  }
}
?>

<h1><i class="fas fa-key"></i> Lembrar Senha</h1>
<hr>

<form name="Lembrar_senha" method="post" action="" class="form-horizontal">

  <input type="hidden" id="token" name="token">

  <p>Digite seu e-mail abaixo, caso seu e-mail esteja cadastrado no sistema, lhe será enviado um e-mail com uma nova senha.</p>

  <div class="form-group">
    <label>*Seu Email de Cadastro:</label>
    <div class="col-sm-5">
      <input type="text" class="form-control" name="email" placeholder="Seu e-mail aqui..." value="<?php echo @$email; ?>" required autofocus />
      <br>
      <input class="btn btn-success" type="submit" name="envia" value="Verificar"/>
    </div>
  </div>

</form>

<script>
  grecaptcha.ready(function() {
      grecaptcha.execute('6LekxqsZAAAAAP-YFkg74ENqbRiYepBfdxkt1bez', {action: 'homepage'}).then(function(token) {
        // console.log(token);
        document.getElementById("token").value = token;
      });
  });
</script>