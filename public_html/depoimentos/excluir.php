<?php
$id=$_GET['id'];
$pdo->query("DELETE FROM depoimentos WHERE id='$id'");
$msgs="Registro Excluido Com Sucesso!";
echo "<script>document.location.href='minha-conta/?pg=depoimentos/depoimentos.php&msgs=$msgs'</script>";
?>