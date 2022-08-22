<!-- caixa de verificação de exclusão -->
<script language='Javascript' type='text/javascript'>
function ConfirmaExclusao($id) {
  if( confirm( "Tem certeza que deseja excluir esse plano?" ) ) {
  location="minha-conta/?pg=planos/excluir.php&id="+$id;
  } else {
    alert("O Registro não foi excluido!");
  }
}
</script>
<h3 class="text-success">Planos de Consulta</h3>
<hr>
<a button class="btn btn-primary" href="minha-conta/?pg=planos/criar.php"><i class="fas fa-user-plus"></i> Criar Novo Plano</button></a>
<?php
$sql = $pdo->query("SELECT * FROM planos_consulta ORDER by valor ASC");
$row = $sql->rowCount();
if ($row > 0){
?>
<div class="table-responsive">
<table class="table table-responsive table-bordered table-condensed table-hover table-striped" style="margin-top:15px; font-size:12px;">
    <thead>
      <tr style="background:#265A88; color:#fff;">
        <th>ID</th>
        <th>Nº Referência.</th>
        <th>Minutos</th>
        <th>Valor/Preço</th>
        <th>Bônus em Minutos</th>
        <th>Opções</th>
      </tr>
    </thead>
    <tbody>
    <?php  while ($mostrar = $sql->fetch(PDO::FETCH_ASSOC)){  
      $id=$mostrar['id'];
      $ref=$mostrar['ref'];
      $minutos=$mostrar['minutos'];
      $valor=$mostrar['valor'];
      $bonus=$mostrar['bonus'];
      ?>
      <tr>
        <td><?php echo $id; ?></td>
        <td><?php echo $ref; ?></td>
        <td><?php echo $minutos; ?></td>
        <td><?php echo $valor; ?></td>
        <td><?php echo $bonus; ?></td>
        <td>
          <?php echo "<a href='minha-conta/?pg=planos/editar.php&id=$id' data-toggle='tooltip' title='Editar'><i class='fas fa-edit'></i></a>"?>
          <?php echo "<a href='javascript:;' onClick='ConfirmaExclusao($id);' data-toggle='tooltip' title='Excluir'><i class='far fa-trash-alt'></i></a>" ?>
        </td>
      <?php } ?>
    </tbody>
  </table>
  </div>             
<?php
} else {
  $msge="Nenhum resultado encontrado...";
  MsgErro ($msge);
  }
?>