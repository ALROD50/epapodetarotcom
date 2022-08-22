<!-- caixa de verificação de exclusão -->
<script language='Javascript' type='text/javascript'>
function ConfirmaExclusao($id) {
  if( confirm( "Confirma Exclusão?" ) ) {
    location="minha-conta/?pg=mail/msg_excluir.php&id="+$id;
  } else {
    alert("A mensagem não foi excluida!");
  }
}
</script>

<h3 class="text-success">Autoresponder - Lista de Mensagens</h3>

<a class="btn btn-light" href="minha-conta/?pg=mail/autoresponder.php"><i class="fas fa-home"></i> Voltar as Campanhas</a>
<a class="btn btn-light" href="minha-conta/?pg=mail/camp_criar.php"><i class="fas fa-plus-circle"></i>&nbsp;&nbsp;Nova Campanha</a>
<a class="btn btn-light" href="minha-conta/?pg=mail/email_add.php"><i class="fas fa-envelope"></i> Adicionar E-mail</a>
<a class="btn btn-light" href="minha-conta/?pg=mail/msg_criar.php"><i class="fas fa-pencil-alt"></i> Nova Mensagem</a>

<?php
include "msg_filtro.php";
$sql = $pdo->query("SELECT * FROM mail_msg $filtro_mail_camp_escolhido ORDER BY id DESC"); 
$row = $sql->rowCount();

if ($row > 0) {

  ?>
  <div class="table-responsive">
  <table class="table table-responsive table-bordered table-condensed table-hover table-striped" style="margin-top:15px; font-size:12px;">
    <thead>
      <tr style="background:#265A88; color:#fff;">
        <th> ID</th>
        <th> Campanha</th>
        <th> Ciclo Em Dias</th>
        <th> Útima Execução</th>
        <th> Assunto</th>
        <th> Mensagem</th>
        <th> Opções</th>
      </tr>
    </thead>
    <tbody>
    <?php
    while ($mostrar = $sql->fetch(PDO::FETCH_ASSOC)) {
      $id=$mostrar['id'];
      $id_camp=$mostrar['id_camp'];
      $enviar_dias=$mostrar['enviar_dias'];
      $enviar_dias = limita_caracteres($enviar_dias, 10, true);
      $assunto=$mostrar['assunto'];
      $assunto = limita_caracteres($assunto, 90, false);
      $msg=$mostrar['msg'];
      $msg = limita_caracteres($msg, 80, false);
      $data_utima_exec=$mostrar['data_utima_exec'];
      $data_utima_exec=MostraDataCorretamenteHora($data_utima_exec);
      if ($data_utima_exec=="30-11--0001 00:00:00") {
        $data_utima_exec="00-00-0000 00:00:00";
      }

      $executa778 = $pdo->query("SELECT * FROM mail_camp WHERE id='$id_camp'");
      $row = $executa778->rowCount();
  	  while ($dados778 = $executa778->fetch(PDO::FETCH_ASSOC)) { 
  		  $campnome=$dados778['nome'];
  		  $campfixo=$dados778['fixo'];
  	  }

      if ($row == "0") {
        $campnome = "Campanha não existe...";
        $campfixo = "...";
      }
      
      ?>
      <tr>
        <td><?php echo $id; ?></td>
        <td>
          <?php 
          echo " <a href='minha-conta/?pg=mail/camp_editar.php&id=$id_camp' title='Editar'>$campnome - $campfixo</a>";
          ?>
        </td>
        <td><?php echo $enviar_dias; ?></td>
        <td><?php echo $data_utima_exec; ?></td>
        <td><?php echo $assunto; ?></td>
        <td><?php echo strip_tags($msg); ?></td><!-- Strip_tags limpa formatação -->
        <td>
          <?php
            echo " <a href='minha-conta/?pg=mail/msg_editar.php&id=$id' title='Editar'><i class='fas fa-edit'></i> Editar</a>&nbsp;&nbsp;&nbsp - &nbsp;&nbsp;&nbsp;";
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