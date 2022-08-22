<?php
date_default_timezone_set("Brazil/East"); // seta configurações fusuhorario para Brasil
ini_set ('default_charset', 'UTF-8'); // seta o php em UTF 8
require_once "includes/conexaoPdo.php";
$pdo = conexao();
$id=$_GET['id']; //pega a varial vindo da url do botão alterar
$q = $pdo->query("DELETE FROM clientes WHERE id='$id'") or die (mysqli_error($conect));
$msgs="Cliente Excluido Com Sucesso!";
echo "<script>document.location.href='minha-conta/?pg=clientes/clientes.php&msgs=$msgs'</script>";
?>