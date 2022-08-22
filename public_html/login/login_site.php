<script src="https://www.google.com/recaptcha/api.js?render=6LekxqsZAAAAAP-YFkg74ENqbRiYepBfdxkt1bez"></script>
<!-- Login com Google -->
<script src="https://apis.google.com/js/api:client.js"></script>
<script>
  var googleUser = {};
  var startApp = function() {
    gapi.load('auth2', function(){
        auth2 = gapi.auth2.init({
          // https://console.cloud.google.com/projectselector2/apis/dashboard?supportedpurview=project
          client_id: '694186447424-9ildn0k96gkt7oknbfsl9i8qaeb9u679.apps.googleusercontent.com',
          cookiepolicy: 'single_host_origin',
        });
        attachSignin(document.getElementById('customBtn'));
        attachSignin(document.getElementById('customBtn2'));
    });
  };
  function attachSignin(element) {
    // console.log(element.id);
    auth2.attachClickHandler(element, {},
      function(googleUser) {
        // Conseguindo o ID do Usuário
        var userID = googleUser.getBasicProfile().getId();
        // Conseguindo o Nome do Usuário
        var userName = googleUser.getBasicProfile().getName();
        // Conseguindo o E-mail do Usuário
        var userEmail = googleUser.getBasicProfile().getEmail();
        // Conseguindo a URL da Foto do Perfil
        var userPicture = googleUser.getBasicProfile().getImageUrl();
        // Registrando no sistema
        document.location.href='https://www.tarotdehorus.com.br/registre-se/gg/' + userName + '/' + userEmail;
      }, function(error) {
        //alert(JSON.stringify(error, undefined, 2));
    });
  }
</script>
<!-- Login com Google -->
<?php
$Mask="SIM";
$mostrarLogin="offset-xl-4 offset-lg-4 offset-md-3 ";
$mostrarRegistro="offset-xl-4 offset-lg-4 offset-md-3 ";
if ($URLSESSAO=="registre-se") {
  $mostrarLogin="d-none";
} elseif ($URLSESSAO=="fazer-login") {
  $mostrarRegistro="d-none";
} else {
  $mostrarLogin="offset-xl-2 offset-lg-2 ";
  $mostrarRegistro="";
}

// Verifica se o usuário esta logado.
if(@$row_onlinex=="offline" OR @$row_onlinex=="") { ?>

  <div class="row py-4">
    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-xs-12 <?php echo $mostrarLogin; ?>">

      <div class="card bg-light mb-3 shadow">
        <div class="card-header"><h2 class="mb-0"><i class="fas fa-door-open"></i> Entrar</h2></div>
        <div class="card-body">
          <center><h5 class="card-title"><i class="fas fa-handshake"></i> Bem-Vindo De Volta!</h5></center>
          <a button href="<?php echo $loginUrl; ?>" id="xface" class="btn btn-lg btn-primary btn-block bot_cadastro_facebook" type="submit" title="Cadastrar Via Facebook" alt="Cadastrar Via Facebook" name="cadastro_facebook"><i class="fab fa-facebook"></i> Entrar Com Facebook</button></a>
          <div id="customBtn" class="customGPlusSignIn mt-2">
            <button class="btn btn-lg btn-danger btn-block" title="Entrar Via Google" alt="Entrar Via Google"><span class="text-white"><i class="fab fa-google"></i> Entrar Com Google</span></button>
          </div>
          <hr>
          <center><p> Ou </p></center>
          <form name="FormLogin" id="FormLogin" method="post" action="" class="form-horizontal">
            <input type="hidden" id="token2" name="token2">
            <div class="form-group">
              <label for="usuario">Usuário/Email:</label>
              <input type="text" class="form-control" placeholder="Usuário ou Email" name="usuario" value="<?php echo $usuario = isset($_POST['usuario']) ? $_POST['usuario'] : ''; ?>" required  />
            </div>
            <div class="form-group">
              <label for="senha">Senha:</label>
              <input type="password" class="form-control" placeholder="******" name="senha" value="<?php echo $senha = isset($_POST['senha']) ? $_POST['senha'] : ''; ?>" required />
            </div>
            <div class="form-group">
              <button class="btn btn-lg btn-success btn-block text-white" type="submit" name="loginsite" id="loginsite"><i class="fas fa-sign-in-alt"></i> ENTRAR</button>
              <center><p><small><i class="fas fa-search"></i> <a href="lembrar-senha">Lembrar Minha Senha.</a></small></p></center>
            </div>

          </form>
        </div>
      </div>

    </div>
    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-xs-12 <?php echo $mostrarRegistro; ?>">
      
      <div class="card bg-light mb-3 shadow">
        <div class="card-header"><h2 class="mb-0 titlecriarnovaconta"><i class="fas fa-user-plus"></i> Criar Nova Conta</h2></div>
        <div class="card-body">
          <center>
            <h5 class="card-title">Ainda não tem uma conta?</h5>
            <p class="card-text mb-3"><i class="fas fa-laugh"></i> É muito fácil, vamos Lá!</p>
            <a button href="<?php echo $loginUrl; ?>" id="xface" class="btn btn-lg btn-primary btn-block bot_cadastro_facebook" type="submit" title="Cadastrar Via Facebook" alt="Cadastrar Via Facebook" name="cadastro_facebook"><i class="fab fa-facebook"></i> Registrar Com Facebook</button></a>
            <div id="customBtn2" class="customGPlusSignIn mt-2">
              <button class="btn btn-lg btn-danger btn-block" title="Registrar Via Google" alt="Registrar Via Google"><span class="text-white"><i class="fab fa-google"></i> Registrar Com Google</span></button>
            </div>
          </center>
          <hr>
          <center><p> Ou </p></center>

          <form name="CadastroForm" id="CadastroForm" method="post" action="" class="form-horizontal" autocomplete="off">
            <input type="hidden" id="token" name="token">
            <div class="form-group">
              <input type="text" class="form-control"  name="nome" value="<?php echo $nome = isset($_POST['nome']) ? $_POST['nome'] : ''; ?>" placeholder="Seu Nome Completo" required />
            </div>
            <div class="form-group">
              <input type="tel" class="form-control"  name="data_nascimento" data-mask="00-00-0000" placeholder="Data de Nascimento" value="<?php echo $data_nascimento = isset($_POST['data_nascimento']) ? $_POST['data_nascimento'] : ''; ?>" required />
            </div>
            <div class="form-group">
              <input type="tel" class="form-control cel_with_ddd"  name="whatsapp" value="<?php echo $whatsapp = isset($_POST['whatsapp']) ? $_POST['whatsapp'] : ''; ?>" placeholder="Celular" required />
            </div>
            <div class="form-group">
              <input type="text" class="form-control"  name="email" value="<?php echo $email = isset($_POST['email']) ? $_POST['email'] : ''; ?>" placeholder="Use Seu Melhor Email" required autocomplete="off"/>
            </div>
            <div class="form-group">
              <input type="password" class="form-control"  name="senha" value="<?php echo $senha = isset($_POST['senha']) ? $_POST['senha'] : ''; ?>" placeholder="Crie uma senha fácil de lembrar" required autocomplete="off"/>
            </div>
            <div class="form-group">
              <button class="btn btn-lg btn-success btn-block text-white" type="submit" name="enviacadastrar" id="enviacadastrar"><i class="fas fa-house-user"></i> CADASTRAR</button>
              <center><p><small><i class="fas fa-hands-helping"></i> Eu li e aceito os <a href="https://www.tarotdehorus.com.br/politica-de-privacidade-e-termos-de-uso" target="_blank">Termos de Uso.</a></small></p></center>
            </div>
          </form>
        </div>
      </div>

    </div>
  </div>

  <?php 

} else {

  //Esta logado.
  echo '
    <div class="card card-body">
      Você já está cadastrado como '.$usuario_nome.', <a href="login/logout.php" class="link-padraotres">Sair</a>
    </div>
  ';
  $logado_no_site = false;
} 
?>
<script>
  grecaptcha.ready(function() {
    grecaptcha.execute('6LekxqsZAAAAAP-YFkg74ENqbRiYepBfdxkt1bez', {action: 'homepage'}).then(function(token) {
      // console.log(token);
      document.getElementById("token").value = token;
   });
  });
</script>
<script>
  grecaptcha.ready(function() {
    grecaptcha.execute('6LekxqsZAAAAAP-YFkg74ENqbRiYepBfdxkt1bez', {action: 'homepage'}).then(function(token) {
      // console.log(token);
      document.getElementById("token2").value = token;
   });
  });
</script>

<!-- Login com Google -->
<script>startApp();</script>
<!-- Login com Google -->