<!-- caixa de verificação de exclusão -->
<script language='Javascript' type='text/javascript'>
function ConfirmaExclusao($id) {
  if( confirm( "Confirma Exclusão? Lembre-se que excluindo uma campanha os e-mails cadastrados nela também serão excluidos." ) ) {
    location="minha-conta/?pg=mail/camp_excluir.php&id="+$id;
  } else {
    alert("A campanha não foi excluida!");
  }
}
</script>

<h3 class="text-success">Autoresponder - Campanhas</h3>

<a class="btn btn-light" href="minha-conta/?pg=mail/camp_criar.php"><i class="fas fa-plus-circle"></i>&nbsp;&nbsp;Nova Campanha</a>
<a class="btn btn-light" href="minha-conta/?pg=mail/email_add.php"><i class="fas fa-envelope"></i> Adicionar E-mail</a>
<a class="btn btn-light" href="minha-conta/?pg=mail/msg_criar.php"><i class="fas fa-pencil-alt"></i> Nova Mensagem</a>
<a class="btn btn-light" href="minha-conta/?pg=mail/msg_listar.php"><i class="glyphicon glyphicon-align-left"></i> Lista de Mensagens</a>
<a class="btn btn-light" href="minha-conta/?pg=mail/padrao_listar.php"><i class="glyphicon glyphicon-bookmark"></i> Mensagem Padrão</a>
<div class="pull-right"><a class="btn btn-danger" href="https://www.epapodetarot.com.br/mail/cron.php" target="_blank"><i class="glyphicon glyphicon-play-circle icon-white"></i> Executar Cron</a></div>

<p></p>

<p><b>Progressivo</b> - Não repete a mensagem enviada. Envia uma mensagem de cada vez na ordem do ciclo.</p>
<p><b>Fixo</b> - Envia várias vezes a mesma mensagem. Envia mensagens de 60 em 60 dias.... 15 em 15 dias... etc.</p>
<p><b>Agendado</b> - Envia mensagens somente nos dias agendados.</p>

<?php
$sql = $pdo->query("SELECT * FROM mail_camp ORDER BY nome ASC"); 
$row = $sql->rowCount();

if ($row > 0) {

  ?>
  <div class="table-responsive">
  <table class="table table-responsive table-bordered table-condensed table-hover table-striped" style="margin-top:15px; font-size:12px;">
    <thead>
      <tr style="background:#265A88; color:#fff;">
        <th> ID</th>
        <th> Campanhas</th>
        <th> Lista de E-mails</th>
        <th> Mensagens</th>
        <th> Status</th>
        <th> Período</th>
        <th> Útima Execução</th>
        <th> Opções</th>
      </tr>
    </thead>
    <tbody>
    <?php
    while ($mostrar = $sql->fetch(PDO::FETCH_ASSOC)) {
      $id=$mostrar['id'];
      $nome=$mostrar['nome'];
      $status=$mostrar['status'];
      $fixo=$mostrar['fixo'];
      $data_utima_exec=$mostrar['data_utima_exec'];
      $data_utima_exec=MostraDataCorretamente($data_utima_exec);

      if ($status == 'ATIVO') {
        $estiloStatus = 'label label-success';
      } elseif ($status == 'DESATIVADO') {
        $estiloStatus = 'label label-danger'; 
      }

      //Verifica quantos e-mails estão cadastrados nesssa campanha
      $sql_camp = $pdo->query("SELECT * FROM mail_lista WHERE id_camp='$id' ");
      $quantida_de_emails = $sql_camp->rowCount();

      //Verifica quantos mensagens estão cadastrados nesssa campanha
      $sql_campx = $pdo->query("SELECT * FROM mail_msg WHERE id_camp='$id' ");
      $quantida_de_mensagens =$sql_campx->rowCount();
      
      ?>
      <tr>
        <td><?php echo $id; ?></td>
        <td><?php echo $nome; ?></td>
        <td><?php echo "<span class='label label-default'>".$quantida_de_emails."</span>&nbsp;&nbsp;&nbsp;<a href='minha-conta/?pg=mail/email_listar.php&id=$id' title='Visualizar E-mails'><i class='glyphicon glyphicon-eye-open'></i> Visualizar E-mails</a>"; ?> </td>
        <td><?php echo "<span class='label label-default'>".$quantida_de_mensagens."</span>&nbsp;&nbsp;&nbsp;<a href='minha-conta/?pg=mail/msg_listar.php&id_camp=$id' title='Visualizar Mensagens'><i class='glyphicon glyphicon-eye-open'></i> Ver Mensagens</a>"; ?></td>
        <td><?php echo '<span style="font-size:10px;" class="'.$estiloStatus.'">'.$status.'</span>'; ?></td>
        <td><?php echo $fixo; ?></td>
        <td><?php echo $data_utima_exec; ?></td>
        <td>
          <?php
            //echo "<a href='minha-conta/?pg=mail/camp_ver.php&id=$id' title='Abrir'><i class='glyphicon glyphicon-eye-open'></i></a> -";
            echo " <a href='minha-conta/?pg=mail/camp_editar.php&id=$id' title='Editar'><i class='fas fa-edit'></i> Editar</a>&nbsp;&nbsp;&nbsp - &nbsp;&nbsp;&nbsp;";
            echo "  <a href='javascript:;' onClick='ConfirmaExclusao($id);' title='Excluir'><i class='fas fa-trash'></i></a>";
          ?>
        </td>
      </tr><?php
    } ?>
    </tbody>
  </table>
  </div>          
  <?php
  
} else {
  echo "<br/><br/>";
  $msge="Nenhum resultado encontrado...";
  MsgErro ($msge);
}