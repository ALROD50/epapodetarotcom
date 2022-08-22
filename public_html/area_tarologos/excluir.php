<?php
date_default_timezone_set("Brazil/East"); // seta configurações fusuhorario para Brasil
ini_set ('default_charset', 'UTF-8'); // seta o php em UTF 8
$id=$_GET['id']; 
$pdo->query("DELETE FROM clientes WHERE id='$id'") or die (mysqli_error($conect));
$msgs="Registro Excluido Com Sucesso!";
echo "<script>document.location.href='minha-conta/?pg=tarologos_admin/tarologos.php&msgs=$msgs'</script>";
?>