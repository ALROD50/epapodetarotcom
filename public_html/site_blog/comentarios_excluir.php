<?php
date_default_timezone_set("Brazil/East"); // seta configurações fusuhorario para Brasil
ini_set ('default_charset', 'UTF-8'); // seta o php em UTF 8
$id=$_GET['id'];
// Deleta Produto
$pdo->query("DELETE FROM blog_comentarios WHERE id='$id'");
// Volta ao Site
$msgs="Comentário Excluido Com Sucesso!";
echo "<script>document.location.href='minha-conta/?pg=site_blog/comentarios_admin.php&msgs=$msgs'</script>";
?>