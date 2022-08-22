<?php
@$URL_id_camp = $_GET["id_camp"];

if ($URL_id_camp > 0) {

  $_SESSION['camp_escolhida'] = $URL_id_camp;
  $camp_escolhida = $URL_id_camp;
  $filtro_mail_camp_escolhido = "WHERE id_camp = '".$camp_escolhida."'";

} else {

  @$camp_escolhida = $_SESSION['camp_escolhida'];
  $camp_escolhida = strlen($camp_escolhida);
  $filtro_mail_camp_escolhido = @$_SESSION['mail_camp'];

}


// Recuperando a sessão escolhida no filtro para mostrar já como selecionada.
if (isset($_SESSION['camp_escolhida']) AND !empty($_SESSION['camp_escolhida']) AND $camp_escolhida > 0) {
  $camp_escolhida = $_SESSION['camp_escolhida'];
  // pegando  o nome da campanha
  $executa66 = $pdo->query("SELECT * FROM mail_camp WHERE id='$camp_escolhida'");
  while ($dadoss66 = $executa66->fetch(PDO::FETCH_ASSOC)) {
    $id_filtro=$dadoss66['id'];
    $nome_filtro=$dadoss66['nome'];
    $fixo_filtro=$dadoss66['fixo'];
  }
  $camp_escolhida = "<option value='$id_filtro' selected='selected'> $nome_filtro - $fixo_filtro</option>";
} else {
  $camp_escolhida = "<option value='' selected='selected'> -- Selecione uma campanha -- </option>";
}
?>
<form action="" method="post" style="margin: 5px 0 0px 0;" class="form-inline">

<!-- Campanha: -->
<select name="mail_camp" class="input-medium form-control">
  <option value=""> -- Selecione uma campanha -- </option>
  <?php echo $camp_escolhida; ?>
  <?php 
    $sql00 = $pdo->query("SELECT * FROM mail_camp ORDER BY nome ASC");
    $row = $sql00->rowCount();
    if ($row == 0) {
        echo '<option value="">Nenhum dado encontrado...</option>';
    } else { 
      while ($nomes_encontrados1 = $sql00->fetch(PDO::FETCH_ASSOC)){
        echo '<option value="'.$nomes_encontrados1['id'].'">'.$nomes_encontrados1['nome'].' - '.$nomes_encontrados1['fixo'].'</option>';
      }
    }
  ?>
</select>&nbsp;&nbsp;

<input type="submit" name="filtros" value="OK" class="btn btn-sm btn-primary" />
</form>
<?php

//filtro_mail_camp
if (isset($_POST["filtros"]) ) 
{ 
  $filtro_mail_camp = @$_POST['mail_camp'];

  if (empty($filtro_mail_camp)) {
    $filtro_mail_camp_escolhido = null;
    unset($_SESSION['mail_camp']);
    unset($_SESSION['camp_escolhida']);
  } else {
    $filtro_mail_camp_escolhido = "WHERE id_camp = '".$filtro_mail_camp."'";
    $_SESSION['mail_camp'] = $filtro_mail_camp_escolhido;
    $filtro_mail_camp_escolhido = $_SESSION['mail_camp'];
    $_SESSION['camp_escolhida'] = $filtro_mail_camp;
  }

  echo "<script>document.location.href='minha-conta/?pg=mail/msg_listar.php'</script>"; 
}

// Console de teste do filtro
//echo "Filtro: ".$filtro_mail_camp_escolhido;
// echo "ler-nome ".$filtro_nome_cliente_escolhido.'<br>';
// echo "ler-status ".$status_escolhido.'<br>';
// echo "ler-ano ".$servico_escolhido.'<br>';                   
?>