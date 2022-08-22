<?php
$id=$_GET['id']; //pega a varial vindo da url do botão alterar
$q = $pdo->query("DELETE FROM mail_padrao_modelos WHERE id='$id'");
$msgs="Modelo Excluido Com Sucesso!";
echo "<script>document.location.href='minha-conta/?pg=mail/padrao_listar.php&msgs=$msgs'</script>";