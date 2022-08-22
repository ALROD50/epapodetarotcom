<?php
$id = @$_GET['id'];
$executa66 = $pdo->query("SELECT * FROM mail_camp WHERE id='$id'");

while ($dadoss66 = $executa66->fetch(PDO::FETCH_ASSOC)) { 

  $id=$dadoss66['id'];
  $nome=$dadoss66['nome'];
  $status=$dadoss66['status'];
  $fixo=$dadoss66['fixo'];
  $data_utima_exec=$dadoss66['data_utima_exec'];
  $data_utima_exec=MostraDataCorretamente($data_utima_exec);
}

?>
<h3 class="text-success">Autoresponder - Atualizar Campanha</h3>

<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">
      <div class="col-md-2"></div>
        <div id="meio" class="col-md-8">

          <form name="CriarCampanha" method="post" action="" style="font-size:16px;">

            <div class="form-group">
              <label for="">Nome da Campanha</label>
              <input type="text" class="form-control" name="nome" value="<?php echo @$nome; ?>" >
            </div>

            <div class="form-group">
              <label for="">Status</label>
              <select name="status" class="form-control">
                <?php echo '<option value="'.$status.'">'.$status.'</option>'; ?>
                <option value="ATIVO">ATIVO</option> 
                <option value="DESATIVADO">DESATIVADO</option>
              </select>
            </div>

            <div class="form-group">
              <label for="">Período</label>
              <select name="fixo" class="form-control">
                <?php echo '<option value="'.$fixo.'">'.$fixo.'</option>'; ?>
                <option value="PROGRESSIVO">PROGRESSIVO</option>
                <option value="FIXO">FIXO</option> 
              </select>
            </div>

            <div class="form-group">
              <label for="">Útima Execução</label>
              <input type="text" class="form-control" id="datepicker" name="data_utima_exec" value="<?php echo @$data_utima_exec; ?>" >
            </div>

            <div class="form-group">
              <label for=""></label>
              <input class="btn btn-success" type="submit" name="CriarCampanha" value="Atualizar Campanha" />
            </div>

          </form>

          <?php
          if ( isset($_POST["CriarCampanha"]) ) {

            $nome            = $_POST['nome'];
            $status          = $_POST['status'];
            $fixo            = $_POST['fixo'];
            $data_utima_exec = $_POST['data_utima_exec'];
            $data_utima_exec = MudaDataGravarBanco($data_utima_exec);

            $query = $pdo->query("UPDATE mail_camp SET 
              nome='$nome',
              status='$status',
              fixo='$fixo',
              data_utima_exec='$data_utima_exec'
            WHERE id='$id'");

            $msgs = "Campanha Atualizada Com Sucesso!<br>";
            echo "<script>document.location.href='minha-conta/?pg=mail/autoresponder.php&msgs=$msgs'</script>";  
          }
          ?>

        </div>
      <div class="col-md-2"></div>
    </div>  
  </div>
</div>