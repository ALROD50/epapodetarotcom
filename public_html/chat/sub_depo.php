<?php
session_start();
// DELETANDO O COOKIE E A SESSION
unset($_SESSION[cod_sala]);
unset($_SESSION[nome]);
unset($_SESSION[id_usuario_logado]);
unset($_SESSION[user_nivel]);
unset($_SESSION[credito]);
unset($_SESSION[id_tarologo]);
unset($_SESSION[id_cliente]);
unset($_SESSION[nome_tarologo]);
unset($_SESSION[nome_cliente]);
require_once "/home/epapodetarotcom/public_html/includes/conexaoPdo.php";
$pdo = conexao();
date_default_timezone_set("Brazil/East"); // seta configurações fusuhorario para Brasil
ini_set ('default_charset', 'UTF-8'); // seta o php em UTF 8
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8"/>
  <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
  <title>Finalizando Consulta</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <link rel="stylesheet" type="text/css" href="../scripts/bootstrap3/css/bootstrap.css"/>
  <link rel="stylesheet" type="text/css" href="../scripts/bootstrap3/css/bootstrap-theme.min.css"/>
  <link rel="shortcut icon" href="../images/favicon.ico" />
</head>
<style type="text/css">
    *{
        /*margin:0;padding:0;*/
    }
    html,body{
        /*overflow:hidden;*/
    }
    body {
        background: #1b2933 url('https://www.epapodetarot.com.br/images/crop.png') 50% 0 fixed no-repeat !important;
        background-size: 1920px 1169px;
        background-size: cover !important;
        color: #fff;
        font-size: 18px;
    }
    #corpo {
        background: rgba(0, 0, 0, 0.4); 
        padding: 20px;
        color:#fff;
        border: none;
    }
    #carregando {
        margin-left: 50%;
        margin-top: 20%;
        color: #fff;
    }
    .title {
        color: #fff;
        text-shadow: 0 0 6px rgba(255,144,0,0.5);
    }
    .text-success {
        color: #f8b334;
    }
</style>
<body>

<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">
      
      <div class="col-md-2"></div>
      
      <div class="col-md-8">
        
        <div style="margin-top: 30px; margin-bottom:30px;">
          <img src="https://www.epapodetarot.com.br/images/Logo-Site.fw.png" alt="É Papo de Tarot" style="max-width: 100%;">
        </div>

        <h1 class="title">Finalizando Consulta</h1>
        
        <div id="corpo" class="card card-body">
          <?php 
          function MsgSucesso ($msgs) { ?>
          <div class="alert alert-success" role="alert">
          <button type="button" class="close" data-dismiss="alert">×</button>
            <h4>Depoimento Criado Com Sucesso!</h4>
            <?php echo $msgs; ?>
          </div> <?php 
          }

          if(isset($_POST['envia'])){

              $id_tarologo = $_POST['id_tarologos'];
              $id_cliente = $_POST['id_cliente'];
              $mensagem = $_POST['mensagem'];
              $pontuacao = $_POST['pontuacao'];
              $data_hoje = date('Y-m-d H:i:s');

              $pdo->query("INSERT INTO depoimentos (
                id_tarologo,
                id_cliente,
                mensagem,
                pontuacao,
                habilitado,
                data
              ) VALUES (
                '$id_tarologo',
                '$id_cliente',
                '$mensagem',
                '$pontuacao',
                'NAO',
                '$data_hoje'
              )");

              $msgs = "Sua mensagem foi enviada e será processada, obrigado e volte sempre!";
              MsgSucesso ($msgs);
              echo '<a button class="btn btn-primary" href="https://www.epapodetarot.com.br/"> Voltar ao Site</button></a>';
            }
          ?> 
        </div>

        <br>
        <br>

      </div>
      
      <div class="col-md-2"></div>
    
    </div>  
  </div>
</div>

</body>
</html>
