<!-- caixa de verificação de exclusão -->
<script language='Javascript' type='text/javascript'>
function ConfirmaExclusao($id) {
  if( confirm( "Confirma Exclusão?" ) ) {
  location="minha-conta/?pg=loja_admin/categoria_excluir.php&id="+$id;
  } else {
    alert("O Registro não foi excluido!");
  }
}
</script>
<h3 class="text-success">Categorias da Loja</h3>
<hr>
<p>Abra um chamado no departamento de Atualizações da Nova Systems para saber como adiquerir este recurso.</p>

<button class="btn btn-primary" disabled="" href="minha-conta/?pg=loja_admin/categoria_criar.php"><i class="fas fa-user-plus"></i> Criar Nova Categoria</button>

<?php
$sql = $pdo->query("SELECT * FROM loja_categorias"); 
$row = $sql->rowCount();
if ($row > 0) {
?>
<div class="table-responsive">
<table class="table table-responsive table-bordered table-condensed table-hover table-striped" style="margin-top:15px; font-size:12px;">
    <thead>
      <tr style="background:#265A88; color:#fff;">
        <th></i> ID</th>
        <th> Nome</th>
        <th> Alias</th>
        <th> Descrição</th>
        <th><i class="glyphicon glyphicon-cog"></i> Opções</th>
      </tr>
    </thead>
    <tbody>
    <?php  while ($mostrar = $sql->fetch(PDO::FETCH_ASSOC)){  
      $id=$mostrar['id'];
      $titulo=$mostrar['titulo'];
      $alias=$mostrar['alias'];
      $descricao=$mostrar['descricao'];
      ?>
      <tr>
        <td><?php echo $id; ?></td>
        <td><?php echo $titulo; ?></td>
        <td><?php echo $alias; ?></td>
        <td><?php echo $descricao; ?></td>
        <td><?php echo "<a href='minha-conta/?pg=loja_admin/categorias_editar.php&id=$id' data-toggle='tooltip' title='Editar'><i class='fas fa-edit'></i></a>"?> <?php echo "<a href='javascript:;' onClick='ConfirmaExclusao($id);' data-toggle='tooltip' title='Excluir'><i class='far fa-trash-alt'></i></a>" ?></td>
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