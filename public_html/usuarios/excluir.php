<?php
$id=$_GET['id'];
$q=$pdo->query("DELETE FROM clientes WHERE id='$id'");
$msgs="Usuário Excluido Com Sucesso!";
echo "<script>document.location.href='minha-conta/?pg=usuarios/usuarios.php&msgs=$msgs'</script>";
?>