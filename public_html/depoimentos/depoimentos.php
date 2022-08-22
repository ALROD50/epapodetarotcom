<!-- caixa de verificação de exclusão -->
<script language='Javascript' type='text/javascript'>
function ConfirmaExclusao($id) {
  if( confirm( "Tem certeza que deseja excluir este depoimento?" ) ) {
  location="minha-conta/?pg=depoimentos/excluir.php&id="+$id;
  } else {
    alert("O Registro não foi excluido!");
  }
}
</script>

<h3 class="text-success">Depoimentos</h3>

<a button class="btn btn-primary" href="minha-conta/?pg=depoimentos/criar.php"><i class="fas fa-user-plus"></i> Criar Depoimento</button></a>

<?php 

  $sql = $pdo->query("SELECT * FROM depoimentos ORDER BY id DESC"); 
  $row = $sql->rowCount();

  if ($row > 0){
?>
<div class="table-responsive">
<table class="table table-responsive table-bordered table-condensed table-hover table-striped" style="margin-top:15px; font-size:12px;">
    <thead>
      <tr style="background:#265A88; color:#fff;">
        <th>ID</th>
        <th> Tarórologo</th>
        <th> Cliente</th>
        <th> Mensagem</th>
        <th> Pontuação</th>
        <th> Habilitado</th>
        <th> Data</th>
        <th> Opções</th>
      </tr>
    </thead>
    <tbody>
    <?php  
      while ($mostrar = $sql->fetch(PDO::FETCH_ASSOC)){  
        $id=$mostrar['id'];
        $id_tarologo=$mostrar['id_tarologo'];
        $id_cliente=$mostrar['id_cliente'];
        $mensagem=$mostrar['mensagem'];
        $pontuacao=$mostrar['pontuacao'];
        $habilitado=$mostrar['habilitado'];
        $data  = $mostrar['data'];
        $data  = date("d-m-Y", strtotime("$data"));

        //Estancia dados do tarólogo
        $dadoss4 ="SELECT * FROM clientes WHERE id='$id_tarologo'"; 
        $executa4=$pdo->query( $dadoss4);
          while ($dadoss4= $executa4->fetch(PDO::FETCH_ASSOC)){
          $tarologo_id=$dadoss4['id'];
          $tarologo_nome=$dadoss4['nome'];
        }
        $row = $executa4->rowCount();
        if ($row == 0) { $tarologo_nome=""; }

        //Estancia dados do cliente
        $dadoss3 ="SELECT * FROM clientes WHERE id='$id_cliente'"; 
        $executa3=$pdo->query( $dadoss3);
          while ($dadoss3= $executa3->fetch(PDO::FETCH_ASSOC)){
          $cliente_id=$dadoss3['id'];
          $cliente_nome=$dadoss3['nome'];
        }
        $row = $executa3->rowCount();
        if ($row == 0) { $cliente_nome=""; }
        ?>
      <tr>
        <td><?php echo $id; ?></td>
        <td><?php echo @$tarologo_nome; ?></td>
        <td><?php echo @$cliente_nome; ?></td>
        <td><?php echo @$mensagem; ?></td>
        <td><?php echo @$pontuacao; ?></td>
        <td>
          <?php 
          if ($habilitado == '') {
              $estiloStatusPagExtra = 'label label-default';
            } elseif ($habilitado == 'NAO') {
              $estiloStatusPagExtra = 'label label-danger';
            } elseif ($habilitado == 'SIM') {
              $estiloStatusPagExtra = 'label label-success';
            }
            echo '<strong><span class="'.$estiloStatusPagExtra.'">'.$habilitado.'</span></strong>';
         ?>
        </td>
        <td><?php echo @$data; ?></td>
        <td>
          <?php echo "<a href='minha-conta/?pg=depoimentos/editar.php&id=$id'><i class='fas fa-edit'></i></a> - "; ?>
          <?php echo "<a href='javascript:;' onClick='ConfirmaExclusao($id);'><i class='far fa-trash-alt'></i></a>"; ?>
        </td>
<?php } ?>
      </tr>
    </tbody>
  </table>
  </div>     
<?php
  
}else{
  $msge="Nenhum resultado encontrado...";
  MsgErro ($msge);
  }
?>  
