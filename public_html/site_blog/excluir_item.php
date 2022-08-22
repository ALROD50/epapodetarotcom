<?php
date_default_timezone_set("Brazil/East"); // seta configurações fusuhorario para Brasil
ini_set ('default_charset', 'UTF-8'); // seta o php em UTF 8
$id=$_GET['id'];

// Estancia dados
$sql22 = $pdo->query("SELECT * FROM blog_itens WHERE id='$id' LIMIT 1"); 
	while ($dados22= $sql22->fetch(PDO::FETCH_ASSOC)){
	$id_anuncio=$dados22['id'];
	$foto_abertura=$dados22['foto_abertura'];
}

// Deleta Foto de Abertura
$filepath = "/home/tarotdehoruscom/public_html/images/blog/foto_abertura/".$foto_abertura;
unlink ($filepath);

// Deleta Produto
$pdo->query("DELETE FROM blog_itens WHERE id='$id_anuncio'");

// Volta ao Site
$msgs="Artigo Excluido Com Sucesso!";
echo "<script>document.location.href='minha-conta/?pg=site_blog/itens.php&msgs=$msgs'</script>";
?>