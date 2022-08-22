<script type="text/javascript">
alteraDiv = function (){
  if($('#importarclientes').val() == "SIM"){
    $("#importar").show();
    $("#naoimportar").hide();
  }  
  if($('#importarclientes').val() == "NAO"){
    $("#naoimportar").show();
    $("#importar").hide();
  }
}
</script>

<?php
if (isset($_POST["AdicionaEmail"])) {

  $importarclientes = $_POST['importarclientes'];
  $id_camp          = $_POST['id_camp'];
  $data             = date("Y-m-d");

  if ($importarclientes == "SIM") {

    foreach ($_POST['import_cliente'] as $import_cliente) {
      //print "$import_cliente<br/>";

      $executa66 = $pdo->query("SELECT * FROM clientes WHERE id='$import_cliente'");
      while ($dadoss66 = $executa66->fetch(PDO::FETCH_ASSOC)) { 
        $nome=$dadoss66['nome'];
        $email=$dadoss66['email'];
      }

      $pdo->query("INSERT INTO mail_lista (
        id_camp,
        nome,
        email,
        data
      ) VALUES (
        '$id_camp',
        '$nome',
        '$email',
        '$data'
      )");
    }

    $msgs = "E-mails Importados Com Sucesso!<br>";
    echo "<script>document.location.href='minha-conta/?pg=mail/email_listar.php&msgs=$msgs&id=$id_camp'</script>"; 

  } elseif ($importarclientes == "NAO") {
    
    $id_campnao = $_POST['id_campnao'];
    $nomenao    = $_POST['nomenao'];
    $emailnao   = $_POST['emailnao'];
    $data       = date("Y-m-d");

    $pdo->query("INSERT INTO mail_lista (
        id_camp,
        nome,
        email,
        data
      ) VALUES (
        '$id_campnao',
        '$nomenao',
        '$emailnao',
        '$data'
    )");

    $msgs = "E-mail Adicionado Com Sucesso!<br>";
    echo "<script>document.location.href='minha-conta/?pg=mail/email_listar.php&msgs=$msgs&id=$id_campnao'</script>";
  }
}
?>

<h3 class="text-success">Autoresponder - Adicionar E-mails Para Campanha</h3>

<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">
      <div class="col-md-2"></div>
        <div id="meio" class="col-md-8">

          <form name="AdicionaEmail" method="post" action="" style="font-size:16px;">

            <div class="form-group">
              <label for="">Importar Cliente</label>
              <select name="importarclientes" id="importarclientes" onchange="alteraDiv()" class="form-control">
                <option value="" selected="selected"> - Selecione - </option>
                <option value="SIM">SIM</option> 
                <option value="NAO">NAO</option>
              </select>
            </div>

            <div id="importar" style="display:none;">
              <div class="form-group">
                <label for="">Campanha</label>
                <select name="id_camp" class="input-mini form-control">
                  <option value="" selected="selected"> - Selecione uma Campanha - </option>
                  <?php 
                  $sql = $pdo->query("SELECT * FROM mail_camp");
                  $row = $sql->rowCount();
                  if ($row== 0) {
                    echo '<option value="">Nenhum dado encontrado...</option>';
                  } else { 
                    while ($id_camp = $sql->fetch(PDO::FETCH_ASSOC)){
                      echo '<option value="'.$id_camp['id'].'">'.$id_camp['nome'].'</option>';
                    } 
                  }
                  ?>
                </select>
              </div>

              <div class="form-group">
                <label for="">Cliente</label>
                <select multiple name="import_cliente[]" id="import_cliente" class="input-mini form-control" style="height: 200px;">
                  <option value="" selected="selected"> - Selecione o Cliente - </option>
                  <?php 
                  $sql1 = $pdo->query("SELECT * FROM clientes WHERE nivel='CLIENTE' AND status!='CANCELADO' ORDER BY nome ASC");
                  $row1 = $sql1->rowCount();
                  if ($row1== 0) {
                    echo '<option value="">Nenhum dado encontrado...</option>';
                  } else { 
                    while ($import_cliente = $sql1->fetch(PDO::FETCH_ASSOC)) {
                      echo '<option value="'.$import_cliente['id'].'">'.$import_cliente['nome'].' - '.$import_cliente['empresa'].'</option>';
                    } 
                  }
                  ?>
                </select>
              </div>
            </div>

            <div id="naoimportar" style="display:none;">
              <div class="form-group">
                <label for="">Campanha</label>
                <select name="id_campnao" class="input-mini form-control">
                  <option value="" selected="selected"> - Selecione uma Campanha - </option>
                  <?php 
                  $sql = $pdo->query("SELECT * FROM mail_camp");
                  $row2 = $sql->rowCount();
                  echo $row2;

                  if ($row2 == 0) {
                    echo '<option value="">Nenhum dado encontrado...</option>';
                  } else { 
                    while ($id_campnao = $sql->fetch(PDO::FETCH_ASSOC)){
                      echo '<option value="'.$id_campnao['id'].'">'.$id_campnao['nome'].'</option>';
                    } 
                  }
                  ?>
                </select>
              </div>

              <div class="form-group">
                <label for="">Nome</label>
                <input type="text" class="form-control" name="nomenao" value="" >
              </div>

              <div class="form-group">
                <label for="">E-mail</label>
                <input type="text" class="form-control" name="emailnao" value="" >
              </div>
            </div>

            <div class="form-group">
              <label for=""></label>
              <input class="btn btn-success" type="submit" name="AdicionaEmail" value="Adicionar E-mail" />
            </div>

          </form>

        </div>
      <div class="col-md-2"></div>
    </div>  
  </div>
</div>