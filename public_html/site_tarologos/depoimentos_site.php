<h1>DEPOIMENTOS</h1>

<hr>

<?php
$executa = $pdo->query("SELECT * FROM depoimentos WHERE habilitado='SIM' ORDER BY id DESC LIMIT 50");
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

  ?>
  <div class="col-md-12">
    
    <p><i class="fas fa-star rosa"></i> <span style="color:#4b9443;"><?php echo $pontuacao; ?></span></p>

    <span style="word-break: break-word;">
      <p><b><?php echo @$cliente_nome; ?></b></p>
      <p><em><?php echo $mensagem; ?></em></p>
    </span>

    <p><span style="color:#777;">Comentário sobre o serviço de</span> <span style="color:#A16326;"><a href="tarologos/<?php echo $alias; ?>"><?php echo $tarologo_nome; ?></a></span></p>

  </div>
  <hr>
  <?php
}
?>