<?php
date_default_timezone_set("Brazil/East"); // seta configurações fusuhorario para Brasil
ini_set ('default_charset', 'UTF-8'); // seta o php em UTF 8
$id = @$_GET['id'];
$executa77 = $pdo->query("SELECT * FROM mail_camp WHERE id='$id'");
while ($dados77 = $executa77->fetch(PDO::FETCH_ASSOC)) { 
  $nomeCampanha=$dados77['nome'];
}
?>
<!-- caixa de verificação de exclusão -->
<script language='Javascript' type='text/javascript'>
function ConfirmaExclusao($id_email, $id) {
  if( confirm( "Confirma Exclusão?" ) ) {
    location="minha-conta/?pg=mail/email_excluir.php&id="+$id_email+"&campanha="+$id;
  } else {
    alert("O email não foi excluida!");
  }
}

function toggle(source) {
  checkboxes = document.getElementsByName('id_select[]');
  for(var i=0, n=checkboxes.length;i<n;i++) {
    checkboxes[i].checked = source.checked;
  }
}
</script>

<h3 class="text-success">Autoresponder - Lista de E-mails da Campanha: <b><?php echo $nomeCampanha; ?></b></h3>

<a class="btn btn-light" href="minha-conta/?pg=mail/autoresponder.php"><i class="fas fa-home"></i> Voltar as Campanhas</a>
<a class="btn btn-light" href="minha-conta/?pg=mail/email_add.php"><i class="fas fa-plus-circle"></i> Adicionar E-mail</a>
<a class="btn btn-danger" href="minha-conta/?pg=mail/email_add_clientes.php"><i class="fas fa-sync"></i> Atualizar E-mails Clientes</a>

<?php
$sql = $pdo->query("SELECT * FROM mail_lista WHERE id_camp='$id' ORDER BY id DESC");
$row = $sql->rowCount();

if ($row > 0) {

  ?>
  <div class="table-responsive">
  <table class="table table-responsive table-bordered table-condensed table-hover table-striped" style="margin-top:15px; font-size:12px;">
    <thead>
      <tr style="background:#265A88; color:#fff;">
        <th><input type="checkbox" onClick="toggle(this)" /></th>
        <th> ID</th>
        <th> Nome</th>
        <th> E-mail</th>
        <th> Data de Cadastro</th>
        <th> Última Mensagem Enviada</th>
        <th> Opções</th>
      </tr>
    </thead>
    <tbody>
    <?php
    while ($mostrar = $sql->fetch(PDO::FETCH_ASSOC)) {
      $id_email=$mostrar['id'];
      $nome=$mostrar['nome'];
      $email=$mostrar['email'];
      $data=$mostrar['data'];
      $data=MostraDataCorretamente($data);
      $id_ultima_msg=$mostrar['id_ultima_msg'];
      $data_ultima_msg=$mostrar['data_ultima_msg'];
      $data_ultima_msg=MostraDataCorretamenteHora ($data_ultima_msg);
      if ($data_ultima_msg=="30-11--0001 00:00:00") {
        $data_ultima_msg="00-00-0000 00:00:00";
      }

      //Verifica o nome da ultima mensagem enviada para este e-mail
      $executa778 = $pdo->query("SELECT * FROM mail_msg WHERE id='$id_ultima_msg'");
      while ($dados778 = $executa778->fetch(PDO::FETCH_ASSOC)) { 
        $assunto=$dados778['assunto'];

      }
      if ($id_ultima_msg == "0") {
        $assunto="Nenhuma mensagem enviada";
      }

      ?>
      <tr>
        <form name="check" id="check" action="" method="post">
        <td><input type="checkbox" name="id_select[]" id="id_select" value="<?php echo $id_email; ?>"></td>
        <td><?php echo $id_email; ?></td>
        <td><?php echo $nome; ?></td>
        <td><?php echo $email; ?></td>
        <td><?php echo $data; ?></td>
        <td><?php echo @$assunto.' - '.$data_ultima_msg; ?></td>
        <td>
          <?php
            echo " <a href='minha-conta/?pg=mail/email_editar.php&id=$id' title='Editar'><i class='fas fa-edit'></i> Editar</a> - ";
            ?>
            <a href='javascript:;' onclick="ConfirmaExclusao('<?php echo $id_email . "','" . $id; ?>')" title="Excluir Mensagem"><i class='fas fa-trash'></i> Excluir</a>
            <?php
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
  
  if ($usuario_nivel=='ADMIN') { ?>
    <input type="submit" name="excluir_check_box" value="Excluir" class="btn btn-danger" style="margin-top:-10px; margin-bottom:50px;"/> <?PHP
  }

if(isset($_POST['excluir_check_box'])) {

  // Pega os id's vindo do post.
  $arr = $_POST['id_select'];

  // faz um loop com todos os id's
  for($i=0; $i < count($arr); $i++) { 
    
    // estacia um id de cada vez.
    $id = $arr[$i];
    // apagando
    $pdo->query("DELETE FROM mail_lista WHERE id='$id'");
  }

  $campanha = @$_GET['id'];
  $msgs="E-mail Excluido Com Sucesso!";
  echo "<script>document.location.href='minha-conta/?pg=mail/email_listar.php&msgs=$msgs&id=$campanha'</script>";
}