<h3 class="text-success">Criar Depoimentos</h3>

<form name="tarologos" method="post" action="" class="form-horizontal">

<div class="form-group">
  <label for="id_tarologo" class="col-sm-2 control-label">Tarólogo</label>
  <div class="col-sm-10">
    <select class="form-control" name="id_tarologo">
    <option value="" selected="selected"> -- Tarólogo -- </option>
      <?php 
        $sql = $pdo->query("SELECT * FROM clientes WHERE nivel ='TAROLOGO' ");
        if ($sql->rowCount() == 0) {
            echo '<option value="">Não encontramos nenhum Tarólogo</option>';
        } else { 
          while ($nomes_encontrados = $sql->fetch(PDO::FETCH_ASSOC)){
          echo '<option value="'.$nomes_encontrados['id'].'">'.$nomes_encontrados['nome'].'</option>';
            } }
      ?>
    </select>
  </div>
</div>

<div class="form-group">
  <label for="id_cliente" class="col-sm-2 control-label">Cliente</label>
  <div class="col-sm-10">
    <select class="form-control" name="id_cliente">
    <option value="" selected="selected"> -- Clientes -- </option>
      <?php 
        $sql = $pdo->query("SELECT * FROM clientes WHERE nivel ='CLIENTE' ");
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
    <textarea name="mensagem" class="form-control"/></textarea>
  </div>
</div>

<div class="form-group">
  <label for="pontuacao" class="col-sm-2 control-label">Pontuação</label>
  <div class="col-sm-10">
    <select name="pontuacao" class="form-control" placeholder="Pontuação">
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
    <option value="SIM">Sim</option>
    <option value="NAO">Não</option>
    </select>
  </div>
</div>

<div class="form-group">
  <label for="" class="col-sm-2 control-label"></label>
  <div class="col-sm-10">
    <input class="btn btn-success" type="submit" name="envia" value="Criar Novo Depoimento"/>
    <input class="btn btn-info" type="button" name="Cancel" value="Cancelar" onclick="window.location = 'minha-conta/?pg=depoimentos/depoimentos.php' " />
  </div>
</div>

</form>

<?php
  if(isset($_POST['envia'])){

    $id_tarologo = $_POST['id_tarologo'];
    $id_cliente = $_POST['id_cliente'];
    $mensagem = $_POST['mensagem'];
    $pontuacao = $_POST['pontuacao'];
    $habilitado = $_POST['habilitado'];
     
    $pdo->query( "INSERT INTO depoimentos (
      id_tarologo,
      id_cliente,
      mensagem,
      pontuacao,
      habilitado
    ) VALUES (
      '$id_tarologo',
      '$id_cliente',
      '$mensagem',
      '$pontuacao',
      '$habilitado'
    )");

    $msgs="Depoimento Criado Com Sucesso!";
    echo "<script>document.location.href='minha-conta/?pg=depoimentos/depoimentos.php&msgs=$msgs'</script>";
    exit();
  }  
?>