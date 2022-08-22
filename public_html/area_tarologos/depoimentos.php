<?php
date_default_timezone_set("Brazil/East"); // seta configurações fusuhorario para Brasil
ini_set ('default_charset', 'UTF-8'); // seta o php em UTF 8
require_once "includes/conexaoPdo.php";
$pdo = conexao();
?>

<h3 class="text-success mt-3">Meus Depoimentos</h3>
<hr>

<?php
  //Estanciando dados dos depoimentos
  $executa = $pdo->query("SELECT * FROM depoimentos WHERE id_tarologo='$usuario_id' AND habilitado='SIM' "); 
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
    $executa3=$pdo->query( $dadoss3);
      while ($dadoss3= $executa3->fetch(PDO::FETCH_ASSOC)){
      $cliente_id=$dadoss3['id'];
      $cliente_nome=$dadoss3['nome'];
    } 
    ?>

    <div class="card card-body mb-3" id="depoimento">
        
      <p><i class="fas fa-star"></i> <?php echo '<b>Pontuação:</b> '.$pontuacao; ?><br>
      <small class="text-muted">Enviado em: <?php echo $data; ?> </small></p>
      <?php echo $mensagem; ?>

    </div>

<?php }

if ($encontrados == 0) {
   
  echo '<p>';
  echo '(0) depoimentos...';
  echo '</p>';
}
?>