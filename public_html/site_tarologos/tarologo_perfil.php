<?php 
$sql = $pdo->query("SELECT * FROM clientes WHERE nivel='TAROLOGO' AND alias='$URLCATEGORIA' "); 
$row = $sql->rowCount();

if ($row > 0){

  while ($mostrar = $sql->fetch(PDO::FETCH_ASSOC)) { 
    $id_tarologo=$mostrar['id'];
    $nome=$mostrar['nome'];
    $especialidades=$mostrar['especialidade_taro'];
    $infos=$mostrar['infos'];
    $logo=$mostrar['logo'];
    $videochamada=$mostrar['videochamada'];

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

  <!-- Go to www.addthis.com/dashboard to customize your tools -->
  <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-59681b17bd25eb95"></script>
  
  <div class="addthis_inline_share_toolbox" class="col-md-6"></div>

  <h1 class="vinho"><?php echo $nome; ?></h1>

  <p><span style="color: #753a4a; font-weight: bold;">Status:</span> <?php echo $online; ?></p>

  <div style="clear:both;"></div>
    
  <div style="float:left; margin: 15px 15px 15px 0px;" class="col-md-3">
    <figure class="figure">
      <img src="tarologos_admin/fotos/<?php echo $logo; ?>" class="rounded img-fluid" alt="<?php echo $nome;?>" title="<?php echo $nome;?>">
      
    </figure>
  </div>

  <div class="card p-2 mt-5 mb-1">
    <p><u><i class="fas fa-arrow-right"></i> Atendimentos Disponíveis:</u></p>
    <figcaption class="figure-caption">

      <!-- Botões -->
      <?php
      if ($row_online == "offline" OR $row_online == ""){
        ?>
        <!-- Botão Avise-me Quando Disponível -->
        <form name="aviseme_envia" id="aviseme_envia" method="post" action="aviseme-quando-disponivel" style="margin-top:5px;">
          <input type="hidden" name="id_tarologo" value="<?php echo $id_tarologo; ?>" />
          <button type="submit" name="envia" class="btn corpadrao2 btn-lg" alt="Avise-me Quando Disponível" title="Avise-me Quando Disponível"><i class="fas fa-clock"></i> Avise-me Quando Disponível</button>
          <p class="mt-3">Este tarólogo não está online no momento, clique no botão acima <b>Avise-me Quando Disponível</b> para ser avisado quando este tarólog voltar online. Desta forma quando tarólogo voltar ao trabalho você será avisado por e-mail e poderá fazer sua consulta com ele.</p>
        </form>
        <!-- Botão Consulta por Email -->
        <form name="consultarporemail" id="consultarporemail" method="post" action="consultarporemail" style="float:left; margin-right:8px;">
          <input type="hidden" name="id_tarologo" value="<?php echo $id_tarologo; ?>" />
          <button type="submit" name="envia" class="btn corpadrao2 btn-lg" alt="Consultar por E-mail" title="Consultar por E-mail"><i class="fas fa-envelope"></i> Consultar por E-mail</button>
        </form>
        <?php
        
      } elseif ($row_online == "online") {
        
        ?>
        <form name="Consultar" id="Consultar<?php echo @$id; ?>" method="post" action="consultar" style="margin-top:5px;">
          <input type="hidden" name="id_tarologo" value="<?php echo @$id_tarologo; ?>" />
          <input type="hidden" name="id_cliente" value="<?php echo @$usuario_id; ?>" />
          <input type="hidden" name="videochat" value="NAO" />
          <button type="submit" name="envia" class="btn btn-lg btn-success"><i class="fas fa-comments"></i> CONSULTAR AO VIVO POR: <u>CHAT</u></button>
        </form>
        <?php
        if ($videochamada=="SIM") {
          ?>
          <form name="Consultar" id="Consultar<?php echo @$id; ?>" method="post" action="consultar" style="margin-top:5px;">
            <input type="hidden" name="id_tarologo" value="<?php echo @$id_tarologo; ?>" />
            <input type="hidden" name="id_cliente" value="<?php echo @$usuario_id; ?>" />
            <input type="hidden" name="videochat" value="SIM" />
            <button type="submit" name="envia" class="btn btn-lg btn-warning"><i class="fas fa-video"></i> CONSULTAR AO VIVO POR: <u>VIDEO</u></button>
          </form>
          <?php
        }
        ?>
        <!-- Botão Consultar Agora -->
        <?php
        
      } elseif ($row_online == "ocupado") {

        ?>
        <!-- Botão Ocupado -->
        <div class="mb-2">
          <button type="submit" class="btn btn-danger btn-lg" disabled><i class="fas fa-hourglass-start"></i> Estou Ocupado</button>
          <p>Este tarólogo esta ocupado em um atendimento neste momento, volte em alguns minutinhos para tentar novamente.</p>
        </div>
        <?php 

      }
      ?>
    </figcaption>
  </div>

  <div class="row">
    <?php echo $infos; ?>
  </div>

  <p style="font-size:30px; color: #9e3434;"><b>ORÁCULOS</b>:</p>
  
  <p><?php echo $especialidades;?></p>

  <form name="consultarporemail" id="consultarporemail" method="post" action="consultarporemail" style="float:left; margin-right:8px; display: none;">
    <button type="submit" name="envia" class="btn btn-xs btn-info" alt="Consultar por E-mail" title="Consultar por E-mail"><i class="fas fa-envelope"></i> Consultar por E-mail</button>
    <input type="hidden" name="id_tarologo" value="<?php echo $id_tarologo; ?>" />
  </form>

  <div style="clear:both;"></div>

  <hr style="border: 1px solid #ccc;">

    <h1 class="rosaclaro">DEPOIMENTOS DE CLIENTES</h1>

    <?php

    //Estanciando dados dos depoimentos
    $executa = $pdo->query("SELECT * FROM depoimentos WHERE id_tarologo='$id_tarologo' AND habilitado='SIM' ORDER by id DESC");
    $encontrados = $executa->rowCount();

    while ($dadoss= $executa->fetch(PDO::FETCH_ASSOC)) {

  		$id_tarologo=$dadoss['id_tarologo'];
  		$id_cliente=$dadoss['id_cliente'];
  		$mensagem=$dadoss['mensagem'];
  		$pontuacao=$dadoss['pontuacao'];
      $data  = $dadoss['data'];
      $data  = date("d-m-Y", strtotime("$data"));

  		//Estancia dados do cliente
  		$dadoss3 ="SELECT * FROM clientes WHERE id='$id_cliente'"; 
  		$executa3 = $pdo->query($dadoss3);
  		while ($dadoss3= $executa3->fetch(PDO::FETCH_ASSOC)) {
  			$cliente_id=$dadoss3['id'];
  			$cliente_nome=$dadoss3['nome'];
  		}
  		?>

  		<div class="card card-body mb-3" id="depoimento">
  		    
	      <p><i class="fas fa-star"></i> <?php echo '<b>Pontuação:</b> '.$pontuacao; ?><br>
        <small class="text-muted">Enviado em: <?php echo $data; ?> </small></p>
		    <?php echo $mensagem; ?>

  		</div>

    	<?php 
  	} 

    if ($encontrados == 0) {
       
      echo '<p>';
      echo '(0) depoimentos...';
      echo '</p>';
    }
  ?>

  <?php } 
  
    } else {
      
      ?>
		<div class="row" style="margin-top:20px;">
			<div class="col-md-12">
				<div class="card card-body" style="background:#fff; color:#383C3F;">
					</br>
						<center><p><h2>Ops... Nenhum resultado encontrado...</h2></p></center>
						<center><b><a href="tarologos">Voltar, Clique Aqui.</a></b></center>
					</br>
				</div>
			</div>
		</div>
		<?php
    }
?>