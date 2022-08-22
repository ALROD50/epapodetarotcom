<!-- caixa de verificação de exclusão -->
<script language='Javascript' type='text/javascript'>
function ConfirmaExclusao($id) {
  if( confirm( "Confirma Exclusão?" ) ) {
  location="minha-conta/?pg=mail/padrao_excluir.php&id="+$id;
  } else {
    alert("O Registro não foi excluido!");
  }
}
</script>

<h3 class="text-success">Autoresponder - E-mails Padrão</h3>
<hr>

<a class="btn btn-light" href="minha-conta/?pg=mail/autoresponder.php"><i class="fas fa-home"></i> Voltar as Campanhas</a>
<a button class="btn btn-primary" href="minha-conta/?pg=mail/padrao_criar.php"><i class="fas fa-plus-circle"></i> Novo Modelo</button></a>
<a class="btn btn-light" href="minha-conta/?pg=mail/padrao_enviar.php"><i class="fas fa-pencil-alt"></i> Enviar E-mail Padrão</a>

<?php
  $sql = $pdo->query("SELECT * FROM mail_padrao_modelos"); 
  $row = $sql->rowCount();

  if ($row > 0){
?>
<div class="table-responsive">
<table class="table table-responsive table-bordered table-condensed table-hover table-striped" style="margin-top:15px; font-size:12px;">
  <thead>
    <tr style="background:#265A88; color:#fff;">
      <th> ID</th>
      <th> Tipo</th>
      <th> Modelo</th>
      <th> Editar</th>
      <th> Excluir</th>
    </tr>
  </thead>
  <tbody>
    <?php  while ($mostrar = $sql->fetch(PDO::FETCH_ASSOC)){  
    $id=$mostrar['id'];
    $tipo=$mostrar['tipo'];
    $modelo=$mostrar['modelo'];
    $modelo = strip_tags($modelo);
    $modelo = limita_caracteres($modelo, 200, false);
    ?>
    <tr>
      <td><?php echo $id; ?></td>
      <td><?php echo $tipo; ?></td>
      <td><?php echo $modelo; ?></td>
      <td>
        <?php echo "<a href='minha-conta/?pg=mail/padrao_editar.php&id=$id' title='Editar'><i class='fas fa-edit'></i> Editar</a>"; ?>
      </td>
      <td>
        <?php echo "<a href='javascript:;' onclick='ConfirmaExclusao($id);' title='Excluir' class='btn btn-sm'><i class='fas fa-trash'></i> Excluir</a>"; ?>
      </td>
    </tr>
    <?php } ?>
  </tbody>
</table>
</div>             
<?php

} else {
  $msge="Nenhum resultado encontrado...";
  echo '<p></p>';
  MsgErro ($msge);
}
?>