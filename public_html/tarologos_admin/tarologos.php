<!-- caixa de verificação de exclusão -->
<script language='Javascript' type='text/javascript'>
function ConfirmaExclusao($id) {
  if( confirm( "Tem certeza que deseja excluir este tarólogo?" ) ) {
  location="minha-conta/?pg=tarologos_admin/excluir.php&id="+$id;
  } else {
    alert("O Registro não foi excluido!");
  }
}
</script>

<h3 class="text-success my-3">Lista de Tarólogos.</h3>
<hr>

<a button class="btn btn-primary" href="minha-conta/?pg=tarologos_admin/criar.php"><i class="fas fa-user-plus"></i> Cadastrar Novo Tarólogo</button></a>

<?php 

  $sql = $pdo->query("SELECT * FROM clientes WHERE nivel='TAROLOGO' ORDER BY online DESC ");
  $row = $sql->rowCount();
  
  if ($row > 0){

  while ($mostrar = $sql->fetch(PDO::FETCH_ASSOC)){ 
    
  $id=$mostrar['id'];
  $nome=$mostrar['nome'];
  $e_mail=$mostrar['email'];
  $especialidades=$mostrar['especialidade_taro'];
  $infos=$mostrar['infos'];
  $logo=$mostrar['logo'];
  $status=$mostrar['status'];
  
  //Verificando se tarólogo esta online.
  $sql_online = $pdo->query("SELECT * FROM clientes WHERE id='$id' ");
  
  while ($mostrar = $sql_online->fetch(PDO::FETCH_ASSOC)){ 
    
    $row_online=$mostrar['online'];
  }
  if ($row_online == "offline" OR $row_online == ""){ 
    $online = '<span style="float:right; color: #FF0000; font-weight: 700;">OFFLINE</span>';
  } elseif ($row_online == "online") {
    $online = '<span style="float:right; color: #54EA14; font-weight: 700;">ONLINE</span>';
  } elseif ($row_online == "ocupado") {
    $online = '<span style="float:right; color: #f7941d; font-weight: 700;">OCUPADO</span>';
  }
  ?>

  <div class="" style="margin-top: 15px;">
  	<div style="float: left; margin: 15px;">
  		<img src="tarologos_admin/fotos/<?php echo $logo;?>" class="img-rounded" alt="<?php echo $nome;?>" style="width:80px; height:auto;" title="<?php echo $nome;?> ">
  	</div>
    <div class="">
      <?php if ($usuario_nivel == "ADMIN") {
        echo "<a href='minha-conta/?pg=tarologos_admin/editar.php&id=$id' title='Editar'><i class=\"fas fa-edit\"></i> Editar</a> &nbsp;&nbsp;"; 
        echo "<a href='javascript:;' onClick='ConfirmaExclusao($id);' title='Excluir' class='pull-right'><i class=\"far fa-trash-alt\"></i> Excluir</a>";
        if ($status == 'VAZIO') {
          $estiloStatusPagExtra = 'label label-default';
        } elseif ($status == 'CANCELADO') {
          $estiloStatusPagExtra = 'label label-default';
        } elseif ($status == 'INATIVO') {
          $estiloStatusPagExtra = 'label label-danger';
        } elseif ($status == 'ATIVO') {
          $estiloStatusPagExtra = 'label label-success';
        } elseif ($status == 'SUSPENSO') {
          $estiloStatusPagExtra = 'label label-warning';
        } else { $status = 'label label-default'; }
        echo '  Status: <strong><span class="'.$estiloStatusPagExtra.'">'.$status.'</span></strong>';
        } ?>
    </div>
    <div style="float:right;">
      <p><?php echo $online; ?></p>
    </div>
      <h4 class="media-heading">
        <?php 
          echo "<a href='minha-conta/?pg=tarologos_admin/view.php&id=$id' title='Ver Detalhes'>$nome</a>"; 
        ?>
      </h4>
      <div style="margin: 5px;">
  		<b>ORÁCULOS:</b>
  		<p><?php echo $especialidades;?></p>
  	</div>
  </div>

  <div style="clear:both;" style="height: 15px;"></div>

  <hr style="border-top: 1px solid #ccc;">

  <?php } 
  
}else{
  $msge="Nenhum resultado encontrado...";
  MsgErro ($msge);
  }
?> 