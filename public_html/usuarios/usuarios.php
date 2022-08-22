<!-- caixa de verificação de exclusão -->
<script language='Javascript' type='text/javascript'>
function ConfirmaExclusao($id) {
  if( confirm( "Confirma Exclusão?" ) ) {
  location="minha-conta/?pg=usuarios/excluir.php&id="+$id;
  } else {
    alert("O Registro não foi excluido!");
  }
}
</script>

<h3 class="text-success">Usuários Administrativos</h3>

<a button class="btn btn-primary" href="minha-conta/?pg=usuarios/criar.php"><i class="fas fa-user-plus"></i> Criar Usuário</button></a>

<?php
  $sql = $pdo->query("SELECT * FROM clientes WHERE nivel = 'ADMIN' ");
  $row = $sql->rowCount();

  if ($row > 0){
?>
<div class="table-responsive">
<table class="table table-responsive table-bordered table-condensed table-hover table-striped" style="margin-top:15px; font-size:12px;">
    <thead>
      <tr style="background:#265A88; color:#fff;">
        <th></i> ID</th>
        <th><i class="glyphicon glyphicon-user"></i> Nome</th>
        <th><i class="glyphicon glyphicon-tower"></i> Usuário</th>
        <th><i class="fas fa-question-circle"></i> Senha</th>
        <th><i class="glyphicon glyphicon-envelope"></i> E-mail</th>
        <th><i class="glyphicon glyphicon-calendar"></i> Data Registro</th>
        <th><i class="glyphicon glyphicon-bookmark"></i> Nível</th>
        <th><i class="glyphicon glyphicon-flag"></i> Status</th>
        <th><i class="glyphicon glyphicon-cog"></i> Opções</th>
      </tr>
    </thead>
    <tbody>
    <?php  while ($mostrar = $sql->fetch(PDO::FETCH_ASSOC)){  
      $id=$mostrar['id'];
      $nome=$mostrar['nome'];
      $usuario=$mostrar['usuario'];
      $email=$mostrar['email'];
      $nivel=$mostrar['nivel'];
      $ativo=$mostrar['status'];
      $data=$mostrar['data_registro'];
      $newDateReg = date("d/m/Y", strtotime("$data"));
      ?>
      <tr>
        <td><?php echo $id; ?></td>
        <td><?php echo $nome; ?></td>
        <td><?php echo $usuario; ?></td>
        <td> ******* </td>
        <td><?php echo $email; ?></td>
        <td><?php echo $newDateReg; ?></td>
        <td><?php echo $nivel; ?></td>
        <td><?php echo $ativo; ?></td>
        <td><?php echo "<a href='minha-conta/?pg=usuarios/editar.php&id=$id' data-toggle='tooltip' title='Editar usuário $nome'><i class='fas fa-edit'></i></a>"?> <?php echo "<a href='javascript:;' onClick='ConfirmaExclusao($id);' data-toggle='tooltip' title='Excluir'><i class='far fa-trash-alt'></i></a>" ?></td>
      <?php } ?>
    </tbody>
  </table>
  </div>             
<?php

}else{
  $msge="Nenhum resultado encontrado...";
  MsgErro ($msge);
  }
?>