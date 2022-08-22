<?php
date_default_timezone_set("Brazil/East"); // seta configurações fusuhorario para Brasil
ini_set ('default_charset', 'UTF-8'); // seta o php em UTF 8

$id=$_GET['id'];
require_once "includes/conexaoPdo.php";
$pdo = conexao();
if ($usuario_nivel == "CLIENTE") {
	
	$query = $pdo->query( "UPDATE mensagens SET 
		exc_cli_defi='$usuario_id'
	WHERE id='$id'");

	$msgs="Mensagem Excluída Permanentemente Com Sucesso!";
	echo "<script>alert('Mensagem Excluída Permanentemente Com Sucesso!')</script>";
	echo "<script>document.location.href='minha-conta/?pg=mensagens/inicio.php&msgs=$msgs'</script>";
	
} elseif ($usuario_nivel == "TAROLOGO") {

	$query = $pdo->query( "UPDATE mensagens SET 
		exc_tar_defi='$usuario_id'
	WHERE id='$id'");

	$msgs="Mensagem Excluída Permanentemente Com Sucesso!";
	echo "<script>alert('Mensagem Excluída Permanentemente Com Sucesso!')</script>";
	echo "<script>document.location.href='minha-conta/?pg=mensagens/inicio.php&msgs=$msgs'</script>";

} elseif ($usuario_nivel == "ADMIN") {

	$pdo->query("DELETE FROM mensagens WHERE id='$id'");

	$msgs="Mensagem Excluída Permanentemente Com Sucesso!";
	echo "<script>alert('Mensagem Excluída Permanentemente Com Sucesso!')</script>";
	echo "<script>document.location.href='minha-conta/?pg=mensagens/inicio.php&msgs=$msgs'</script>";
}
?>