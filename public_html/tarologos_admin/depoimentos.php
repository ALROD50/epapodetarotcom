<h3 class="text-success">Meus Depoimentos</h3>
<hr>
<?php
	$id = @$_GET['id'];
    //Estanciando dados dos depoimentos
    $executa = $pdo->query("SELECT * FROM depoimentos WHERE id_tarologo='$id' AND habilitado='SIM' ");
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

        <div class="card card-body" id="depoimento">
            
            <div style="float:right;">
                <span style="color: #0873bb; font-weight: 700;">
                    <?php echo 'Pontuação: '.$pontuacao; ?>
                </span>
            </div>

            <div style="font-size:13px; color: #0873bb; font-weight: 700;">
                <p><?php echo $cliente_nome; ?></p>
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