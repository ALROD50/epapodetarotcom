<?php
$DataPicker ="SIM";
$TinyMce    ="SIM";
$Mask       ="SIM";
$id = @$_GET['id'];
$executa66 = $pdo->query("SELECT * FROM mail_msg WHERE id='$id'");
while ($dadoss66 = $executa66->fetch(PDO::FETCH_ASSOC)) { 

  $id=$dadoss66['id'];
  $id_camp=$dadoss66['id_camp'];
  $enviar_dias=$dadoss66['enviar_dias'];
  $assunto=$dadoss66['assunto'];
  $msg=$dadoss66['msg'];
  $data_utima_exec=$dadoss66['data_utima_exec'];
  $data_utima_exec=MostraDataCorretamenteHora ($data_utima_exec);
  if ($data_utima_exec=="30-11--0001 00:00:00") {
    $data_utima_exec="00-00-0000 00:00:00";
  }
}

$executa778 = $pdo->query("SELECT * FROM mail_camp WHERE id='$id_camp'");
while ($dados778 = $executa778->fetch(PDO::FETCH_ASSOC)) { 
  $campnome=$dados778['nome'];
}

?>
<h3 class="text-success">Autoresponder - Editar Mensagem</h3>
<hr>

<div id="meio">

  <form name="CriarMensagem" method="post" action="" style="font-size:16px;">

    <div class="form-group">
      <label for="">Campanha</label>
      <select name="id_camp" class="input-mini form-control">
        <?php echo '<option value="'.$id_camp.'">'.$campnome.'</option>'; ?>
        <?php 
        $sql = $pdo->query("SELECT * FROM mail_camp");
        $row = $sql->rowCount();
        if ($sql == 0) {
          echo '<option value="">Nenhum dado encontrado...</option>';
        } else { 
          while ($id_camp = $sql->fetch(PDO::FETCH_ASSOC)){
            echo '<option value="'.$id_camp['id'].'">'.$id_camp['nome'].'</option>';
          } 
        }
        ?>
      </select>
    </div>

    <div class="container-fluid">
		  <div class="row">
		    <div class="col-md-12">
		      
		      <div class="col-md-4">
	            <div class="form-group">
	              <label for="">Assunto</label>
	              <input type="text" class="form-control" name="assunto" value="<?php echo @$assunto; ?>" >
	            </div>
		      </div>
		      
		      <div class="col-md-4">
		      	<div class="form-group">
	              <label for="">Ciclo de Envio em Dias</label>
	              <input type="text" class="form-control" name="enviar_dias" value="<?php echo @$enviar_dias; ?>" >
	            </div>
		      </div>

          <div class="col-md-4">
            <div class="form-group">
                <label for="">Data da Última Execução</label>
                <input type="text" class="form-control" name="data_utima_exec" id="datepicker" value="<?php echo @$data_utima_exec; ?>" >
              </div>
          </div>
		    
		    </div>  
		  </div>
		</div>
		
    <label for="">Mensagem</label>
    <div class="row col-md-12 my-3">
        <textarea name="msg" class="form-control" style="width:100%;"><?php echo $msg; ?></textarea>
    </div>
  
    <div class="form-group">
      <label for=""></label>
      <input class="btn btn-success" type="submit" name="CriarMensagem" value="Atualizar Mensagem" />
    </div>

  </form>

  <?php
  if ( isset($_POST["CriarMensagem"]) ) {

    $id_camp       = $_POST['id_camp'];
    $assunto       = $_POST['assunto'];
    $enviar_dias   = $_POST['enviar_dias'];
    $msg           = $_POST['msg'];
    $data_utima_exec = $_POST['data_utima_exec'];
    $data_utima_exec = MudaDataGravarBanco($data_utima_exec);

    $query = $pdo->query("UPDATE mail_msg SET 
      id_camp='$id_camp',
      assunto='$assunto',
      enviar_dias='$enviar_dias',
      msg='$msg',
      data_utima_exec='$data_utima_exec'
    WHERE id='$id'");

    $msgs = "Mensagem Atualizada Com Sucesso!<br>";
    echo "<script>document.location.href='minha-conta/?pg=mail/msg_listar.php&msgs=$msgs&id_camp=$id_camp'</script>";  
  }
  ?>

</div>