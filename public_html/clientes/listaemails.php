<div class="row">
  <div class="col-md-12">
    <div class="well muted">
      <p class="lead">E-mail's dos Clientes</p>
      <p>Abra um chamado no departamento de Atualizações da Nova Systems para saber como adiquerir este recurso.</p>
      <?php  
        $result = $pdo->query("SELECT * FROM clientes WHERE status='ATIVO' AND nivel='CLIENTE' ");
        while ($selecionaemail = $result->fetch(PDO::FETCH_ASSOC)){ 
        	$email = $selecionaemail ['email'];
        	$nome  = $selecionaemail ['nome'];
          $data  = $selecionaemail ['data_nascimento'];
          if ($data=="0000-00-00") {
            $data = "";
          } else {
            $data = date("d/m/Y", strtotime("$data"));
          }
        	// echo $email. ', ' .$nome. ', ' .$telefone. ', ' .$data.'<br>';
          //echo $email.",".$nome.",".$data."<br>";
        }
      ?>
    </div>
  </div>
</div>