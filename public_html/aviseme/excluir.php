<?php
date_default_timezone_set("Brazil/East"); // seta configurações fusuhorario para Brasil
ini_set ('default_charset', 'UTF-8'); // seta o php em UTF 8
$id=$_GET['id'];
$pdo->query("DELETE FROM aviseme WHERE id='$id'");
$msgs="Registro Excluido Com Sucesso!";
if ($usuario_nivel == 'ADMIN') {
	echo "<script>document.location.href='minha-conta/?pg=aviseme/aviseme_admin.php&msgs=$msgs'</script>";
} else {
	echo "<script>document.location.href='minha-conta/?pg=aviseme/aviseme_tarologo.php&msgs=$msgs'</script>";
}
?>