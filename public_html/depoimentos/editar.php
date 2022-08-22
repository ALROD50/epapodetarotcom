<h3 class="text-success">Editar Depoimentos</h3>
<?php

$id=$_GET['id'];
 
$dadoss ="SELECT * FROM depoimentos WHERE id='$id'"; //acessa todos os dados do usuário $NOME da url
$executa=$pdo->query( $dadoss); //se conecta no banco e concatena os dados

while ($dadoss= $executa->fetch(PDO::FETCH_ASSOC)){ 

  $id_tarologo=$dadoss['id_tarologo'];
  $id_cliente=$dadoss['id_cliente'];
  $mensagem=$dadoss['mensagem'];
  $pontuacao=$dadoss['pontuacao'];
  $habilitado=$dadoss['habilitado'];
}

 //Estancia dados do tarólogo
  $dadoss4 ="SELECT * FROM clientes WHERE id='$id_tarologo'"; 
  $executa4=$pdo->query( $dadoss4);
    while ($dadoss4= $executa4->fetch(PDO::FETCH_ASSOC)){
    $tarologo_id=$dadoss4['id'];
    $tarologo_nome=$dadoss4['nome'];
  }

  //Estancia dados do cliente
  $dadoss3 ="SELECT * FROM clientes WHERE id='$id_cliente'"; 
  $executa3=$pdo->query( $dadoss3);
    while ($dadoss3= $executa3->fetch(PDO::FETCH_ASSOC)){
    $cliente_id=$dadoss3['id'];
    $cliente_nome=$dadoss3['nome'];
  }

?>

<form name="tarologos" method="post" action="" class="form-horizontal">

  <input type="hidden" name="id" value="<?php echo $id; ?>"/>

<div class="form-group">
  <label for="id_tarologo" class="col-sm-2 control-label">Tarólogo</label>
  <div class="col-sm-10">
    <select class="form-control" name="id_tarologo">
    <option value="<?php echo $tarologo_id; ?>" selected="selected"> <?php echo $tarologo_nome; ?> </option>
      <?php 
        $sql = $pdo->query("SELECT * FROM clientes WHERE id ='$tarologo_id' ");
        if ($sql->rowCount() == 0) {
            echo '<option value="" selected>Não encontramos nenhum Tarólogo</option>';
            $sql = $pdo->query("SELECT * FROM clientes Where nivel='TAROLOGO' ORDER BY nome ASC");
            while ($nomes_encontrados = $sql->fetch(PDO::FETCH_ASSOC)){
              echo '<option value="'.$nomes_encontrados['id'].'">'.$nomes_encontrados['nome'].'</option>';
            }
        } else { 
          while ($nomes_encontrados = $sql->fetch(PDO::FETCH_ASSOC)){
            echo '<option value="'.$nomes_encontrados['id'].'">'.$nomes_encontrados['nome'].'</option>';
          } 
        }
      ?>
    </select>
  </div>
</div>

<div class="form-group">
  <label for="id_cliente" class="col-sm-2 control-label">Cliente</label>
  <div class="col-sm-10">
    <select class="form-control" name="id_cliente">
    <option value="<?php echo $cliente_id; ?>" selected="selected"> <?php echo $cliente_nome; ?> </option>
      <?php 
        $sql = $pdo->query("SELECT * FROM clientes WHERE id ='$cliente_id' ");
        if ($sql->rowCount() == 0) {
            echo '<option value="">Não encontramos nenhum cliente</option>';
        } else { 
          while ($nomes_encontrados = $sql->fetch(PDO::FETCH_ASSOC)){
          echo '<option value="'.$nomes_encontrados['id'].'">'.$nomes_encontrados['nome'].'</option>';
            } }
      ?>
    </select>
  </div>
</div>

<div class="form-group">
  <label for="mensagem" class="col-sm-2 control-label">Mensagem</label>
  <div class="col-sm-10">
    <p><?php echo $mensagem; ?></p>
  </div>
</div>

<div class="form-group">
  <label for="pontuacao" class="col-sm-2 control-label">Pontuação</label>
  <div class="col-sm-10">
    <select name="pontuacao" class="form-control" placeholder="Pontuação">
    <option value="<?php echo $pontuacao; ?>"><?php echo $pontuacao; ?></option>
    <option value="Péssimo">Péssimo</option>
    <option value="Ruim">Ruim</option>
    <option value="Normal">Normal</option>
    <option value="Bom">Bom</option>
    <option value="Excelente">Excelente</option>
    </select>
  </div>
</div>

<div class="form-group">
  <label for="habilitado" class="col-sm-2 control-label">Habilitado?</label>
  <div class="col-sm-10">
    <select name="habilitado" class="form-control" placeholder="Habilitado">
      <option value="<?php echo $habilitado; ?>"><?php echo $habilitado; ?></option>
    <option value="SIM">Sim</option>
    <option value="NAO">Não</option>
    </select>
  </div>
</div>

<div class="form-group">
  <label for="" class="col-sm-2 control-label"></label>
  <div class="col-sm-10">
    <input class="btn btn-success" type="submit" name="envia" value="Atualizar Depoimento"/>
    <input class="btn btn-info" type="button" name="Cancel" value="Cancelar" onclick="window.location = 'minha-conta/?pg=depoimentos/depoimentos.php' " />
  </div>
</div>

</form>

<?php

if ( isset($_POST["envia"])  ) {

  $id = $_POST['id'];
  $id_tarologo = $_POST['id_tarologo'];
  $id_cliente = $_POST['id_cliente'];
  $pontuacao = $_POST['pontuacao'];
  $habilitado = $_POST['habilitado'];

  $query = $pdo->query( "UPDATE depoimentos SET

    id_tarologo='$id_tarologo',
    id_cliente='$id_cliente',
    pontuacao='$pontuacao',
    habilitado='$habilitado'

  WHERE id='$id'");

  $msgs = "Depoimento Atualizado com Sucesso!";
  echo "<script>document.location.href='minha-conta/?pg=depoimentos/depoimentos.php&msgs=$msgs'</script>";
}
?>