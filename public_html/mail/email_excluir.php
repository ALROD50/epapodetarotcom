<?php
if (is_numeric($_GET['id'])) {
    $campanha=$_GET['campanha'];
	$id=$_GET['id'];
    $pdo->query("DELETE FROM mail_lista WHERE id='$id'");
    $msgs="E-mail Excluido Com Sucesso!";
	echo "<script>document.location.href='minha-conta/?pg=mail/email_listar.php&msgs=$msgs&id=$campanha'</script>"; 
} else {
    die("Dados inválidos");
}
?>