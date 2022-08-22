<?php
$DataPicker ="SIM";
$TinyMce    ="SIM";
$Mask       ="SIM";
$id = @$_GET['id'];
$executa66 = $pdo->query("SELECT * FROM mail_lista WHERE id_camp='$id'");
while ($dadoss66 = $executa66->fetch(PDO::FETCH_ASSOC)) { 
  $id=$dadoss66['id'];
  $id_camp=$dadoss66['id_camp'];
  $nome=$dadoss66['nome'];
  $email=$dadoss66['email'];
  $data=$dadoss66['data'];
  $data=MostraDataCorretamente($data);
}

$executa778 = $pdo->query("SELECT * FROM mail_camp WHERE id='$id_camp'");
while ($dados778 = $executa778->fetch(PDO::FETCH_ASSOC)) { 
  $campnome=$dados778['nome'];
}

?>
<h3 class="text-success">Autoresponder - Editar E-mail</h3>

<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">
      <div class="col-md-2"></div>
        <div id="meio" class="col-md-8">

          <form name="AtualizaEmail" method="post" action="" style="font-size:16px;">

            <div class="form-group">
              <label for="">Campanha</label>
              <select name="id_camp" class="input-mini form-control">
                <?php echo '<option value="'.$id_camp.'">'.$campnome.'</option>'; ?>
                <?php 
                $sql = $pdo->query("SELECT * FROM mail_camp");
                $row = $sql->rowCount();
                if ($row == 0) {
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
              <label for="">Nome</label>
              <input type="text" class="form-control" name="nome" value="<?php echo @$nome; ?>" >
            </div>

            <div class="form-group">
              <label for="">E-mail</label>
              <input type="text" class="form-control" name="email" value="<?php echo @$email; ?>" >
            </div>

            <div class="form-group">
              <label for="">Data de Cadastro do E-mail</label>
              <input type="text" class="form-control" id="datepicker" name="data" value="<?php echo @$data; ?>" >
            </div>

            <div class="form-group">
              <label for=""></label>
              <input class="btn btn-success" type="submit" name="AtualizaEmail" value="Atualizar E-mail" />
            </div>

          </form>

          <?php
          if ( isset($_POST["AtualizaEmail"]) ) {

            $id_camp      = $_POST['id_camp'];
            $nome         = $_POST['nome'];
            $email        = $_POST['email'];
            $data         = $_POST['data'];
            $data=MudaDataGravarBanco($data);

            $query = $pdo->query("UPDATE mail_lista SET 

              id_camp='$id_camp',
              nome='$nome',
              email='$email',
              data='$data'

            WHERE id='$id'");

            $msgs = "E-mail Atualizado Com Sucesso!<br>";
            echo "<script>document.location.href='minha-conta/?pg=mail/email_listar.php&id=$id_camp&msgs=$msgs'</script>";  
          }
          ?>

        </div>
      <div class="col-md-2"></div>
    </div>  
  </div>
</div>