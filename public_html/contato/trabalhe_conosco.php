<script src="https://www.google.com/recaptcha/api.js?render=6LfIKpwhAAAAALRzObk_GNN_kB60S8px5S9XZgkw"></script>
<?php
if(isset($_POST['envia'])){
  $email = trim(addslashes(strip_tags($_POST['email'])));
  $Senha = trim(addslashes(strip_tags($_POST['Senha'])));
  $nome = trim(addslashes(strip_tags($_POST['nome'])));
  $CPF = trim(addslashes(strip_tags($_POST['CPF'])));
  $endereco = trim(addslashes(strip_tags($_POST['endereco'])));
  $telefone = trim(addslashes(strip_tags($_POST['telefone'])));
  $nomep = trim(addslashes(strip_tags($_POST['nomep'])));
  $experiencia = trim(addslashes(strip_tags($_POST['experiencia'])));
  $horario = trim(addslashes(strip_tags($_POST['horario'])));
  $Oraculos = trim(addslashes(strip_tags($_POST['Oraculos'])));
  $perfil = trim(addslashes(strip_tags($_POST['perfil'])));
  $pagamento = trim(addslashes(strip_tags($_POST['pagamento'])));
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
      $msge="You are not a human.";
    }
  // Captcha ###############################################################
  if ($erros >= 1) {
        
  } else {
      /* -----------------Mandando E-mail---------------------- */
      // Usando o PHPMailer, Preparando o email
      $emailMailer = new PHPMailer();
      $emailMailer->setLanguage('pt');
      $emailMailer->CharSet = "UTF-8";
      $emailMailer->IsHTML(true);
      $emailMailer->AddCustomHeader("List-Unsubscribe: <mailto:epapodetarot@gmail.com?subject=Unsubscribe>, <https://www.epapodetarot.com.br>");
      $emailMailer->Host     = "";  
      $emailMailer->SMTPAuth = false; 
      $emailMailer->Username = ""; 
      $emailMailer->Password = ""; 
      $emailMailer->From      = 'epapodetarot@gmail.com'; // Remetente
      $emailMailer->AddAddress( "epapodetarot@gmail.com", 'É Papo de Tarot'); // Destinatário
      // $emailMailer->AddBCC('logs@novasystems.com.br', 'Nova Systems'); // Cópia oculta
      $emailMailer->FromName  = 'É Papo de Tarot'; // Seu nome
      $emailMailer->Subject   = 'Trabalhe Conosco'; // Assunto
      $corpoMSG = '
      Uma nova mensagem foi enviada via formulário trabalhe conosco no site.<br/>
      <br/>
      Dados de Login <br/>
      <br/>
      E-mail: '.$email.' <br/>
      Senha: '.$Senha.' <br/>
      <br/>
      <br/>
      Dados Pessoais <br/>
      <br/>
      Nome Completo: '.$nome.' <br/>
      CPF: '.$CPF.' <br/>
      Endereço: '.$endereco.' <br/>
      Telefone: '.$telefone.' <br/>
      <br/>
      <br/>
      Dados Profissionais <br/>
      <br/>
      Nome Profissional: '.$nomep.' <br/>
      Tempo de Experiência: '.$experiencia.' <br/>
      Horário de Atendimento: '.$horario.' <br/>
      Oráculos: '.$Oraculos.' <br/>
      Perfil de Atendimento: '.$perfil.' <br/>
      <br/>
      <br/>
      Dados para pagamento <br/>
      <br/>
      '.$pagamento.' <br/>
      <br/>
      É Papo de Tarot<br/>
      <a href=\'https://www.epapodetarot.com.br/\'>www.epapodetarot.com.br</a>
      ';
      $emailMailer->MsgHTML($corpoMSG);
      // Enviando o email
      $emailMailer->Send();
      /* -----------------Mandando E-mail---------------------- */
      $msgs ="Sua mensagem foi enviada com sucesso!".'</br>';
      $msgs.="Em breve nossa equipe estará entrando em contato com você.".'</br>';
      MsgSucesso($msgs);
  }  
}
?>
<h1>Trabalhe Conosco</h1>
<hr>

<form name="trabalhe_conosco" method="post" action="" class="form-horizontal" accept-charset="UTF-8" >

<input type="hidden" id="token" name="token">

<div class="row">
    <div class="col-md-6">
      <h3>DADOS DE LOGIN</h3>
      <hr>
      <div class="form-group">
        <label for="" class="">E-mail:</label>
        <div class="">
          <input type="text" class="form-control"  name="email" value="<?php echo $email = isset($_POST['email']) ? $_POST['email'] : ''; ?>" required autofocus />
        </div>
      </div>
      <div class="form-group">
        <label for="" class="">Senha:</label>
        <div class="">
          <input type="text" class="form-control"  name="Senha" value="<?php echo $Senha = isset($_POST['Senha']) ? $_POST['Senha'] : ''; ?>" required autofocus />
        </div>
      </div>
      <hr>
      <h3>DADOS PESSOAIS</h3>
      <hr>
      <div class="form-group">
        <label for="" class="">Nome Completo:</label>
        <div class="">
          <input type="text" class="form-control"  name="nome" value="<?php echo $nome = isset($_POST['nome']) ? $_POST['nome'] : ''; ?>" required autofocus />
        </div>
      </div>
      <div class="form-group">
        <label for="" class="">CPF:</label>
        <div class="">
          <input type="text" class="form-control"  name="CPF" value="<?php echo $CPF = isset($_POST['CPF']) ? $_POST['CPF'] : ''; ?>" required autofocus />
        </div>
      </div>
      <div class="form-group">
        <label for="" class="">Endereço Completo:</label>
        <div class="">
          <input type="text" class="form-control"  name="endereco" value="<?php echo $endereco = isset($_POST['endereco']) ? $_POST['endereco'] : ''; ?>" required autofocus />
        </div>
      </div>
      <div class="form-group">
        <label for="" class="">Telefone para Contato Celular:</label>
        <div class="">
          <input type="text" class="form-control"  name="telefone" value="<?php echo $telefone = isset($_POST['telefone']) ? $_POST['telefone'] : ''; ?>" required autofocus />
        </div>
      </div>

    </div>
    <div class="col-md-6">
      <h3>DADOS PROFISSIONAIS</h3>
      <hr>
      
      <div class="form-group">
        <label for="" class="">Nome Profissional:</label>
        <div class="">
          <input type="text" class="form-control"  name="nomep" value="<?php echo $nomep = isset($_POST['nomep']) ? $_POST['nomep'] : ''; ?>" required autofocus />
        </div>
      </div>
      <div class="form-group">
        <label for="" class="">Tempo de Experiência:</label>
        <div class="">
          <input type="text" class="form-control"  name="experiencia" value="<?php echo $experiencia = isset($_POST['experiencia']) ? $_POST['experiencia'] : ''; ?>" required autofocus />
        </div>
      </div>
      <div class="form-group">
        <label for="" class="">Horário de Atendimento:</label>
        <div class="">
          <input type="text" class="form-control"  name="horario" value="<?php echo $horario = isset($_POST['horario']) ? $_POST['horario'] : ''; ?>" required autofocus />
        </div>
      </div>
      <div class="form-group">
        <label for="" class="">Oráculos:</label>
        <div class="">
          <input type="text" class="form-control"  name="Oraculos" value="<?php echo $Oraculos = isset($_POST['Oraculos']) ? $_POST['Oraculos'] : ''; ?>" required autofocus />
        </div>
      </div>
      <div class="form-group">
        <label for="" class="">Perfil de Atendimento ( Mínimo de 350 caracteres e no máximo 500 )</label>
        <div class="">
          <textarea name="perfil" class="form-control"/></textarea>
        </div>
      </div>
      <hr>
      <h3>DADOS PARA PAGAMENTOS</h3>
      <hr>
      <div class="form-group">
        <label for="" class="">Contas Bancárias:</label>
        <div class="">
          <textarea name="pagamento" class="form-control"/></textarea>
        </div>
      </div>
      
      <div class="form-group">
        <input class="btn btn-primary" type="submit" name="envia" value="Enviar Dados"/>
      </div>
    </div>
</div>

</form>

<script>
  grecaptcha.ready(function() {
      grecaptcha.execute('6LfIKpwhAAAAALRzObk_GNN_kB60S8px5S9XZgkw', {action: 'homepage'}).then(function(token) {
        // console.log(token);
        document.getElementById("token").value = token;
      });
  });
</script>