<h1><i class="fas fa-gem"></i> DEPOIMENTOS <i class="fas fa-trophy"></i></h1>

<hr>

<div id="myCarouselDepoimentos" class="carousel slide shadow" data-ride="carousel">

  <ol class="carousel-indicators" style="display: none;">
    <?php 
    
    $limite = 9;
    $active = "active";
    for ($i=0; $i <= $limite; $i++) { 
      echo '<li data-target="#myCarouselDepoimentos" data-slide-to="'.$i.'" class="'.$active.'"></li>';
      $active = "";
    }
    ?>
  </ol>
  <div class="carousel-inner">
    <?php
    $active = "active";
    $executa = $pdo->query("SELECT * FROM depoimentos WHERE habilitado='SIM' ORDER BY id DESC LIMIT 20");
    $encontrados = $executa->rowCount();
    while ($dadoss= $executa->fetch(PDO::FETCH_ASSOC)) { 
      $id_tarologo=$dadoss['id_tarologo'];
      $id_cliente=$dadoss['id_cliente'];
      $mensagem=addslashes($dadoss['mensagem']);
      $pontuacao=$dadoss['pontuacao'];
      $data  = $dadoss['data'];
      $data  = date("d-m-Y", strtotime("$data"));
      //Estancia dados do Tarólogo
      $dadoss3 ="SELECT * FROM clientes WHERE id='$id_tarologo'"; 
      $executa3 = $pdo->query($dadoss3);
      while ($dadoss3= $executa3->fetch(PDO::FETCH_ASSOC)) {
        $tarologo_nome=$dadoss3['nome'];
        $alias=$dadoss3['alias'];
        $logo=$dadoss3['logo'];
      }
      $row = $executa3->rowCount();
      if ($row == 0) { $tarologo_nome=""; }

      echo '
        <div class="carousel-item '.$active.'" style="height: 35rem; background: transparent;">
          <div class="container">
            <div class="carousel-caption text-center" style="right:5%;left:5%">
              <h4 class="text-white"><i class="fas fa-star"></i> - '.$pontuacao.' - <i class="fas fa-star"></i></h4>
              <h2 class="text-white">'.$mensagem.'</h2>
              <p><small class="text-muted"><i class="fas fa-calendar-alt"></i> Enviado em: '.$data.'</small></p>
              <p><img src="tarologos_admin/fotos/min/'.$logo.'" alt="'.$tarologo_nome.'" title="'.$tarologo_nome.'" class="rounded-circle"  height="140"></p>
              <h3 class="text-white"><span style="font-weight:bold;"><i class="fas fa-ankh"></i> '.$tarologo_nome.'</span></h3>
              <p><a class="btn btn-md btn-light" href="tarologo/'.$alias.'" role="button"><i class="fas fa-search"></i> Ver Perfil</a></p>
            </div>
          </div>
        </div>
      ';
      $active = "";
    }
    ?>
  </div>
  <a class="carousel-control-prev" href="#myCarouselDepoimentos" role="button" data-slide="prev" style="width: 5%;">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#myCarouselDepoimentos" role="button" data-slide="next" style="width: 5%;">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>

</div>