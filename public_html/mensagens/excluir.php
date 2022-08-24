<?php
date_default_timezone_set("Brazil/East"); // seta configurações fusuhorario para Brasil
ini_set ('default_charset', 'UTF-8'); // seta o php em UTF 8
#### Recupera Cookies -----------------------------------
@$usuario_id     = $_COOKIE["UsuarioID"];
@$usuario_nome   = $_COOKIE["UsuarioNome"];
@$usuario_nivel  = $_COOKIE["UsuarioNivel"];
@$usuario_status = $_COOKIE["UsuarioStatus"];
#### Recupera Cookies -----------------------------------
include "/home/epapodetarotcom/public_html/includes/conexaoPdo.php";
$pdo = conexao();
//Verifica se usuario esta online
$sql_onlinex = $pdo->query("SELECT * FROM clientes WHERE id='$usuario_id' "); 
	while ($mostrarx = $sql_onlinex->fetch(PDO::FETCH_ASSOC)) { 
	$row_onlinex=$mostrarx['online'];
}
if (empty($usuario_id) OR empty($usuario_nome) OR empty($usuario_nivel) OR empty($usuario_status)  OR $row_onlinex == 'offline') {

   echo "Você esta offline, faça login para coninuar...";
   exit();
}
include "/home/epapodetarotcom/public_html/includes/functions.php";
include "/home/epapodetarotcom/public_html/includes/globais.php";
include "/home/epapodetarotcom/public_html/includes/msg.php";

$id=$_POST['id'];

if ($usuario_nivel == "CLIENTE") {
	
	$query = $pdo->query( "UPDATE mensagens SET 
		exclui_cliente='$usuario_id'
	WHERE id='$id'");

	$msgs="Mensagem Movida para Lixeira Com Sucesso!";
	echo "<script>alert('Mensagem Movida para Lixeira Com Sucesso!')</script>";
	echo "<script>document.location.href='minha-conta/?pg=mensagens/inicio.php&msgs=$msgs'</script>";
	
} elseif ($usuario_nivel == "TAROLOGO") {

	$query = $pdo->query( "UPDATE mensagens SET 
		exclui_tarologo='$usuario_id'
	WHERE id='$id'");

	$msgs="Mensagem Movida para Lixeira Com Sucesso!";
	echo "<script>alert('Mensagem Movida para Lixeira Com Sucesso!')</script>";
	echo "<script>document.location.href='minha-conta/?pg=mensagens/inicio.php&msgs=$msgs'</script>";

} elseif ($usuario_nivel == "ADMIN") {

    // Exclui de acordo com o ID do Remetente
 //    $query = $pdo->query( "UPDATE mensagens SET 
	// 	exc_tar_defi='010101',
	// 	exc_cli_defi='010101'
	// WHERE id='$id'") or die(mysqli_error($conect));

	// $msgs="Mensagem Movida para Lixeira Com Sucesso!";
	// echo "<script>alert('Mensagem Movida para Lixeira Com Sucesso!')</script>";
	// echo "<script>document.location.href='minha-conta/?pg=mensagens/inicio.php&msgs=$msgs'</script>";

}
?>