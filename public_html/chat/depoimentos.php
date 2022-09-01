<?php
session_start();
require_once "/home/epapodetarotcom/public_html/includes/conexaoPdo.php";
require_once "/home/epapodetarotcom/public_html/includes/functions.php";
date_default_timezone_set("Brazil/East"); // seta configurações fusuhorario para Brasil
ini_set ('default_charset', 'UTF-8'); // seta o php em UTF 8
if (!empty($_SESSION["id_usuario_logado"])){
  $id_tarologo = $_SESSION['id_tarologo'];
  $id_cliente  = $_SESSION['id_cliente'];
} else {
  $id_tarologo = $_GET['id_tarologo'];
  $id_cliente  = $_GET['id_cliente'];
  $id_usuario_logado = $_GET['id_usuario_logado'];
}
if (empty($id_cliente)) {
  echo '<script>document.location.href="https://www.epapodetarot.com.br/"</script>';
}
$pdo = conexao();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8"/>
  <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
  <title>Finalizando Consulta</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <link rel="stylesheet" type="text/css" href="https://www.epapodetarot.com.br/scripts/bootstrap3/css/bootstrap.css"/>
  <link rel="stylesheet" type="text/css" href="https://www.epapodetarot.com.br/scripts/bootstrap3/css/bootstrap-theme.min.css"/>
  <link rel="shortcut icon" href="https://www.epapodetarot.com.br/images/favicon.ico" />
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
        color: #000;
        font-size: 18px;
    }
    #corpo {
        background: rgb(255 241 233); 
        padding: 20px;
        color:#000;
        border: none;
    }
    #carregando {
        margin-left: 50%;
        margin-top: 20%;
        color: #000;
    }
    .title {
        color: #000;
    }
    .text-success {
        color:#c31200;
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

        <h1 class="title">Consulta Finalizada</h1>

        <div id="corpo" class="card card-body">

          <h3 class="text-success">Deixe Seu Depoimento Para Este Atendimento:</h3>

          <?php 
          $sql = $pdo->query("SELECT * FROM clientes WHERE id='$id_tarologo'");
          $row = $sql->rowCount();
          if ($row > 0) {
            while ($mostrar = $sql->fetch(PDO::FETCH_ASSOC)) { 
              $nome=$mostrar['nome'];
              $especialidades=$mostrar['especialidade_taro'];
              $logo=$mostrar['logo'];
              $descricaocurta = $mostrar['infos2'];
              $descricaocurta = strip_tags($descricaocurta);
              $descricaocurta = strip_tags(limita_caracteres($descricaocurta, 300, true));
            }
            ?>

            <p><img src="https://www.epapodetarot.com.br/tarologos_admin/fotos/<?php echo $logo; ?>" class="img-rounded" style="max-width:200px; margin: 15px 15px 15px 0px;"/></p>
            <h3 class="text-success"> <?php echo $nome; ?></h3>
            <p><?php echo $especialidades; ?></br>
            <?php
          } 
          ?>

          <h3 class="text-success">O que você achou da consulta com <?php echo $nome; ?>?</h3>

          <form name="tarologos" method="post" action="https://www.epapodetarot.com.br/chat/sub_depo.php" class="form-horizontal">

            <input type="hidden" name="id_tarologos" value="<?php echo $id_tarologo; ?>">
            <input type="hidden" name="id_cliente" value="<?php echo $id_cliente; ?>">

            <div class="form-group" >
              <label for="mensagem" class="col-sm-2 control-label"></label>
              <div class="col-sm-10">
                <p><input type="radio" class=""  name="pontuacao" value="Péssimo" /> Péssimo <span class="glyphicon glyphicon-star-empty" aria-hidden="true"></span></p>
                <p><input type="radio" class=""  name="pontuacao" value="Ruim" /> Ruim <span class="glyphicon glyphicon-star-empty" aria-hidden="true"></span><span class="glyphicon glyphicon-star-empty" aria-hidden="true"></span></p>
                <p><input type="radio" class=""  name="pontuacao" value="Normal" /> Normal <span class="glyphicon glyphicon-star-empty" aria-hidden="true"></span><span class="glyphicon glyphicon-star-empty" aria-hidden="true"></span><span class="glyphicon glyphicon-star-empty" aria-hidden="true"></span></p>
                <p><input type="radio" class=""  name="pontuacao" value="Bom" /> Bom <span class="glyphicon glyphicon-star-empty" aria-hidden="true"></span><span class="glyphicon glyphicon-star-empty" aria-hidden="true"></span><span class="glyphicon glyphicon-star-empty" aria-hidden="true"></span><span class="glyphicon glyphicon-star-empty" aria-hidden="true"></span></p>
                <p><input type="radio" class=""  name="pontuacao" value="Excelente" /> Excelente <span class="glyphicon glyphicon-star-empty" aria-hidden="true"></span><span class="glyphicon glyphicon-star-empty" aria-hidden="true"></span><span class="glyphicon glyphicon-star-empty" aria-hidden="true"></span><span class="glyphicon glyphicon-star-empty" aria-hidden="true"></span><span class="glyphicon glyphicon-star-empty" aria-hidden="true"></span></p>
              </div>
            </div>

            <div class="form-group">
              <label for="mensagem" class="col-sm-2 control-label">Mensagem</label>
              <div class="col-sm-10">
                <textarea name="mensagem" class="form-control"/></textarea>
              </div>
            </div>

            <div class="form-group">
              <label for="" class="col-sm-2 control-label"></label>
              <div class="col-sm-10">
                <input class="btn btn-success" type="submit" name="envia" value="Enviar Mensagem"/>
                <input class="btn btn-info" type="button" name="Cancel" value="Cancelar" onclick="window.location = 'https://www.epapodetarot.com.br/minha-conta' " /> 
              </div>
            </div>

          </form>

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