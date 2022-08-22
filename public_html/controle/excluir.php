<?php
$id=$_GET['id'];
$pdo->query("DELETE FROM controle WHERE id='$id'");
$msgs="Registro Excluido Permanentemente Com Sucesso!";
echo "<script>document.location.href='minha-conta/?pg=controle/controle.php&msgs=$msgs'</script>";
?>