<?php
date_default_timezone_set("Brazil/East"); // seta configurações fusuhorario para Brasil
ini_set ('default_charset', 'UTF-8'); // seta o php em UTF 8
$id=$_GET['id']; //pega a varial vindo da url do botão alterar
$q = $pdo->query("DELETE FROM planos_consulta WHERE id='$id'");
$msgs="Registro Excluido Com Sucesso!";
echo "<script>document.location.href='minha-conta/?pg=planos/planos.php&msgs=$msgs'</script>";
?>