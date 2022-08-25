<?php
//Estancia dados de cadastro do usuário
$dadoss3 ="SELECT * FROM clientes WHERE id='$usuario_id'"; 
$executa3=$pdo->query( $dadoss3);
while ($dadoss3= $executa3->fetch(PDO::FETCH_ASSOC)){
  $cliente_nome=$dadoss3['nome'];
  $cliente_email=$dadoss3['email'];
  $cliente_user=$dadoss3['usuario'];
}

include 'verifica_ult_consulta.php';

?>
<h3 class="text-success"><i class="far fa-address-book"></i> Minha Conta</h3>
<hr>

<script>
  // Permissão de Notificações
  // navigator.serviceWorker.register('sw.js');
  function showNotification() {
    Notification.requestPermission(function(result) {
      console.log("Permissão de Notificações Solicitada!");
      if (result === 'granted') {
          var notification = new Notification('Permissão Autorizada', {
            icon: 'https://www.epapodetarot.com.br/images/Logo-SiteP.png',
            body: "Parabéns você deu permissão para as Notificações!",
          });
      } 
      // Recarrega a página
      var x = setTimeout(function(){
        document.location.href="https://www.epapodetarot.com.br/minha-conta/?pg=area_tarologos/resumo.php";
      }, 5000); // Executa depois 5 segundos
    });
  }
  // Mostra Notificações
  function mostrarNot(){
    Notification.requestPermission().then(function(permission) {
      const notification = new showNotification('Teste Notificações', {
        icon: 'https://www.epapodetarot.com.br/images/Logo-SiteP.png',
        body: "Teste de Notificações com Sucesso!",
        silent: true,
      });
    });
  }
  // Verifica se as notificações estão ativas
  Notification.requestPermission(function(result) {
    if (result === 'granted') {
      console.log("Status Notificação: Ativada!");
      $('#permissaonotificacoes').hide()
      $('#notificacoesdochatativa').show();
    } else {
      console.log("Status Notificação: Desativada!");
      $('#permissaonotificacoes').show();
      $('#notificacoesdochatativa').hide();
    }
  });
</script>

<!-- Área de Testes -->
<div class="alert alert-primary mt-2" role="alert">
  <p><i class="fas fa-capsules"></i> <b>Dica:</b> Faça <a href="https://conectanuvem.com.br/como-fazer-login-no-google-chrome/" target="_BLANK">login no navegador</a>, para que suas preferências de audio, video, e notificações fiquem salvas.</p>
  <p><i class="fas fa-chess-knight"></i> Ao entrar no site, ou finalizar um atendimento é importante realizar os testes de áudio e notificações abaixo!</p>
  <!-- Exemplo de Configurações do Chat No Navegador Correto -->
  <p><i class="fas fa-cogs"></i> <b>Exemplo das Configurações Corretas!</b> <button type="button" onclick="MostraConfigCorrect()"><i class="fas fa-clipboard-check"></i> Clique Aqui.</button></p>
  <div class="alert alert-success" role="alert" id="collapseConf" style="display:none;">
      <button type="button" class="close" data-dismiss="alert">×</button>
      <div class="panel-heading">
          <h3><i class="fas fa-check-square"></i> Exemplo de Configurações Corretas do Chat No Navegador</h3>
          <p>Verifique se os <b>6</b> itens abaixo estão iguais no seu navegador, ou seja com permissão ativa. Recomendamos o navegador <b><i class="fab fa-chrome"></i> Google Chrome</b> por ser o mais moderno. Lembre-se de deixar aumentar o volume do computador para que possa ouvir a Campainha. É importante também que o <b>Assistente de Foco</b>, do windows esteja desativado.</p> 
      </div>
      <div class="panel-body">
          <img src="images/controlechat.png" alt="Exemplo de Configurações do Chat No Navegador Correto" title="Exemplo de Configurações do Chat No Navegador Correto">
          <img src="images/volume.png" alt="Exemplo de Configurações do Chat No Navegador Correto" title="Exemplo de Configurações do Chat No Navegador Correto">
          <h3>Mantenha as 3 caixas verdes de Microfone e Vídeo, Notificações do Chat e Campainha do Chat, sendo exibidas como no exemplo abaixo:</h3>
          <img src="images/correct.png" alt="Exemplo de Configurações do Chat No Navegador Correto" title="Exemplo de Configurações do Chat No Navegador Correto" style="width:100%;">
      </div>
  </div>
  <button type="button" onclick="showNotification()"><i class="fas fa-check-circle"></i> Ativar Notificações do Chat</button>
  <button type="button" onclick="mostrarNot()"><i class="fas fa-bell"></i> Testar Notificações do Chat</button>
  <button id="btn"><i class="fas fa-volume-up"></i> Testar Campainha do Chat</button>
</div>
 
<!-- Mensagens de Erro -->
<div id="permissaonegada" class="alert alert-danger mt-2" role="alert" style="display:none;">
  <p><b><i class="fas fa-info-circle"></i> Erro!</b> - Você precisa dar permissão para Microfone e Vídeo no navegador para que o atendimento funcione corretamente. Mesmo que você não atenda nas Videochamadas este recurso precisa ser ativado. Não se preocupe se o navegador for usar a câmera ou microfone você vai ser avisado.</p>
  <p>Abaixo segue instruções de como corrigir o problema no navegador <b><i class="fab fa-chrome"></i> Google Chrome</b>.</p>
  <img src="images/permition.png" alt="">
</div>
<div id="permissaoaudionegada" class="alert alert-danger mt-2" role="alert">
  <p><b><i class="fas fa-info-circle"></i> Erro!</b> - Você precisa dar permissão para a <b>Campainha</b> no Navegador para que o atendimento funcione corretamente. Este recurso é usado para enviar o aviso sonoro quando o cliente chama para consulta.</p>
  <p class="buttons">
    <!-- <button value="0">Block</button> -->
    <button value="1"><i class="fas fa-check-circle"></i> Ativar Permissão de Áudio</button>
  </p>
  <p class="mt-2">Se após clicar no botão acima não resolver o problema, tente as <b>5</b> opções abaixo:</p>
  <ol>
    <li> <i class="fas fa-check"></i> <a href="https://support.google.com/accounts/answer/32050?hl=pt-BR&co=GENIE.Platform%3DDesktop" target="_BLANK">Limpe o Cache e Cookies do seu Navegador</a></li>
    <li> <i class="fas fa-check"></i> <a href="https://support.google.com/chromebook/answer/2589434?hl=pt-BR" target="_BLANK">Desative Todas as Extensões do Navegador</a></li>
    <li> <i class="fas fa-check"></i> <a href="https://support.google.com/chrome/answer/95414?hl=pt-PT&co=GENIE.Platform%3DDesktop#:~:text=No%20computador%2C%20abra%20o%20Google%20Chrome.,-No%20canto%20superior&text=Sobre%20o%20Google%20Chrome.,mais%20recente%20j%C3%A1%20est%C3%A1%20instalada." target="_BLANK">Certifique-se Que o Navegador esta Atualizado na Última Versão</a></li>
    <li> <i class="fas fa-check"></i> <a href="https://www.youtube.com/watch?v=fzjBDRyXLPQ" target="_BLANK">Como Saber Se o Windows é Original</a></li>
    <li> <i class="fas fa-check"></i> <a href="https://www.youtube.com/watch?v=b-spMKa-Auw" target="_BLANK">Como Corrigir Todos os Problemas do Windows</a></li>
  </ol>
</div>
<div id="permissaonotificacoes" class="alert alert-danger mt-2" role="alert" style="display:none;">
  <p><b><i class="fas fa-info-circle"></i> Erro!</b> - Você precisa dar permissão para a <b>Notificações do Chat</b> no Navegador. Quando o cliente chama para consulta, além da Campainha, também é enviado uma notificação do Windows, ela aparece sobre todos os outros Apps, e facilita identificar quando um cliente chama.</p>
  <button type="button" onclick="showNotification()"><i class="fas fa-check-circle"></i> Ativar Notificações do Chat</button>
  <p class="mt-2">Se após clicar no botão acima não resolver o problema, tente as <b>5</b> opções abaixo:</p>
  <ol>
    <li> <i class="fas fa-check"></i> <a href="https://support.google.com/accounts/answer/32050?hl=pt-BR&co=GENIE.Platform%3DDesktop" target="_BLANK">Limpe o Cache e Cookies do seu Navegador</a></li>
    <li> <i class="fas fa-check"></i> <a href="https://support.google.com/chromebook/answer/2589434?hl=pt-BR" target="_BLANK">Desative Todas as Extensões do Navegador</a></li>
    <li> <i class="fas fa-check"></i> <a href="https://support.google.com/chrome/answer/95414?hl=pt-PT&co=GENIE.Platform%3DDesktop#:~:text=No%20computador%2C%20abra%20o%20Google%20Chrome.,-No%20canto%20superior&text=Sobre%20o%20Google%20Chrome.,mais%20recente%20j%C3%A1%20est%C3%A1%20instalada." target="_BLANK">Certifique-se Que o Navegador esta Atualizado na Última Versão</a></li>
    <li> <i class="fas fa-check"></i> <a href="https://www.youtube.com/watch?v=fzjBDRyXLPQ" target="_BLANK">Como Saber Se o Windows é Original</a></li>
    <li> <i class="fas fa-check"></i> <a href="https://www.youtube.com/watch?v=b-spMKa-Auw" target="_BLANK">Como Corrigir Todos os Problemas do Windows</a></li>
  </ol>
</div>
<div id="chrome" class="alert alert-danger mt-2" role="alert" style="display:none;">
  <p><b><i class="fas fa-info-circle"></i> Erro!</b> - Você não esta utilizando o navegador <b><i class="fab fa-chrome"></i> Google Chrome</b>. Para evitar erros durante a utilização do site, recomendamos o uso do Google Chrome.</p>
  <a class="btn btn-success" type="button" href="https://support.google.com/chrome/answer/95346?hl=pt-BR&co=GENIE.Platform%3DDesktop#zippy=%2Cwindows" target="_BLANK"><i class="fab fa-chrome"></i> Clique Aqui Para Baixar o Google Chrome.</a>
</div>

<!-- Mensagens de Sucesso -->
<div class="row">
  <div class="col-md-4">
    <div id="permissaoativa" class="alert alert-success mt-2" role="alert" style="display:none;">
      <p><b><span class="badge badge-pill badge-dark"> 1 </span> <i class="fas fa-headset"></i> Microfone e Vídeo</b></p>
      <p><i class="far fa-check-circle"></i> Ativado!</p>
    </div>
  </div>
  <div class="col-md-4">
    <div id="notificacoesdochatativa" class="alert alert-success mt-2" role="alert" style="display:none;">
      <p><b><span class="badge badge-pill badge-dark"> 2 </span> <i class="fas fa-bell"></i> Notificações do Chat</b></p>
      <p><i class="far fa-check-circle"></i> Ativado!</p>
    </div>
  </div>
  <div class="col-md-4">
    <div id="sounddochatativa" class="alert alert-success mt-2" role="alert" style="display:none;">
      <p><b><span class="badge badge-pill badge-dark"> 3 </span> <i class="fas fa-volume-up"></i> Campainha do Chat</b></p>
      <p><i class="far fa-check-circle"></i> Ativado!</p>
    </div>
  </div>
</div>

<div class="card card-body mb-3" style="background:#fff; color:#383C3F;">
  <p><b><i class="far fa-list-alt"></i> Mantenha sempre as 3 caixas verdes acima ativas</b> (1 - Microfone e Vídeo, 2 - Notificações do Chat, 3 - Campainha do Chat). Realize todos os testes e ajustes da caixa azul acima para ativa-las. <a type="button" class="btn btn-primary btn-sm" href="https://www.epapodetarot.com.br/minha-conta"><i class="far fa-question-circle"></i> Recarregar e Testar!</a></p>
  <center><p><b class="youtube"><u><h4><i class="far fa-thumbs-up"></i> Aguarde o cliente chamar sempre nessa mesma página em que esta agora.</h4></u></b></p></center>
</div>

<!-- Minha Conta -->
<div class="row">
  <div class="col-md-6">
    <div class="card card-body" style="background:#fff; color:#383C3F;">
        <p class="mb-0"><strong><?php echo '#'.$usuario_id.' '.$cliente_nome; ?></strong><br>
        Usuário: <strong><?php echo $cliente_user; ?></strong><br>
        E-mail: <strong><?php echo $cliente_email; ?></strong><br>
        Valor do Minuto: R$ <strong><?php echo $config_valor_minutos; ?></strong><br>
        Sua Comissão: <strong><?php echo $config_porcentagem_tarologo; ?>%</strong></p>
    </div>
  </div>

  <div class="col-md-6">
    <div class="card card-body" style="background:#fff; color:#383C3F;">
        <!-- Mudar meu status -->
        <h4>Mudar meu Status no site</h4>
        <br>
        <div style="display: -webkit-inline-box;">
          <form name="Mudar_Ocupado" id="Mudar_Ocupado"  action="" method="post" style="margin: 5px 10px 5px 0;">
            <button class="btn btn-danger" name="Mudar_Ocupado" type="submit"> Ocupado</button>
          </form>
          <form name="Mudar_Online" id="Mudar_Online"  action="" method="post" style="margin: 5px 10px 5px 0;">
            <button class="btn btn-success" name="Mudar_Online" type="submit"> Online</button>
          </form>
          <?php 
          if (isset($_POST["Mudar_Ocupado"])) { 
            // ocupado
            $datacompleta2 = date("Y-m-d H:i:s");
            $query = $pdo->query( "UPDATE clientes SET 
                online='ocupado',
                time='$datacompleta2'
            WHERE id='$usuario_id'");
            echo "<script>alert(' Atenção - Seu status foi alterado para Ocupado com sucesso!  ')</script>";
          }
          if (isset($_POST["Mudar_Online"])) { 
            // online
            $datacompleta2 = date("Y-m-d H:i:s");
            $query = $pdo->query( "UPDATE clientes SET 
                online='online',
                time='$datacompleta2'
            WHERE id='$usuario_id'");
            echo "<script>alert(' Atenção - Seu status foi alterado para Online com sucesso!  ')</script>";
          }
          ?>
        </div>
        <!-- Mudar meu status -->
    </div>
  </div>
</div>

<!-- Últimos Atendimentos -->
<h5 style="color:#0873bb;">Últimos Atendimentos</h5>
<div class="row">
  <div class="col-md-12">
        <?php 
        $sql = $pdo->query("SELECT * FROM atendimento WHERE id_tarologo='$usuario_id' ORDER BY id DESC LIMIT 5"); 
        $row = $sql->rowCount();
        if ($row > 0){
      ?>
      <div class="table-responsive">
      <table class="table table-responsive table-bordered table-condensed table-hover table-striped" style="margin-top:15px; font-size:12px;">
          <thead>
            <tr style="background:#265A88; color:#fff;">
              <th>ID</th>
              <th> Cliente</th>
              <th> Tarólogo</th>
              <th> Código Consulta</th>
              <th> Data</th>
              <th> Duração (Minutos)</th>
              <th> Comissão</th>
            </tr>
          </thead>
          <tbody>
          <?php  
              while ($mostrar = $sql->fetch(PDO::FETCH_ASSOC)){  
                $id=$mostrar['id'];
                $id_cliente=$mostrar['id_cliente'];
                $id_tarologo=$mostrar['id_tarologo'];
                $cod_consulta=$mostrar['cod_consulta'];
                $data=$mostrar['data'];
                $data=MostraDataCorretamenteHora ($data);
                $duracao=$mostrar['duracao'];
                if ($duracao=="") {
                  $duracao=0;
                }

                //Estancia dados do tarólogo
                $dadoss4 ="SELECT * FROM clientes WHERE id='$id_tarologo'"; 
                $executa4=$pdo->query($dadoss4);
                  while ($dadoss4= $executa4->fetch(PDO::FETCH_ASSOC)){
                  $tarologo_id=$dadoss4['id'];
                  $tarologo_nome=$dadoss4['nome'];
                }

                //Estancia dados do cliente
                $dadoss3 ="SELECT * FROM clientes WHERE id='$id_cliente'"; 
                $executa3=$pdo->query($dadoss3);
                  while ($dadoss3= $executa3->fetch(PDO::FETCH_ASSOC)){
                  $cliente_id=$dadoss3['id'];
                  $cliente_nome=$dadoss3['nome'];
                }
                ?>
              <tr>
                <td><?php echo $id; ?></td>
                <td><?php echo $cliente_nome; ?></td>
                <td><?php echo $tarologo_nome; ?></td>
                <td><?php echo $cod_consulta; ?></td>
                <td><?php echo $data; ?></td>
                <td><?php echo $duracao; ?></td>
                <td><?php echo 'R$ '.CalculaComissao($duracao, $config_valor_minutos, $config_porcentagem_tarologo); ?></td>
                </tr>
       <?php } ?>
          </tbody>
        </table>
        </div>     
      <?php
        
      }else{
        $msge="Nenhum resultado encontrado...";
        MsgErro ($msge);
        }
      ?>
  </div>
</div>

<script>
  // Verifica se Áudio e Vídeo estão ativos
  const audio = new Audio( 'https://www.epapodetarot.com.br/chat/newmsg.mp3' );
  audio.muted = true;
  const alert_elem = document.querySelector( '#permissaoaudionegada' );
  audio.play().then( () => {
    // already allowed
    alert_elem.remove();
    resetAudio();
    // $('#permissaoativa').show();
    // $('#permissaonegada').hide();
    console.log( 'Áudio ativado no navegador!' );
    $('#sounddochatativa').show();
  } )
  .catch( () => {
    // need user interaction
    alert_elem.addEventListener( 'click', ({ target }) => {
      if ( target.matches('button') ) {
        const allowed = target.value === "1";
        if ( allowed ) {
          audio.play().then(resetAudio);
          // $('#permissaoativa').hide();
          // $('#permissaonegada').show();
          console.log( 'Teste de áudio 2' );
        }
        alert_elem.remove();
        // $('#permissaoativa').show();
        // $('#permissaonegada').hide();
        console.log( 'Teste de áudio 3' );
        // Recarrega a página
        document.location.href="https://www.epapodetarot.com.br/minha-conta/?pg=area_tarologos/resumo.php";
      }
    } );
    console.log( 'Teste de áudio Desativado' );
    $('#sounddochatativa').hide();
  } );
  document.getElementById( 'btn' ).addEventListener( 'click', (e) => {
    if ( audio.muted ) {
      alert( 'Seu navegador não deu permissão para áudio.' );
    } else {
      audio.play();
      console.log( 'Teste de áudio ok' );
    }
  } );
  function resetAudio() {
    audio.pause();
    audio.currentTime = 0;
    audio.muted = false;
  }
  // Pede Permissão para Audio e Vídeo
  navigator.getMedia = ( navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia || navigator.msGetUserMedia);
  navigator.getMedia (
    // permissoes
    {
      video: true,
      audio: true
    },
    // callbackSucesso
    function(localMediaStream) {
      // var video = document.querySelector('video');
      // video.srcObject = localMediaStream;
      // video.onloadedmetadata = function(e) {
      // };
      $('#permissaoativa').show();
      $('#permissaonegada').hide();
      console.log("Permissão áudio e video OK!");
    },
    // callbackErro
    function(err) {
      $('#permissaonegada').show();
      $('#permissaoativa').hide();
      console.log("Áudio e Vídeo erro: " + err);
      var video = document.querySelector('video');
    }
  );
  // MostraConfigCorrect
  function MostraConfigCorrect() {
    $('#collapseConf').show();
  }
  // Detecta navegador
  var es_chrome  = navigator.userAgent.toLowerCase (). indexOf ('chrome')> -1; 
  if (es_chrome) {
    console.log ("O navegador usado é o Chrome"); 
  } else {
    $('#chrome').show();
  }
</script>

