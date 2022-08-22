<?php
date_default_timezone_set("Brazil/East"); // seta configurações fusuhorario para Brasil
ini_set ('default_charset', 'UTF-8'); // seta o php em UTF 8

//Estancia dados de cadastro do usuário
$dadoss3 ="SELECT * FROM clientes WHERE id='$usuario_id'"; 
$executa3= $pdo->query($dadoss3);

while ($dadoss3= $executa3->fetch(PDO::FETCH_ASSOC)){
  $cliente_nome=$dadoss3['nome'];
  $cliente_email=$dadoss3['email'];
  $cliente_user=$dadoss3['usuario'];
}

?>
<h3 class="text-success mt-2">Administração</h3>
<hr>

<div class="row">
  <div class="col-md-6 mt-3 mb-3">
    <div class="card-body" style="background:#fff; color:#383C3F;">
      Administrador: <strong><?php echo $cliente_nome; ?></strong></br>
      Usuário: <strong><?php echo $cliente_user; ?></strong></br>
      E-mail: <strong><?php echo $cliente_email; ?></strong></br>
    </div>
  </div>
</div>

<h5 style="color:#0873bb;">Clientes Status</h5>

<div class="row">
  <div class="col-md-6">
    <div class="alert alert-info" role="alert">
      <button type="button" class="close" data-dismiss="alert">×</button>
      <strong><i class="glyphicon glyphicon-user"></i> Clientes Total: <span class="badge"><?php TotalClientes($pdo); ?></span></strong>
    </div>
  </div>

  <div class="col-md-6">
    <div class="alert alert-success" role="alert">
      <button type="button" class="close" data-dismiss="alert">×</button>
      <strong><i class="glyphicon glyphicon-user"></i> Clientes Novos Neste Mês: <span class="badge"><?php TotalClientesNovosNesteMes($pdo); ?></span></strong>
    </div>
  </div>
</div>

<h5 style="color:#0873bb;">Últimas Compras</h5>

<div class="row">
  <?php
      $data_ano = date('Y');
      $sql = $pdo->query("SELECT * FROM controle ORDER BY id DESC LIMIT 5");
      $row = $sql->rowCount();
      if ($row > 0){
    ?>
    <div class="table-responsive">
    <table class="table table-responsive table-bordered table-condensed table-hover table-striped" style="margin-top:15px; font-size:13px;">
    <thead>
      <tr style="background:#265A88; color:#fff;">
        <th>ID</th>
        <th> Cliente</th>
        <th> Plano</th>
        <th> Valor</th>
        <th> Status</th>
        <!-- <th> M. Dispo.</th> -->
        <th> Cod Pagto.</th>
        <th> Data.</th>
        <th> Método</th>
      </tr>
    </thead>
    <tbody>
      <?php  while ($mostrar = $sql->fetch(PDO::FETCH_ASSOC)){  
          $id=$mostrar['id'];
          $id_nome_cliente=$mostrar['id_nome_cliente'];
          $ref=$mostrar['ref'];
          $minutos=$mostrar['minutos'];
          $valor=$mostrar['valor'];
          $minutos_dispo=$mostrar['minutos_dispo'];
          $cod_pagamento=$mostrar['cod_pagamento'];
          $status=$mostrar['status'];
          $data=$mostrar['data'];
          $data=MostraDataCorretamenteHora ($data);
          $metodo=$mostrar['metodo'];

          $sql22 = $pdo->query("SELECT * FROM clientes WHERE id='$id_nome_cliente' LIMIT 1"); 
            while ($dados22= $sql22->fetch(PDO::FETCH_ASSOC)){
            $nome_cliente_compra=$dados22['nome'];
          }

          if (@$nome_cliente_compra == "") {
            $nome_cliente_compra = "";
          }
      ?>
      <tr>
        <form name="check" id="check" action="" method="post">
          <td style="width:7px;"><?php echo $id; ?></td>
          <td><?php echo "<a href='minha-conta/?pg=clientes/view.php&id=$id_nome_cliente' data-toggle='tooltip' title='$nome_cliente_compra'>$nome_cliente_compra</a>"; ?></td>
          <td><?php echo $minutos.' Minutos'; ?></td>
          <td><?php echo $valor; ?></td>
          <td>
            <?php 
            if ($status == 'Aguardando') {
              $estiloStatusPagExtra = 'label label-default';
            } elseif ($status == 'PAGO') {
              $estiloStatusPagExtra = 'label label-success';
            } else {
              $estiloStatusPagExtra = 'label label-default';
            }
              echo '<strong><span class="'.$estiloStatusPagExtra.'">'.$status.'</span></strong>';
            ?>
          </td>
          <!-- <td><?php //echo $minutos_dispo; ?></td> -->
          <td><?php echo $cod_pagamento; ?></td>
          <td><?php echo $data; ?></td>
          <td><?php echo $metodo; ?></td>
      </tr>
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
    </form>
</div>

<h5 style="color:#0873bb;">Últimos Atendimentos</h5>

<div class="row">
  <div class="col-md-12">
      <?php 
        $sql = $pdo->query("SELECT * FROM atendimento  ORDER BY id DESC LIMIT 5"); 
        $row = $sql->rowCount();
        if ($row > 0){
      ?>
      <div class="table-responsive">
      <table class="table table-responsive table-bordered table-condensed table-hover table-striped" style="margin-top:15px; font-size:12px;">
          <thead>
            <tr style="background:#265A88; color:#fff;">
              <th>ID</th>
              <th> Cliente</th>
              <th> Tarólogo</th>
              <th> Código Consulta</th>
              <th> Duração (Minutos)</th>
              <th> Ver Conversa</th>
              <th> Data</th>
            </tr>
          </thead>
          <tbody>
          <?php  
              while ($mostrar = $sql->fetch(PDO::FETCH_ASSOC)){  
                $id=$mostrar['id'];
                $id_cliente=$mostrar['id_cliente'];
                $id_tarologo=$mostrar['id_tarologo'];
                $cod_consulta=$mostrar['cod_consulta'];
                $data=$mostrar['data'];
                $data=MostraDataCorretamenteHora ($data);
                $duracao=$mostrar['duracao'];

                //Estancia dados do tarólogo
                $dadoss4 ="SELECT * FROM clientes WHERE id='$id_tarologo'"; 
                $executa4=$pdo->query($dadoss4);
                  while ($dadoss4= $executa4->fetch(PDO::FETCH_ASSOC)){
                  $tarologo_id=$dadoss4['id'];
                  $tarologo_nome=$dadoss4['nome'];
                }
                $row = $executa4->rowCount();
                if ($row == 0) { $tarologo_nome=""; }

                //Estancia dados do cliente
                $dadoss3 ="SELECT * FROM clientes WHERE id='$id_cliente'"; 
                $executa3= $pdo->query($dadoss3);
                  while ($dadoss3= $executa3->fetch(PDO::FETCH_ASSOC)){
                  $cliente_id=$dadoss3['id'];
                  $cliente_nome=$dadoss3['nome'];
                }
                $row = $executa3->rowCount();
                if ($row == 0) { $cliente_nome=""; $cliente_id=""; }
                ?>
              <tr>
                <td><?php echo $id; ?></td>
                <td>
                  <?php echo "<a href='minha-conta/?pg=clientes/view.php&id=$cliente_id' data-toggle='tooltip' title='$cliente_nome'>$cliente_nome</a>";?>
                </td>
                <td>
                  <?php echo @"<a href='minha-conta/?pg=tarologos_admin/view.php&id=$tarologo_id' data-toggle='tooltip' title='$tarologo_nome'>$tarologo_nome</a>";?>
                </td>
                <td><?php echo $cod_consulta; ?></td>
                <td><?php echo $duracao; ?></td>
                <td><?php echo "<a href='minha-conta/?pg=area_tarologos/msgs_consulta.php&id=$cod_consulta'>Ver Conversa</a>"; ?></td>
                <td><?php echo $data; ?></td>
              </tr>
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
  </div>
</div>

<h5 style="color:#0873bb;">Quem Esta Online</h5>

<div class="row">
  <div class="col-md-12">
    <?php
    $data_ano = date('Y');
    $sql = $pdo->query("SELECT * FROM clientes WHERE online ='online' ORDER BY time DESC LIMIT 50");
    $row = $sql->rowCount();
    if ($row > 0) {
    ?>
      <div class="table-responsive">
      <table class="table table-responsive table-bordered table-condensed table-hover table-striped" style="margin-top:15px; font-size:12px;">
        <thead>
          <tr style="background:#265A88; color:#fff;">
            <th><i class="glyphicon glyphicon-asterisk"></i> ID</th>
            <th><i class="glyphicon glyphicon-user"></i> Nome</th>
            <th><i class="glyphicon glyphicon-envelope"></i> Email</th>
            <th><i class="glyphicon glyphicon-user"></i> Usuário</th>
            <th><i class="glyphicon glyphicon-user"></i> Nível</th>
            <th><i class="glyphicon glyphicon-calendar"></i> Online</th>
          </tr>
        </thead>
        <tbody>
        <?php  
          while ($aux = $sql->fetch(PDO::FETCH_ASSOC)) {
            $id=$aux['id'];
            $nome=$aux['nome'];
            $email=$aux['email'];
            $user=$aux['usuario'];
            $data_registro=$aux['data_registro'];
            $data_registro=MostraDataCorretamenteHora ($data_registro);
            $time=$aux['time'];
            $online_nivel=$aux['nivel'];
            ?>
            <tr>
              <td><?php echo $id; ?></td>
              <td><?php echo "<a href='minha-conta/?pg=clientes/view.php&id=$id' data-toggle='tooltip' title='$nome'>$nome</a>";?></td>
              <td><?php echo $email; ?></td>
              <td><?php echo $user; ?></td>
              <td><?php echo $online_nivel; ?></td>
              <td><?php echo $time; ?></td>
            </tr>
    <?php } ?>
        </tbody>
      </table>
      </div>
      <?php 
    } else {
        $msge="Nenhuma usuário online agora...";
        MsgErro ($msge);
      }
      ?>
  </div>
</div>