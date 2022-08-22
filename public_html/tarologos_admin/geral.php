<?php
//Estancia dados de cadastro do usuário
$executa3 = $pdo->query("SELECT * FROM clientes WHERE id='$id'");
while ($dadoss3= $executa3->fetch(PDO::FETCH_ASSOC)){
$cliente_id=$dadoss3['id'];
$cliente_nome=$dadoss3['nome'];
$cliente_logo=$dadoss3['logo'];
$cliente_email=$dadoss3['email'];
$cliente_status=$dadoss3['status'];
$cliente_usuario=$dadoss3['usuario'];
}
?>
<div class="row">
  <div class="col-md-4">
        <?php echo "<img src='tarologos_admin/fotos/$cliente_logo' style='width:300px; height:auto;' title='$cliente_nome'/>"; ?>
  </div>
  <div class="col-md-8">
    <div class="card card-body" style="background:#fff; color:#383C3F;">
        <p class="mb-0">ID: <strong><?php echo $cliente_id; ?></strong>&nbsp;&nbsp;&nbsp;</strong><br>
        Nome: <strong><?php echo $cliente_nome; ?></strong></br>
        Usuário: <strong><?php echo $cliente_usuario; ?></strong></br>
        E-mail: <strong><?php echo $cliente_email; ?></strong></br>
        <?php 
        if ($cliente_status == 'VAZIO') {
          $estiloStatusPagExtra = 'label label-default';
        } elseif ($cliente_status == 'CANCELADO') {
          $estiloStatusPagExtra = 'label label-default';
        } elseif ($cliente_status == 'INATIVO') {
          $estiloStatusPagExtra = 'label label-danger';
        } elseif ($cliente_status == 'ATIVO') {
          $estiloStatusPagExtra = 'label label-success';
        } elseif ($cliente_status == 'SUSPENSO') {
          $estiloStatusPagExtra = 'label label-warning';
        } else { $cliente_status = 'label label-default'; }
        echo 'Status da Conta: <strong><span class="'.$estiloStatusPagExtra.'">'.$cliente_status.'</span></strong></p>';
        ?>
        <!-- Logar Como Tarólogo -->
        <form name="logar_cliente" id="logar_cliente"  action="" method="post" style="margin: 5px 0 5px 0;">
          <button class="btn btn-danger" name="logar_como_cliente" type="submit"><i class="fas fa-eye"></i> Logar Como Tarólogo</button>
        </form>
        <!-- Logar Como Tarólogo -->
    </div>
  </div>
</div>