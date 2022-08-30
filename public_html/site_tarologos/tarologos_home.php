<div id="myCarousel" class="carousel slide" data-ride="carousel" style="margin:-15px; margin-bottom: 20px;">
  <ol class="carousel-indicators">
    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
    <li data-target="#myCarousel" data-slide-to="1"></li>
    <li data-target="#myCarousel" data-slide-to="2"></li>
  </ol>
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="images/slideshow/1.png" alt="É Papo de Tarot" title="É Papo de Tarot" width="1110" height="512" style="opacity: 100%;"/>
      <div class="container">
        <div class="carousel-caption text-left" style="right:5%;left:5%">
          <h1 class="text-white sombratexto">TAROT</h1>
          <!-- <h3 class="text-white sombratexto">Disponibilizamos videochamadas no site, aproveite e tenha novas experiências na sua consulta.</h3> -->
          <!-- <p><a class="btn btn-lg btn-primary" href="tarologos" role="button"><i class="fas fa-angle-double-right"></i> CLIQUE AQUI</a></p> -->
        </div>
      </div>
    </div>
    <div class="carousel-item">
      <img src="images/slideshow/2.png" alt="É Papo de Tarot" title="É Papo de Tarot" width="1110" height="512" style="opacity: 100%;"/>
      <div class="container">
        <div class="carousel-caption text-left" style="right:5%;left:5%">
          <h1 class="text-white sombratexto">BARALHO CIGANO</h1>
          <!-- <h3 class="text-white sombratexto">Amplie o seu autoconhecimento no processo da sua vida, atinja o bem estar biopsiquisocial e espiritual.</h3> -->
          <!-- <p><a class="btn btn-lg btn-primary" href="tarologos" role="button"><i class="fas fa-angle-double-right"></i> CLIQUE AQUI</a></p> -->
        </div>
      </div>
    </div>
    <div class="carousel-item">
      <img src="images/slideshow/3.png" alt="É Papo de Tarot" title="É Papo de Tarot" width="1110" height="512" style="opacity: 100%;"/>
      <div class="container">
        <div class="carousel-caption text-left" style="right:5%;left:5%">
          <h1 class="text-white sombratexto">TAROT DE MARSELHA</h1>
          <!-- <h3 class="text-white sombratexto">Abra os seus caminhos para um novo amor ou melhore o seu relacionamento, através das previsões dos oráculos.</h3> -->
          <!-- <p><a class="btn btn-lg btn-primary" href="tarologos" role="button"><i class="fas fa-angle-double-right"></i> CLIQUE AQUI</a></p> -->
        </div>
      </div>
    </div>
  </div>
  <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>

<center>
  <h2 style="margin-top:0px;" class="vinho">Fale Com Um Tarólogo Online!</h2>
</center>

<div style="padding: 30px; background-image: url('images/bgbanner.png');background-size:1150px 1115px;background-repeat: no-repeat;background-attachment: fixed;background-position: center;border: none; color:#c69e88;">
  <center><h2>Como funciona?</h2></center>
  <div class="row">
    <div class="col-md-4">
      <center>
        <p><a href="/registre-se" style="color:#c69e88;"><span class="badge badge-primary" style="font-size:20px; font-weight:normal;">1ª Passo:</span></a><br>
        <i class="fas fa-user-plus"></i> <a href="/registre-se" style="color:#c69e88;">Cadastre-se </a></p>
      </center>
    </div>
    <div class="col-md-4">
      <center>
        <p><a href="/comprar-consulta" style="color:#c69e88;"><span class="badge badge-warning" style="font-size:20px; font-weight:normal;">2ª Passo:</span></a><br>
        <i class="fas fa-credit-card"></i> <a href="/comprar-consulta" style="color:#c69e88;">Compre Minutos </a></p>
      </center>
    </div>
    <div class="col-md-4">
      <center>
        <p><a href="/tarologos" style="color:#c69e88;"><span class="badge badge-success" style="font-size:20px; font-weight:normal;">3ª Passo:</span></a><br>
        <i class="fas fa-comment-dots"></i> <a href="/tarologos" style="color:#c69e88;">Escolha o Tarólogo </a></p>
      </center>
    </div>
  </div>
</div>

<hr>

<center>
  <h2 style="margin-top:0px;" class="vinho">Profissionais</h2>
  <p>Nossas consultas são feitas online e temos diversos especialistas na sua área. Pode ser útil para você não ter que aguardar para agendar.</p>
</center>

<hr>

<?php 
// Deleta a chamada anterior para entrar no chat 
$pdo->query("DELETE FROM chamada_consulta WHERE id_cliente='$usuario_id'");
?>

<div class="row" style="padding:0px;margin:0px;">
  <?php
  // Tarólogos online
  $result = $pdo->query("SELECT * FROM clientes WHERE nivel = 'TAROLOGO' AND status='ATIVO' AND online='online' ORDER BY RAND()");
  $row_online = $result->rowCount();
  while ($mostrar2 = $result->fetch(PDO::FETCH_ASSOC)){
    $id_tarologo2=$mostrar2['id'];
    $nome2=$mostrar2['nome'];
    $alias=$mostrar2['alias'];
    $especialidades2=utf8_decode($mostrar2['especialidade_taro']);
    $infos2=$mostrar2['infos'];
    $descricaocurta=$mostrar2['infos2'];
    $descricaocurta = strip_tags($descricaocurta);
    $descricaocurta = strip_tags(limita_caracteres($descricaocurta, 250, true));
    $logo2=$mostrar2['logo'];
    $videochamada=$mostrar2['videochamada'];
    // Verificando se tarólogo esta online.
    $sql_online2 = $pdo->query("SELECT * FROM clientes WHERE id='$id_tarologo2' ");
    while ($mostrar22 = $sql_online2->fetch(PDO::FETCH_ASSOC)){ 
      $row_online2=$mostrar22['online'];
    }
    // Número de consultas
    $sql = $pdo->query("SELECT * FROM atendimento WHERE id_tarologo='$id_tarologo2'");
    $numero_consultas = $sql->rowCount();
    ?>
    <div id="tarologoshomeresultado" class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-xs-12" style="margin-bottom:15px;">
      
      <!-- Foto, nome e oraculos -->
      <div style="background-image: url('images/bg_tarologo.png');border-radius:25px;box-shadow: 0 .5rem 1rem rgba(0,0,0,.55)!important;" class="shadow">
        
        <div id="nome" class="" style="padding-top: 45px;">
          <center>
            <form method="post" action="tarologo/<?php echo $alias; ?>">
              <input style="background: transparent;border: none;font-size: 35px;color: #ffffff;" class="efeitodois" type="submit" name="envia" alt="<?php echo $nome2;?>" title="<?php echo $nome2;?>" value="<?php echo $nome2; ?>"/>
              <input type="hidden" name="id_tarologo" value="<?php echo $id_tarologo2; ?>" />
            </form>
          </center>
        </div>
        
        <div id="foto" class="" style="display:block;">
          <center>
            <a href="tarologo/<?php echo $alias; ?>"><img src="tarologos_admin/fotos/<?php echo $logo2; ?>" style="max-width:100%" layout="responsive" class="efeitodois" alt="<?php echo $nome2;?>" title="<?php echo $nome2;?>"></img></a>
          </center>
        </div>

        <div id="oraculos" style="margin: 0px;font-size:19px;padding: 10px 10px 0 10px;color: #000000;height:188px;background: #ffffff91;">
          <center>
            <p><?php echo $descricaocurta; ?></p>
          </center>
        </div>
              
        <!-- Botão Ver Perfil -->
        <div class="mb-2">
          <!-- <a href="tarologo/<?php //echo $alias; ?>" button class="btn btn-dark btn-lg btn-block"><i class="far fa-address-card"></i> Ver Perfil</a> -->
          <div class="card badge-dark corpadrao2">
            <center>
              <h3 class="pt-2">
                <?php if ($videochamada=="SIM") { ?>
                  <i class="fas fa-video laranja"></i> VideoChamada
                  <?php } ?>
                  <i class="fas fa-comments verdao"></i> Chat 
              </h3>
            </center>
          </div>
        </div>
        
        <!-- Verificando se tarólogo esta online ou não -->
        <?php
        if ($row_online2 == "offline" OR $row_online2 == ""){
          ?>
          <!-- Botão Avise-me Quando Disponível -->
          <div class="mb-2">
            <form method="post" action="aviseme-quando-disponivel" name="aviseme_envia" id="aviseme_envia">
              <button type="submit" class="btn btn-info btn-lg btn-block corpadrao2" name="envia" id="envia"><i class="fas fa-clock"></i> Avise-Me!</button>
              <input type="hidden" name="id_tarologo" value="<?php echo $id_tarologo2; ?>" />
            </form>
          </div>
          <?php
          
        } elseif ($row_online2 == "online") {
          
          ?>
          <!-- Botão Consultar Agora -->
          <div class="mb-2">
            <a href="tarologo/<?php echo $alias; ?>" button class="btn btn-success btn-lg btn-block"><i class="fas fa-comments"></i> Consultar Agora</a>
          </div>
          <!-- <div class="mb-2">
            <form method="post" action="consultar" id="consultachat<?php //echo $id_tarologo2; ?>">
              <button type="submit" class="btn btn-success btn-lg btn-block" name="envia" id="envia"><i class="fas fa-comments"></i> Consultar Agora</button>
              <input type="hidden" name="id_tarologo" value="<?php //echo $id_tarologo2; ?>" />
            </form>
          </div> -->
          <?php
          
        } elseif ($row_online2 == "ocupado") {
          ?>
          <!-- Botão Ocupado -->
          <div class="mb-2">
            <button type="submit" class="btn btn-danger btn-lg btn-block" disabled><i class="fas fa-hourglass-start"></i> Estou Ocupado</button>
          </div>
          <?php 
        }
        ?>

        <div style="height:20px;"></div>
      </div>
    </div>
    <?php
  }
  // Tarólogos ocupado
  $result = $pdo->query("SELECT * FROM clientes WHERE nivel = 'TAROLOGO' AND status='ATIVO' AND online='ocupado' ORDER BY RAND()");
  $row_ocupado = $result->rowCount();
  while ($mostrar2 = $result->fetch(PDO::FETCH_ASSOC)){
    $id_tarologo2=$mostrar2['id'];
    $nome2=$mostrar2['nome'];
    $alias=$mostrar2['alias'];
    $especialidades2=$mostrar2['especialidade_taro'];
    $infos2=$mostrar2['infos'];
    $descricaocurta=$mostrar2['infos2'];
    $descricaocurta = strip_tags($descricaocurta);
    $descricaocurta = strip_tags(limita_caracteres($descricaocurta, 250, true));
    $logo2=$mostrar2['logo'];
    $videochamada=$mostrar2['videochamada'];
    // Verificando se tarólogo esta online.
    $sql_online2 = $pdo->query("SELECT * FROM clientes WHERE id='$id_tarologo2' ");
    while ($mostrar22 = $sql_online2->fetch(PDO::FETCH_ASSOC)){ 
      $row_online2=$mostrar22['online'];
    }
    // Número de consultas
    $sql = $pdo->query("SELECT * FROM atendimento WHERE id_tarologo='$id_tarologo2'");
    $numero_consultas = $sql->rowCount();
    ?>
    <div id="tarologoshomeresultado" class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-xs-12" style="margin-bottom:15px;">
      
      <!-- Foto, nome e oraculos -->
      <div style="background-image: url('images/bg_tarologo.png');border-radius:25px;box-shadow: 0 .5rem 1rem rgba(0,0,0,.55)!important;" class="shadow">
        
        <div id="nome" class="" style="padding-top: 45px;">
          <center>
            <form method="post" action="tarologo/<?php echo $alias; ?>">
              <input style="background: transparent;border: none;font-size: 35px;color: #ffffff;" class="efeitodois" type="submit" name="envia" alt="<?php echo $nome2;?>" title="<?php echo $nome2;?>" value="<?php echo $nome2; ?>"/>
              <input type="hidden" name="id_tarologo" value="<?php echo $id_tarologo2; ?>" />
            </form>
          </center>
        </div>
        
        <div id="foto" class="" style="display:block;">
          <center>
            <a href="tarologo/<?php echo $alias; ?>"><img src="tarologos_admin/fotos/<?php echo $logo2; ?>" style="max-width:100%" layout="responsive" class="efeitodois" alt="<?php echo $nome2;?>" title="<?php echo $nome2;?>"></img></a>
          </center>
        </div>

        <div id="oraculos" style="margin: 0px;font-size:19px;padding: 10px 10px 0 10px;color: #000000;height:188px;background: #ffffff91;">
          <center>
            <p><?php echo $descricaocurta;?></p>
          </center>
        </div>
              
        <!-- Botão Ver Perfil -->
        <div class="mb-2">
          <!-- <a href="tarologo/<?php //echo $alias; ?>" button class="btn btn-dark btn-lg btn-block"><i class="far fa-address-card"></i> Ver Perfil</a> -->
          <div class="card badge-dark corpadrao2">
            <center>
              <h3 class="pt-2">
                <?php if ($videochamada=="SIM") { ?>
                  <i class="fas fa-video laranja"></i> VideoChamada
                  <?php } ?>
                  <i class="fas fa-comments verdao"></i> Chat 
              </h3>
            </center>
          </div>
        </div>  
        
        <!-- Verificando se tarólogo esta online ou não -->
        <?php
        if ($row_online2 == "offline" OR $row_online2 == ""){
          ?>
          <!-- Botão Avise-me Quando Disponível -->
          <div class="mb-2">
            <form method="post" action="aviseme-quando-disponivel" name="aviseme_envia" id="aviseme_envia">
              <button type="submit" class="btn btn-info btn-lg btn-block corpadrao2" name="envia" id="envia"><i class="fas fa-clock"></i> Avise-Me!</button>
              <input type="hidden" name="id_tarologo" value="<?php echo $id_tarologo2; ?>" />
            </form>
          </div>
          <?php
          
        } elseif ($row_online2 == "online") {
          
          ?>
          <!-- Botão Consultar Agora -->
          <div class="mb-2">
            <a href="tarologo/<?php echo $alias; ?>" button class="btn btn-success btn-lg btn-block"><i class="fas fa-comments"></i> Consultar Agora</a>
          </div>
          <!-- <div class="mb-2">
            <form method="post" action="consultar" id="consultachat<?php //echo $id_tarologo2; ?>">
              <button type="submit" class="btn btn-success btn-lg btn-block" name="envia" id="envia"><i class="fas fa-comments"></i> Consultar Agora</button>
              <input type="hidden" name="id_tarologo" value="<?php //echo $id_tarologo2; ?>" />
            </form>
          </div> -->
          <?php
          
        } elseif ($row_online2 == "ocupado") {
          ?>
          <!-- Botão Ocupado -->
          <div class="mb-2">
            <button type="submit" class="btn btn-danger btn-lg btn-block" disabled><i class="fas fa-hourglass-start"></i> Estou Ocupado</button>
          </div>
          <?php 
        }
        ?>

        <div style="height:20px;"></div>
      </div>
    </div>
    <?php
  }
  // Tarólogos offline
  $total_mostrado = $row_online + $row_ocupado;
  $novo_limite = 30 - $total_mostrado;
  $result = $pdo->query("SELECT * FROM clientes WHERE nivel = 'TAROLOGO' AND status='ATIVO' AND online='offline' ORDER BY RAND() LIMIT $novo_limite");
  $row_offline = $result->rowCount();
  while ($mostrar2 = $result->fetch(PDO::FETCH_ASSOC)){
    $id_tarologo2=$mostrar2['id'];
    $nome2=$mostrar2['nome'];
    $alias=$mostrar2['alias'];
    $especialidades2=$mostrar2['especialidade_taro'];
    $infos2=$mostrar2['infos'];
    $descricaocurta=$mostrar2['infos2'];
    $descricaocurta = strip_tags($descricaocurta);
    $descricaocurta = strip_tags(limita_caracteres($descricaocurta, 250, true));
    $logo2=$mostrar2['logo'];
    $videochamada=$mostrar2['videochamada'];
    // Verificando se tarólogo esta online.
    $sql_online2 = $pdo->query("SELECT * FROM clientes WHERE id='$id_tarologo2' ");
    while ($mostrar22 = $sql_online2->fetch(PDO::FETCH_ASSOC)){ 
      $row_online2=$mostrar22['online'];
    }
    // Número de consultas
    $sql = $pdo->query("SELECT * FROM atendimento WHERE id_tarologo='$id_tarologo2'");
    $numero_consultas = $sql->rowCount();
    ?>
    <div id="tarologoshomeresultado" class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-xs-12" style="margin-bottom:15px;">
      
      <!-- Foto, nome e oraculos -->
      <div style="background-image: url('images/bg_tarologo.png');border-radius:25px;box-shadow: 0 .5rem 1rem rgba(0,0,0,.55)!important;" class="shadow">
        
        <div id="nome" class="" style="padding-top: 45px;">
          <center>
            <form method="post" action="tarologo/<?php echo $alias; ?>">
              <input style="background: transparent;border: none;font-size: 35px;color: #ffffff;" class="efeitodois" type="submit" name="envia" alt="<?php echo $nome2;?>" title="<?php echo $nome2;?>" value="<?php echo $nome2; ?>"/>
              <input type="hidden" name="id_tarologo" value="<?php echo $id_tarologo2; ?>" />
            </form>
          </center>
        </div>
        
        <div id="foto" class="" style="display:block;">
          <center>
            <a href="tarologo/<?php echo $alias; ?>"><img src="tarologos_admin/fotos/<?php echo $logo2; ?>" style="max-width:100%" layout="responsive" class="efeitodois" alt="<?php echo $nome2;?>" title="<?php echo $nome2;?>"></img></a>
          </center>
        </div>

        <div id="oraculos" style="margin: 0px;font-size:19px;padding: 10px 10px 0 10px;color: #000000;height:188px;background: #ffffff91;">
          <center>
            <p><?php echo $descricaocurta;?></p>
          </center>
        </div>
              
        <!-- Botão Ver Perfil -->
        <div class="mb-2">
          <!-- <a href="tarologo/<?php //echo $alias; ?>" button class="btn btn-dark btn-lg btn-block"><i class="far fa-address-card"></i> Ver Perfil</a> -->
          <div class="card badge-dark corpadrao2">
            <center>
              <h3 class="pt-2">
                <?php if ($videochamada=="SIM") { ?>
                  <i class="fas fa-video laranja"></i> VideoChamada
                  <?php } ?>
                  <i class="fas fa-comments verdao"></i> Chat 
              </h3>
            </center>
          </div>
        </div>  
        
        <!-- Verificando se tarólogo esta online ou não -->
        <?php
        if ($row_online2 == "offline" OR $row_online2 == ""){
          ?>
          <!-- Botão Avise-me Quando Disponível -->
          <div class="mb-2">
            <form method="post" action="aviseme-quando-disponivel" name="aviseme_envia" id="aviseme_envia">
              <button type="submit" class="btn btn-info btn-lg btn-block corpadrao2" name="envia" id="envia"><i class="fas fa-clock"></i> Avise-Me!</button>
              <input type="hidden" name="id_tarologo" value="<?php echo $id_tarologo2; ?>" />
            </form>
          </div>
          <?php
          
        } elseif ($row_online2 == "online") {
          
          ?>
          <!-- Botão Consultar Agora -->
          <div class="mb-2">
            <a href="tarologo/<?php echo $alias; ?>" button class="btn btn-success btn-lg btn-block"><i class="fas fa-comments"></i> Consultar Agora</a>
          </div>
          <!-- <div class="mb-2">
            <form method="post" action="consultar" id="consultachat<?php //echo $id_tarologo2; ?>">
              <button type="submit" class="btn btn-success btn-lg btn-block" name="envia" id="envia"><i class="fas fa-comments"></i> Consultar Agora</button>
              <input type="hidden" name="id_tarologo" value="<?php //echo $id_tarologo2; ?>" />
            </form>
          </div> -->
          <?php
          
        } elseif ($row_online2 == "ocupado") {
          ?>
          <!-- Botão Ocupado -->
          <div class="mb-2">
            <button type="submit" class="btn btn-danger btn-lg btn-block" disabled><i class="fas fa-hourglass-start"></i> Estou Ocupado</button>
          </div>
          <?php 
        }
        ?>

        <div style="height:20px;"></div>
      </div>
    </div>
    <?php 
  }
  ?>
</div>