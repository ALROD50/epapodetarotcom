<?php
date_default_timezone_set("Brazil/East"); // seta configurações fusuhorario para Brasil
ini_set ('default_charset', 'UTF-8'); // seta o php em UTF 8
$cod_consulta=$_GET['cod_consulta'];
$q = $pdo->query("DELETE FROM atendimento WHERE cod_consulta='$cod_consulta'");
$q = $pdo->query("DELETE FROM chat WHERE cod_sala='$cod_consulta'");
$msgs="Registro Excluido Com Sucesso!";
echo "<script>document.location.href='minha-conta/?pg=atendimentos/atendimento_meses.php&msgs=$msgs'</script>";
?>