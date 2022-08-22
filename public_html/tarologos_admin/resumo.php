<!-- caixa de verificação de exclusão -->
<script language='Javascript' type='text/javascript'>
function ConfirmaExclusao($id) {
  if( confirm( "Confirma Exclusão?" ) ) {
  location="minha-conta/?pg=tarologos_admin/excluir.php&id="+$id;
  } else {
    alert("O Registro não foi excluido!");
  }
}
</script>

<h3 class="text-success">Tarólogos</h3>
<hr>
<a button class="btn btn-primary" href="minha-conta/?pg=tarologos_admin/criar.php"><i class="fas fa-user-plus"></i> Cadastrar Novo</button></a>
<a class="btn btn-info" href="index.php"><i class="fas fa-home"></i> Home</a>

<?php
//instancia o objeto PDO, conectando com o banco mysqli
$conn = new PDO('mysqli:host=localhost;port=3306;dbname=tarotdeh_sistema', 'tarotdeh_sistema', 'AZ4xGDcBI,Q+');
$conn-> exec("set names utf8");

//executa a instrução de consulta
//$result = $conn->query("SELECT * FROM tarologos WHERE status = 'Ativo' $filtro_id_escolhido  $filtro_nome_cliente_escolhido $status_escolhido $ordemv_escolhida");
$result = $conn->query("SELECT * FROM clientes WHERE nivel='TAROLOGO' ");
if ($result){
?>
<div class="table-responsive">
<table class="table table-responsive table-bordered table-condensed table-hover table-striped" style="margin-top:15px; font-size:12px;">
  <thead>
    <tr style="background:#265A88; color:#fff;">
      <th></i> ID</th>
      <th></i> Nome</th>
      <th></i> Status</th>
      <th></i> Email</th>
      <th></i> Especialidades</th>
      <th></i> Telefone</th>
      <th></i> Telefone2</th>
      <th></i> Opções</th>
    </tr>
  </thead>
  <tbody>
  <?php  foreach($result as $linha){
    $id=$linha['id'];
    $nome=$linha['nome'];
    $status=$linha['status'];
    $email=$linha['email'];
    $especialidades=$linha['especialidade_taro'];
    $telefone=$linha['telefone'];
    $telefone2=$linha['telefone2'];
    ?>
    <tr>
      <td><?php echo $id; ?></td>
      <td><?php echo "<a href='minha-conta/?pg=tarologos_admin/view.php&id=$id' data-toggle='tooltip' title='$nome'>$nome</a>"; ?></td>
      <td>
        <?php 
          if ($status == '') {
            $estiloStatus = 'label label-default';
          } elseif ($status == 'CANCELADO') {
            $estiloStatus = 'label label-danger';
          } elseif ($status == 'ATIVO') {
            $estiloStatus = 'label label-success';
          } elseif ($status == 'SUSPENSO') {
            $estiloStatus = 'label label-warning';
          } else { $status = 'label label-default'; }
          echo '<span class="'.$estiloStatus.'">'.$status.'</span>';
        ?>
      </td>
      <td><?php echo $email; ?></td>
      <td><?php echo $especialidades; ?></td>
      <td><?php echo $telefone; ?></td>
      <td><?php echo $telefone2; ?></td>
      <td><?php echo "<a href='minha-conta/?pg=tarologos_admin/editar.php&id=$id' data-toggle='tooltip' title='Editar'><i class='fas fa-edit'></i></a>"?> <?php echo "<a href='minha-conta/?pg=clientes/view.php&id=$id'><img src='img/invoices.png' data-toggle='tooltip' title='Ver'/></a>"?> <?php echo "<a href='javascript:;' onClick='ConfirmaExclusao($id);' data-toggle='tooltip' title='Excluir'><i class='far fa-trash-alt'></i></a>" ?></td>
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