<?php 
date_default_timezone_set("Brazil/East"); // seta configurações fusuhorario para Brasil
ini_set ('default_charset', 'UTF-8'); // seta o php em UTF 8
ini_set('display_errors',1); // Força o PHP a mostrar os erros.
ini_set('display_startup_erros',1); // Força o PHP a mostrar os erros.
error_reporting(E_ALL); // Força o PHP a mostrar os erros.
//phpinfo();
#### Recupera Cookies -----------------------------------
@$usuario_id     = $_COOKIE["UsuarioID"];
@$usuario_nome   = $_COOKIE["UsuarioNome"];
@$usuario_nivel  = $_COOKIE["UsuarioNivel"];
@$usuario_status = $_COOKIE["UsuarioStatus"];
#### Recupera Cookies -----------------------------------
require_once "/home/tarotdehoruscom/public_html/includes/conexaoPdo.php";
$pdo = conexao();

$id_tarologo = $_POST['id_tarologo'];
$sql = $pdo->query("SELECT * FROM clientes WHERE nivel='TAROLOGO' AND id ='$id_tarologo' "); 
$row = $sql->rowCount();
$sql = $pdo->query("SELECT * FROM clientes WHERE nivel='TAROLOGO' AND id ='$id_tarologo' ");
$row = $sql->rowCount();

if ($row > 0){

  while ($mostrar = $sql->fetch(PDO::FETCH_ASSOC)){ 
  $id_tarologo=$mostrar['id'];
  $nome=$mostrar['nome'];
  $especialidades=$mostrar['especialidade_taro'];
  $infos=$mostrar['infos'];
  $logo=$mostrar['logo'];

  //Verificando se tarólogo esta online.
  $sql_online = $pdo->query("SELECT * FROM clientes WHERE id='$id_tarologo' ");
  while ($mostrar = $sql_online->fetch(PDO::FETCH_ASSOC)){ 
    $row_online=$mostrar['online'];
  }
  if ($row_online == "offline" OR $row_online == ""){ 
    $online = '<span style="color: #666; font-weight: bold;">OFFLINE</span>';
  } elseif ($row_online == "online") {
    $online = '<span style="color: #669900; font-weight: bold;">ONLINE</span>';
  } elseif ($row_online == "ocupado") {
    $online = '<span style="color: #000000; font-weight: bold;">OCUPADO</span>';
  }
  ?>

  <h1><?php echo $nome; ?></h1>

  <p><span style="color: #753a4a; font-weight: bold;">Status:</span> <?php echo $online; ?></p>

  <div style="clear:both;"></div>

  <div style="float:left; margin: 15px 15px 15px 0px; max-width:400px;">
    <figure class="figure">
      <img src="admin/tarologos/fotos/<?php echo $logo; ?>" class="img-rounded" alt="<?php echo $nome;?>" title="<?php echo $nome;?>">
      <figcaption class="figure-caption">
        <form name="Consultar" id="Consultar<?php echo @$id; ?>" method="post" action="index.php/consultar" style="margin-top:10px;">
          <input type="hidden" name="id_tarologo" value="<?php echo @$id_tarologo; ?>" />
          <input type="hidden" name="id_cliente" value="<?php echo @$usuario_id; ?>" />
          <input type="hidden" name="usuario_nome" value="<?php echo @$usuario_nome; ?>" />
          <button type="submit" name="envia" class="btn btn-lg btn-success registro img-rounded"><i class="glyphicon glyphicon-comment"></i> CONSULTAR CHAT</button>
        </form>
      </figcaption>
    </figure>
  </div>

  <?php echo $infos; ?>

  <p style="font-size:30px; color: #9e3434;"><b>ORÁCULOS</b>:</p>
  
  <p><?php echo $especialidades;?></p>

  <form name="consultarporemail" id="consultarporemail" method="post" action="consultarporemail" style="float:left; margin-right:8px;">
    <button type="submit" name="envia" class="btn btn-xs btn-default registro img-rounded" alt="Consultar por E-mail" title="Consultar por E-mail"><i class="glyphicon glyphicon-envelope"></i> Consultar por E-mail</button>
    <!-- <input class="aconsultarporemail_icone_estilo" type="submit" name="envia" alt="Consultar por E-mail" title="Consultar por E-mail" value=""/> -->
    <input type="hidden" name="id_tarologo" value="<?php echo $id_tarologo; ?>" />
  </form>

  <form name="aviseme_envia" id="aviseme_envia" method="post" action="aviseme">
    <button type="submit" name="envia" class="btn btn-xs btn-default registro img-rounded" alt="Avise-me Quando Disponível" title="Avise-me Quando Disponível"><i class="glyphicon glyphicon-time"></i> Avise-me Quando Disponível</button>
    <!-- <input class="aviseme_icone_estilo" type="submit" name="envia" alt="Avise-me Quando Disponível" title="Avise-me Quando Disponível" value=""/> -->
    <input type="hidden" name="id_tarologo" value="<?php echo $id_tarologo; ?>" />
  </form>

  <div style="clear:both;"></div>

  <hr style="border: 1px solid #ccc;">

    <h1>DEPOIMENTOS</h1>

    <?php

    //Estanciando dados dos depoimentos
    $executa = $pdo->query("SELECT * FROM depoimentos WHERE id_tarologo='$id_tarologo' AND habilitado='SIM' ");
    $encontrados = $executa->rowCount();

    while ($dadoss= $executa->fetch(PDO::FETCH_ASSOC)){ 

      $id_tarologo=$dadoss['id_tarologo'];
      $id_cliente=$dadoss['id_cliente'];
      $mensagem=$dadoss['mensagem'];
      $pontuacao=$dadoss['pontuacao'];

      //Estancia dados do cliente
      $dadoss3 ="SELECT * FROM clientes WHERE id='$id_cliente'"; 
      $executa3 = $pdo->query($dadoss3);
        while ($dadoss3= $executa3->fetch(PDO::FETCH_ASSOC)){
        $cliente_id=$dadoss3['id'];
        $cliente_nome=$dadoss3['nome'];
      } ?>

        <div class="card card-body" id="depoimento" style="background: transparent;">
            
            <div style="float:right;">
                <span style="color: #000;">
                    <?php echo '<b>Pontuação:</b> '.$pontuacao; ?>
                </span>
            </div>

            <div style="font-size:13px; color: #000; font-weight: 700;">
                <p><?php //echo @$cliente_nome; ?></p>
            </div>

            <?php echo $mensagem; ?>

        </div>

        <div style="clear:both;" style="height: 15px;"></div>

  <?php } 

    if ($encontrados == 0) {
       
       echo '<p>';
       echo '(0) depoimentos...';
       echo '</p>';
    }

  ?>

  <?php } 
  
    } else {
        echo 'Nenhum resultado encontrado...';
      }
?>