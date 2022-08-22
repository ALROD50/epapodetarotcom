<script src='https://www.google.com/recaptcha/api.js'></script>
<style type="text/css">
    /* Recaptcha */
    @media (max-width: 480px) {
        #rc-imageselect, .g-recaptcha {
            transform:scale(0.77);
            -webkit-transform:scale(0.77);
            transform-origin:0 0;
            -webkit-transform-origin:0 0;
        }
    }
</style>
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
    if (isset($_POST['g-recaptcha-response'])) {
        $captcha_data = $_POST['g-recaptcha-response'];
    }
    // Se nenhum valor foi recebido, o usuário não realizou o captcha
    if (!$captcha_data) {
        $erros++; 
        $msge="Clique no box <b>Não sou um robô.</b>";
        MsgErro ($msge);
    } else {            
        //biblioteca para o captcha
        require_once '/home/tarotdehoruscom/public_html/scripts/recaptcha/autoload.php';
        // sua chave secreta
        $secret = "6LeO7OkUAAAAAL7xRieXU8luIkFBANA7_GjnSbsT";
        // resposta vazia
        $response = null;
        // verifique a chave secreta
        $reCaptcha = new \ReCaptcha\ReCaptcha($secret);
        // se submetido, verifique a resposta
        if ($_POST["g-recaptcha-response"]) {
            $response = $reCaptcha->verify($_POST['g-recaptcha-response'], $_SERVER['REMOTE_ADDR']);
        }
        if ($response != null && $response->isSuccess()) {
            $captchav = null;
        } else {
            $erros++;
            $msge="A mensagem não foi enviada.";
            MsgErro ($msge);
        }
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
      $emailMailer->AddCustomHeader("List-Unsubscribe: <mailto:contato@tarotdehorus.com.br?subject=Unsubscribe>, <https://www.tarotdehorus.com.br>");
      $emailMailer->Host     = "";  
      $emailMailer->SMTPAuth = false; 
      $emailMailer->Username = ""; 
      $emailMailer->Password = ""; 
      $emailMailer->From      = 'contato@tarotdehorus.com.br'; // Remetente
      $emailMailer->AddAddress( "contato@tarotdehorus.com.br", 'Tarot de Hórus'); // Destinatário
      // $emailMailer->AddBCC('logs@novasystems.com.br', 'Nova Systems'); // Cópia oculta
      $emailMailer->FromName  = 'Tarot de Hórus'; // Seu nome
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
      Tarot de Hórus<br/>
      <a href=\'https://www.tarotdehorus.com.br/\'>www.tarotdehorus.com.br</a>
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
        <div class="g-recaptcha" data-sitekey="6LeO7OkUAAAAAHEfPoGmvH6VaNJa-RhLIGK4uVbA"></div>
        <br>
        <input class="btn btn-primary" type="submit" name="envia" value="Enviar Dados"/>
      </div>
    </div>
</div>

</form>



