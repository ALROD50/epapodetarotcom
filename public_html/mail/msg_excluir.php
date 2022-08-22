<?php
if (is_numeric($_GET['id'])) {
	$id=$_GET['id'];
    $pdo->query("DELETE FROM mail_msg WHERE id='$id'");
    $msgs="Mensagem Excluido Com Sucesso!";
	echo "<script>document.location.href='minha-conta/?pg=mail/msg_listar.php&msgs=$msgs'</script>";
} else {
    die("Dados inválidos");
}
?>