<?php
date_default_timezone_set("Brazil/East"); // seta configurações fusuhorario para Brasil
ini_set ('default_charset', 'UTF-8'); // seta o php em UTF 8
// Controle de nivel
if ($usuario_nivel != 'ADMIN' ){
  echo "<script>alert('Página Não Encontrada!')</script>";
  echo "<script>document.location.href='../index.php'</script>";
  exit();
}
$id=$_GET['id'];
// Deleta
$pdo->query("DELETE FROM loja_categorias WHERE id='$id'");
// Volta ao Site
$msgs="Categoria Excluída Com Sucesso!";
echo "<script>document.location.href='minha-conta/?pg=loja_admin/categorias.php&msgs=$msgs'</script>";
?>