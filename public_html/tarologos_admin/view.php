<form name="clientes_filtro" id="clientes_filtro"  action="" method="post" style="margin-top:10px;" class="form-inline">
<select name="cliente" class="form-control col-md-5 mr-2">
<option value="" selected="selected"> -- Tarólogos -- </option>
<?php 
$sql = $pdo->query("SELECT * FROM clientes Where nivel='TAROLOGO' ORDER BY nome ASC");
if ($sql->rowCount() == 0) {
  echo '<option value="">Não encontramos nenhum cliente</option>';
} else { 
  while ($nomes_encontrados = $sql->fetch(PDO::FETCH_ASSOC)){
    echo '<option value="'.$nomes_encontrados['id'].'">'.$nomes_encontrados['nome'].'</option>';
  }
}
?>
</select>
<input type="submit" name="filtro_id" type="button" value="ok" class="btn btn-primary"/>
</form>
<?php
//Variavel do filtro nome cliente
$filtro_id = @$_POST['filtro_id'];
if(!empty($filtro_id)){ 
  $id = @$_POST['cliente'];
  echo "<script>document.location.href='minha-conta/?pg=tarologos_admin/view.php&id=$id'</script>";
  exit();
} else { 
  $id = $_GET['id']; 
}
if ($id !== '') {
$dadoss ="SELECT * FROM clientes WHERE id='$id'"; //acessa todos os dados do usuário $NOME da url
$executa=$pdo->query($dadoss); //se conecta no banco e concatena os dados
while ($dadoss= $executa->fetch(PDO::FETCH_ASSOC)){ 
$nome=$dadoss['nome'];
$email=$dadoss['email'];
$status=$dadoss['status'];
$logo=$dadoss['logo'];
}
?>
<h3># <?php echo $id.' '.$nome; ?></h3>
<hr>
<ul class="nav nav-tabs" id="myTab" role="tablist" style="margin-bottom:15px;">
  <li class="nav-item" role="presentation">
    <a href="#tabGeral" class="nav-link active" aria-selected="true" id="tabGeral-tab" data-toggle="tab" role="tab" aria-controls="tabGeral">Geral</a>
  </li>
  <li class="nav-item" role="presentation">
    <a href="#tabCadastro" class="nav-link" aria-selected="false" id="tabCadastro-tab" data-toggle="tab" role="tab" aria-controls="tabCadastro">Dados de Cadastro</a>
  </li>
  <li class="nav-item" role="presentation">
    <a href="#tabAtendimentos" class="nav-link" aria-selected="false" id="tabAtendimentos-tab" data-toggle="tab" role="tab" aria-controls="tabAtendimentos">Atendimentos</a>
  </li>
  <li class="nav-item" role="presentation">
    <a href="#tabDepoimentos" class="nav-link" aria-selected="false" id="tabDepoimentos-tab" data-toggle="tab" role="tab" aria-controls="tabDepoimentos">Depoimentos</a>
  </li>
</ul>

<div class="tab-content" id="myTabContent"> 
  <div class="tab-pane fade show active" id="tabGeral" role="tabpanel" aria-labelledby="tabGeral-tab">
    <?php include "geral.php"; ?>
  </div>
  <div class="tab-pane fade" id="tabCadastro" role="tabpanel" aria-labelledby="tabCadastro-tab">
    <?php include "editar.php"; ?>
  </div>
  <div class="tab-pane fade" id="tabAtendimentos" role="tabpanel" aria-labelledby="tabAtendimentos-tab">
    <?php include "atendimento_meses.php"; ?>
  </div>
  <div class="tab-pane fade" id="tabDepoimentos" role="tabpanel" aria-labelledby="tabDepoimentos-tab">
    <?php include "depoimentos.php"; ?>
  </div>
</div>

<?php  

} else {

  echo '<br/>';
  $msge="Nenhum resultado encontrado...";
  MsgErro ($msge);

}

?>