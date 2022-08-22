<?php
if (is_numeric($_GET['id'])) {
	$id=$_GET['id'];
    $pdo->query("DELETE FROM mail_camp WHERE id='$id'");
    $pdo->query("DELETE FROM mail_lista WHERE id_camp='$id'");
    $msgs="Campanha e E-mails Excluidos Com Sucesso!";
	echo "<script>document.location.href='minha-conta/?pg=mail/autoresponder.php&msgs=$msgs'</script>";
} else {
    die("Dados inválidos");
}
?>