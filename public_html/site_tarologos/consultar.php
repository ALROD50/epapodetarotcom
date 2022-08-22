<?php 
date_default_timezone_set("Brazil/East");
ini_set ('default_charset', 'UTF-8');
ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);
?>
<h1 class="text-success"><i class="fas fa-comments"></i> Consultar</h1>
<hr>

<?php
@$videochat = $_POST['videochat'];
@$id_tarologo = $_POST['id_tarologo'];
if (empty($id_tarologo)) { $id_tarologo = $_GET['id_tarologo']; }

$tarologo_online = $pdo->query("SELECT * FROM clientes WHERE id='$id_tarologo' "); 
  while ($mostrar = $tarologo_online->fetch(PDO::FETCH_ASSOC)){ 
  $alias=$mostrar['alias'];
}
$cliente_online  = null;
$cliente_credito = null;
$cliente_entrou  = null;

if ($row_onlinex == "offline" OR $row_onlinex == "") {
  echo "<script>document.location.href='https://www.epapodetarot.com.br/comprar-consulta/$alias/chat/?msgs=Ótima Escolha!, Vamos Realizar Sua Consulta!'</script>";
} else {
  $cliente_online = 'positivo';
}

//Verifica se cliente tem crédito
$sql_credito = $pdo->query("SELECT COALESCE(SUM(minutos_dispo), 0) as soma FROM controle WHERE id_nome_cliente='$usuario_id' AND status='PAGO' ");
$cont = $sql_credito->fetch(PDO::FETCH_ASSOC);
$valor = $cont["soma"];
//converter minutos em segundos
$valor = $valor * 60;

if ($valor <= 0) {
  echo "<script>document.location.href='https://www.epapodetarot.com.br/comprar-consulta/$alias/chat/?msge=Você não tem minutos suficientes para essa consulta.<br>Compre um pacote aqui, nesta página!'</script>";
} else {
  $cliente_credito = 'positivo';
}

//Verifica se tarólogo esta online.
$tarologo_online = $pdo->query("SELECT * FROM clientes WHERE id='$id_tarologo' "); 
  while ($mostrar = $tarologo_online->fetch(PDO::FETCH_ASSOC)){ 
  $row_tarologo=$mostrar['online'];
}

if ($row_tarologo == "offline" OR $row_tarologo == "") {    
  echo "<script>document.location.href='https://www.epapodetarot.com.br/tarologos/?msge=Este tarólogo esta Offline no momento.<br>Escolha outro abaixo:'</script>";
  $tarologo_online = 'negativo';

} elseif ($row_tarologo == "ocupado") {
  echo "<script>document.location.href='https://www.epapodetarot.com.br/tarologos/?msge=Este tarólogo esta Ocupado no momento.<br>Escolha outro abaixo:'</script>";
  $tarologo_online = 'negativo';

} elseif ($row_tarologo == "online") {
  $tarologo_online = 'positivo';
}

// Verifica se esse cliente não esta com outro atendimento Aberto.
$sql = $pdo->query("SELECT * FROM chamada_consulta WHERE id_cliente='$usuario_id' AND tarologo_entrou='TAROLOGOENTROU'"); 
$row = $sql->rowCount();
if ($row > 0){
  echo "<script>document.location.href='https://www.epapodetarot.com.br/minha-conta/?msge=Identificamos um atendimento anterior em andamento.<br>Por gentileza, aguarde 1 minuto até que o atendimento anterior seja fechado. Após a finalização, você poderá abrir uma nova consulta normalmente.'</script>";
  $tarologo_online = 'negativo';
  exit();
} else {
  $tarologo_online = 'positivo';
}

// Chamar Tarologo
if ($cliente_online == 'positivo' AND $cliente_credito == 'positivo' AND $tarologo_online == 'positivo'){

  // Se cliente tentar chamar tarólogo de novo, adiciona o videochat
  if (@$_GET['videochat']) {
    $videochat = @$_GET['videochat'];
  }

  // Grava no banco chamada_consulta, cliente_chamando.
  $queryInsert = $pdo->query("INSERT INTO chamada_consulta (
    id_cliente,
    id_tarologo,
    cliente_chamando,
    tempo,
    videochat
  ) VALUES (
    '$usuario_id',
    '$id_tarologo',
    'cliente_chamando',
    '$valor',
    '$videochat'
  )");

  // Código do registro
  $cod_sala = $pdo->lastInsertId();

  // Se cliente tentar chamar tarólogo de novo, excluir a ultima chamada
  $cod_ant = @$_GET['cod_ant'];
  if ($cod_ant != "") {
    $Delete=$pdo->prepare("DELETE FROM chamada_consulta WHERE id=:id")->execute(array(':id' => $cod_ant));
  }
  
  // Mostra mensagem para o cliente de que o sistema esta chamando o tarólogo.
  ?>
    <div id="chamando_tarologo">
      <div class="alert alert-warning" role="alert">
      <button type="button" class="close" data-dismiss="alert">×</button>
        <h2><div class='spinner-border pull-right' role='status'><span class='sr-only'>Loading...</span></div> Chamando Tarólogo!</h2>
        <p>Aguarde... estamos contactando o tarólogo... não feche essa página... </p>
        <!-- Barra de Progresso -->
        <div id="progress" class="progress">
          <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="min-width: 100%;"></div>
        </div>
        <video height="1" width="1" autoplay="" loop="" muted="" controls="">
          <source src="https://www.epapodetarot.com.br/blackvideo.mp4">
        </video>
        <!-- Necessário para barra de progresso e funções ocultar -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
        <script src="https://www.epapodetarot.com.br/scripts/bar_progress/jquery.progresstimer.js"></script>
        <script type="text/javascript">
          // ###################################    WebSocket     ####################################################

          // Conecta o cliente no servidor com WebSocket para fazer a chamada
          var conn = new WebSocket('wss://epapodetarot.com.br/wss2/NNN');
          // Abre Conexão
          conn.onopen = function(e) {
            console.log("Connection established!");
          };
        
          // Variaveis da chamada
          var id_tarologo = "<?php echo $id_tarologo; ?>";
          
          // Fazendo chamada
          var msg = {
            'tipo': 'iniciachat',
            'id_tarologo': id_tarologo
          };
          msg = JSON.stringify(msg);

          // Envia, o método abaixo espera até que a conexão com o websocket se estabeleça antes de enviar a mensagem 
          conn.onopen = () => conn.send(msg);

          var intervalo = setInterval(function(){
            $.post('https://www.epapodetarot.com.br/site_tarologos/chama_chat.php',
              {
                id_tarologo: '<?php echo $id_tarologo; ?>',
                id_cliente: '<?php echo $usuario_id; ?>',
                cod_sala: '<?php echo $cod_sala; ?>'
              }, function(retorno){
                $("#verifica_chamada_tarologo_cliente_chama").html(retorno);
            });
          }, 5000);

          // ###################################    WebSocket     ####################################################

          var progress = $(".progress-bar").progressTimer({
            timeLimit: 30,
            onFinish: function () {
              // Depois de 30 segundo oculta as divis, mostra a mensagem, deleta a chamada e para de executar a pesquisa
              $("#chamando_tarologo").hide();
              $("#verifica_chamada_tarologo_cliente").hide();
              $("#tarologo_nao_atendeu").show();
              // Deletar chamada do banco caso tarólogo não tenha atendido.
              $.post('https://www.epapodetarot.com.br/site_tarologos/deleta_chamada_n_at.php',
              {
                usuario_id : '<?php echo $usuario_id; ?>'
              }, 
              function(retorno){
                $("#verifica_chamada_tarologo_cliente").html(retorno);
              });
            }
          });
        </script>
        <!-- Barra de Progresso -->
      </div>
    </div>

    <div id="verifica_chamada_tarologo_cliente_chama"></div>

    <div id="verifica_chamada_tarologo_cliente"></div>

    <!-- Se depois de 30 segundos, o tarólogo não tiver atendido -->
    <div id="tarologo_nao_atendeu" style="display:none;">
      <div class="alert alert-danger" role="alert">
        <button type="button" class="close" data-dismiss="alert">×</button>
          <h2 style="color: #a94442;">Seu tarólogo não atendeu...</h2>
          <p>Você pode fazer uma nova tentativa clicando no botão abaixo ou <a href="tarologos">escolher outro tarólogo.</a></p>
        </div>
        <?php echo '<a button class="btn btn-success" href="consultar/?id_tarologo='.$id_tarologo.'&cod_ant='.$cod_sala.'&videochat='.$videochat.'  "><i class="fas fa-undo-alt"></i> Tentar Novamente!</button></a>'; ?>
    </div>

  <?php
}