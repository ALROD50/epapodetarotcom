<h3 class="text-success">Autoresponder - Nova Campanha</h3>

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
                <option value="ATIVO">ATIVO</option> 
                <option value="DESATIVADO">DESATIVADO</option>
              </select>
            </div>

            <div class="form-group">
              <label for="">Período</label>
              <select name="fixo" class="form-control">
                <option value="PROGRESSIVO">PROGRESSIVO</option>
                <option value="FIXO">FIXO</option> 
                <option value="AGENDADAS">AGENDADAS</option>
              </select>
            </div>

            <div class="form-group">
              <label for=""></label>
              <input class="btn btn-success" type="submit" name="CriarCampanha" value="Criar Campanha" />
            </div>

          </form>

          <?php
          if ( isset($_POST["CriarCampanha"]) ) {

            $nome         = $_POST['nome'];
            $status       = $_POST['status'];
            $fixo         = $_POST['fixo'];

            $pdo->query("INSERT INTO mail_camp (
                nome,
                status,
                fixo
              ) VALUES (
                '$nome',
                '$status',
                '$fixo'
            )");

            $msgs = "Campanha Criado Com Sucesso!<br>";
            echo "<script>document.location.href='minha-conta/?pg=mail/autoresponder.php&msgs=$msgs'</script>";  
          }
          ?>

        </div>
      <div class="col-md-2"></div>
    </div>  
  </div>
</div>