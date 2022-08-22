<div style="clear:both; margin-top: 10px;"></div>

<center>
  <h2 style="margin-top:0px;color: #0e0c0c;text-shadow: 0px 2px 4px #da8345;"><i class="fas fa-comments"></i> Fale Com Um Tarólogo Online Agora!</h2>
  <h3 style="margin-top:0px;color: #963f10;text-shadow: 0px 2px 4px #da8345;">Acalme o seu coração e pergunte sobre a sua VIDA AMOROSA. Está a procura de um EMPREGO ou quer mudar de PROFISSÃO? Como anda a sua Saúde? Sua FAMÍLIA, como está?</h3>
  <h3 style="margin-top:0px;color: #636f03;text-shadow: 0px 2px 4px #da8345;">Os atendimentos ocorrem via Chat, E-mail ou WhatsApp, em texto. A consulta é SIGILOSA, você não aparece e poderá ficar mais à vontade para fazer as suas perguntas.</h3>
</center>

<div class="col-md-12" style="padding: 30px; background: #000 url('images/bgbanner.webp') 50% 0 fixed repeat; background-size:1150px 1115px; margin:10px;border: solid #cb6a1d; color:#fff;">
  <center><h2>Como funciona?</h2></center>
  <div class="row">
    <div class="col-md-4">
      <center>
        <p><a href="/registre-se" style="color:#fff;"><span class="badge badge-primary" style="font-size:20px; font-weight:normal;">1ª Passo:</span></a><br>
        <i class="fas fa-user-plus"></i> <a href="/registre-se" style="color:#fff;">Cadastre-se </a></p>
      </center>
    </div>
    <div class="col-md-4">
      <center>
        <p><a href="/comprar-consulta" style="color:#fff;"><span class="badge badge-warning" style="font-size:20px; font-weight:normal;">2ª Passo:</span></a><br>
        <i class="fas fa-credit-card"></i> <a href="/comprar-consulta" style="color:#fff;">Compre Minutos </a></p>
      </center>
    </div>
    <div class="col-md-4">
      <center>
        <p><a href="/tarologos" style="color:#fff;"><span class="badge badge-success" style="font-size:20px; font-weight:normal;">3ª Passo:</span></a><br>
        <i class="fas fa-comment-dots"></i> <a href="/tarologos" style="color:#fff;">Escolha o Tarólogo </a></p>
      </center>
    </div>
  </div>
</div>

<hr>

<center>
  <h2 style="margin-top:15px;color: #0e0c0c;text-shadow: 0px 2px 4px #da8345;"><i class="fab fa-gratipay"></i> Nossa Equipe de Profissionais</h2>
  <p>Escolha um TARÓLOGO e faça todas as perguntas com total sigilo e privacidade, nossa plataforma é de total segurança, fique tranquilo para perguntar sobre Amor, Trabalho, Saúde e tudo o mais que aflige o seu coração.</p>
</center>

<hr>

<div class="row" style="padding:0px;margin:0px;">
  <?php
  // Tarólogos online
  $result = $pdo->query("SELECT * FROM clientes WHERE nivel = 'TAROLOGO' AND status='ATIVO' AND online='online' ORDER BY nome ASC");
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
    // Verificando se tarólogo esta online.
    $sql_online2 = $pdo->query("SELECT * FROM clientes WHERE id='$id_tarologo2' ");
    while ($mostrar22 = $sql_online2->fetch(PDO::FETCH_ASSOC)){ 
      $row_online2=$mostrar22['online'];
    }
    // Número de consultas
    $sql = $pdo->query("SELECT * FROM atendimento WHERE id_tarologo='$id_tarologo2'");
    $numero_consultas = $sql->rowCount();
    ?>
    <div id="tarologoshomeresultado" class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-xs-12 shadow" style="margin-bottom:15px;">
      
      <!-- Foto, nome e oraculos -->
      <div style="background-image: url('images/bg_tarologo.jpg');">
        
        <div id="nome" class="" style="padding-top: 45px;">
          <center>
            <form method="post" action="tarologo/<?php echo $alias; ?>">
              <i class="fas fa-ankh"></i> <input style="background: transparent;border: none;font-size:30px;color: #0e0c0c;font-weight:800;text-shadow: 0px 2px 4px #da8345;" class="efeito" type="submit" name="envia" alt="<?php echo $nome2;?>" title="<?php echo $nome2;?>" value="<?php echo $nome2; ?>"/>
              <input type="hidden" name="id_tarologo" value="<?php echo $id_tarologo2; ?>" />
            </form>
          </center>
        </div>
        
        <div id="foto" class="" style="display:block;">
          <center>
            <form method="post" action="tarologo/<?php echo $alias; ?>">
              <input style="background: url('tarologos_admin/fotos/<?php echo $logo2;?>');width:90%;height:250px;margin-top:7px;border:none;background-size:cover;background-position:50% 50%;" class="rounded efeitodois" type="submit" name="envia" alt="<?php echo $nome2;?>" title="<?php echo $nome2;?>" value=""/>
              <input type="hidden" name="id_tarologo" value="<?php echo $id_tarologo2; ?>" />
            </form>
          </center>
        </div>
        <div id="oraculos" style="margin: 0px;font-size:19px;padding: 10px 10px 0 10px;color: #000000;height:188px;background: #ffffff91;">
          <center>
            <p><?php echo $descricaocurta; ?></p>
          </center>
        </div>
              
        <!-- Botão Ver Perfil -->
        <div class="mb-2">
          <a href="tarologo/<?php echo $alias; ?>" button class="btn btn-dark btn-lg btn-block"><i class="far fa-address-card"></i> Ver Perfil</a>
        </div>  
        
        <!-- Verificando se tarólogo esta online ou não -->
        <?php
        if ($row_online2 == "offline" OR $row_online2 == ""){
          ?>
          <!-- Botão Avise-me Quando Disponível -->
          <div class="mb-2">
            <form method="post" action="aviseme-quando-disponivel" name="aviseme_envia" id="aviseme_envia">
              <button type="submit" class="btn btn-info btn-lg btn-block" name="envia" id="envia"><i class="fas fa-clock"></i> Avise-Me!</button>
              <input type="hidden" name="id_tarologo" value="<?php echo $id_tarologo2; ?>" />
            </form>
          </div>
          <?php
          
        } elseif ($row_online2 == "online") {
          
          ?>
          <!-- Botão Consultar Agora -->
          <div class="mb-2">
            <form method="post" action="consultar" id="consultachat<?php echo $id_tarologo2; ?>">
              <button type="submit" class="btn btn-success btn-lg btn-block" name="envia" id="envia"><i class="fas fa-comments"></i> Consultar Agora</button>
              <input type="hidden" name="id_tarologo" value="<?php echo $id_tarologo2; ?>" />
            </form>
          </div>
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
  $result = $pdo->query("SELECT * FROM clientes WHERE nivel = 'TAROLOGO' AND status='ATIVO' AND online='ocupado' ORDER BY nome ASC");
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
    // Verificando se tarólogo esta online.
    $sql_online2 = $pdo->query("SELECT * FROM clientes WHERE id='$id_tarologo2' ");
    while ($mostrar22 = $sql_online2->fetch(PDO::FETCH_ASSOC)){ 
      $row_online2=$mostrar22['online'];
    }
    // Número de consultas
    $sql = $pdo->query("SELECT * FROM atendimento WHERE id_tarologo='$id_tarologo2'");
    $numero_consultas = $sql->rowCount();
    ?>
    <div id="tarologoshomeresultado" class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-xs-12 shadow" style="margin-bottom:15px;">
      
      <!-- Foto, nome e oraculos -->
      <div style="background-image: url('images/bg_tarologo.jpg');">
        
        <div id="nome" class="" style="padding-top: 45px;">
          <center>
            <form method="post" action="tarologo/<?php echo $alias; ?>">
              <i class="fas fa-ankh"></i> <input style="background: transparent;border: none;font-size:30px;color: #0e0c0c;font-weight: 800;text-shadow: 0px 2px 4px #da8345;" class="efeito" type="submit" name="envia" alt="<?php echo $nome2;?>" title="<?php echo $nome2;?>" value="<?php echo $nome2; ?>"/>
              <input type="hidden" name="id_tarologo" value="<?php echo $id_tarologo2; ?>" />
            </form>
          </center>
        </div>
        
        <div id="foto" class="" style="display:block;">
          <center>
            <form method="post" action="tarologo/<?php echo $alias; ?>">
              <input style="background: url('tarologos_admin/fotos/<?php echo $logo2;?>');width:90%;height:250px;margin-top:7px;border:none;background-size:cover;background-position:50% 50%;" class="rounded efeitodois" type="submit" name="envia" alt="<?php echo $nome2;?>" title="<?php echo $nome2;?>" value=""/>
              <input type="hidden" name="id_tarologo" value="<?php echo $id_tarologo2; ?>" />
            </form>
          </center>
        </div>
        <div id="oraculos" style="margin: 0px;font-size:19px;padding: 10px 10px 0 10px;color: #000000;height:188px;background: #ffffff91;">
          <center>
            <p><?php echo $descricaocurta;?></p>
          </center>
        </div>
              
        <!-- Botão Ver Perfil -->
        <div class="mb-2">
          <a href="tarologo/<?php echo $alias; ?>" button class="btn btn-dark btn-lg btn-block"><i class="far fa-address-card"></i> Ver Perfil</a>
        </div>  
        
        <!-- Verificando se tarólogo esta online ou não -->
        <?php
        if ($row_online2 == "offline" OR $row_online2 == ""){
          ?>
          <!-- Botão Avise-me Quando Disponível -->
          <div class="mb-2">
            <form method="post" action="aviseme-quando-disponivel" name="aviseme_envia" id="aviseme_envia">
              <button type="submit" class="btn btn-info btn-lg btn-block" name="envia" id="envia"><i class="fas fa-clock"></i> Avise-Me!</button>
              <input type="hidden" name="id_tarologo" value="<?php echo $id_tarologo2; ?>" />
            </form>
          </div>
          <?php
          
        } elseif ($row_online2 == "online") {
          
          ?>
          <!-- Botão Consultar Agora -->
          <div class="mb-2">
            <form method="post" action="consultar" id="consultachat<?php echo $id_tarologo2; ?>">
              <button type="submit" class="btn btn-success btn-lg btn-block" name="envia" id="envia"><i class="fas fa-comments"></i> Consultar Agora</button>
              <input type="hidden" name="id_tarologo" value="<?php echo $id_tarologo2; ?>" />
            </form>
          </div>
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
  $result = $pdo->query("SELECT * FROM clientes WHERE nivel = 'TAROLOGO' AND status='ATIVO' AND online='offline' ORDER BY nome ASC LIMIT $novo_limite");
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
    // Verificando se tarólogo esta online.
    $sql_online2 = $pdo->query("SELECT * FROM clientes WHERE id='$id_tarologo2' ");
    while ($mostrar22 = $sql_online2->fetch(PDO::FETCH_ASSOC)){ 
      $row_online2=$mostrar22['online'];
    }
    // Número de consultas
    $sql = $pdo->query("SELECT * FROM atendimento WHERE id_tarologo='$id_tarologo2'");
    $numero_consultas = $sql->rowCount();
    ?>
    <div id="tarologoshomeresultado" class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-xs-12 shadow" style="margin-bottom:15px;">
      
      <!-- Foto, nome e oraculos -->
      <div style="background-image: url('images/bg_tarologo.jpg');">
        
        <div id="nome" class="" style="padding-top: 45px;">
          <center>
            <form method="post" action="tarologo/<?php echo $alias; ?>">
              <i class="fas fa-ankh"></i> <input style="background: transparent;border: none;font-size:30px;color: #0e0c0c;font-weight: 800;text-shadow: 0px 2px 4px #da8345;" class="efeito" type="submit" name="envia" alt="<?php echo $nome2;?>" title="<?php echo $nome2;?>" value="<?php echo $nome2; ?>"/>
              <input type="hidden" name="id_tarologo" value="<?php echo $id_tarologo2; ?>" />
            </form>
          </center>
        </div>
        
        <div id="foto" class="" style="display:block;">
          <center>
            <form method="post" action="tarologo/<?php echo $alias; ?>">
              <input style="background: url('tarologos_admin/fotos/<?php echo $logo2;?>');width:90%;height:250px;margin-top:7px;border:none;background-size:cover;background-position:50% 50%;" class="rounded efeitodois" type="submit" name="envia" alt="<?php echo $nome2;?>" title="<?php echo $nome2;?>" value=""/>
              <input type="hidden" name="id_tarologo" value="<?php echo $id_tarologo2; ?>" />
            </form>
          </center>
        </div>
        <div id="oraculos" style="margin: 0px;font-size:19px;padding: 10px 10px 0 10px;color: #000000;height:188px;background: #ffffff91;">
          <center>
            <p><?php echo $descricaocurta;?></p>
          </center>
        </div>
              
        <!-- Botão Ver Perfil -->
        <div class="mb-2">
          <a href="tarologo/<?php echo $alias; ?>" button class="btn btn-dark btn-lg btn-block"><i class="far fa-address-card"></i> Ver Perfil</a>
        </div>  
        
        <!-- Verificando se tarólogo esta online ou não -->
        <?php
        if ($row_online2 == "offline" OR $row_online2 == ""){
          ?>
          <!-- Botão Avise-me Quando Disponível -->
          <div class="mb-2">
            <form method="post" action="aviseme-quando-disponivel" name="aviseme_envia" id="aviseme_envia">
              <button type="submit" class="btn btn-info btn-lg btn-block" name="envia" id="envia"><i class="fas fa-clock"></i> Avise-Me!</button>
              <input type="hidden" name="id_tarologo" value="<?php echo $id_tarologo2; ?>" />
            </form>
          </div>
          <?php
          
        } elseif ($row_online2 == "online") {
          
          ?>
          <!-- Botão Consultar Agora -->
          <div class="mb-2">
            <form method="post" action="consultar" id="consultachat<?php echo $id_tarologo2; ?>">
              <button type="submit" class="btn btn-success btn-lg btn-block" name="envia" id="envia"><i class="fas fa-comments"></i> Consultar Agora</button>
              <input type="hidden" name="id_tarologo" value="<?php echo $id_tarologo2; ?>" />
            </form>
          </div>
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

<div style="clear:both;"></div>