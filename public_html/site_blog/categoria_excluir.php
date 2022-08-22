<?php
date_default_timezone_set("Brazil/East"); // seta configurações fusuhorario para Brasil
ini_set ('default_charset', 'UTF-8'); // seta o php em UTF 8
$id=$_GET['id'];
$pdo->query("DELETE FROM blog_categoria WHERE id='$id'");
$msgs="Registro Excluido Permanentemente Com Sucesso!";
echo "<script>document.location.href='minha-conta/?pg=site_blog/categorias.php&msgs=$msgs'</script>";
?>