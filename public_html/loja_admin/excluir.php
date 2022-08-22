<?php
$id=$_GET['id'];
// Estancia dados do produto
$sql22 = $pdo->query("SELECT * FROM loja_produtos WHERE id='$id' LIMIT 1"); 
	while ($dados22= $sql22->fetch(PDO::FETCH_ASSOC)){
	$id_anuncio=$dados22['id'];
	$foto_abertura=$dados22['foto_abertura'];
	$fotos=$dados22['fotos'];
}

// Deleta Foto de Abertura
$filepath = "loja/foto_abertura/".$foto_abertura;
unlink ($filepath);

// Deleta Fotos - Pasta Inteira
$uploaddir = "/home/epapodetarotcom/public_html/loja_admin/fotos/".$fotos;
@$dir_contents = scandir($uploaddir);
if(is_dir($uploaddir)) {
    foreach($dir_contents as $content) {
    	@unlink($uploaddir.'/'.$content); // Deleta os arquivos
    	@rmdir($uploaddir); // Deleta a pasta
    }
}

// Deleta Produto
$pdo->query("DELETE FROM loja_produtos WHERE id='$id_anuncio'");

// Volta ao Site
$msgs="Produto Excluido Com Sucesso!";
echo "<script>document.location.href='minha-conta/?pg=loja_admin/produtos.php&msgs=$msgs'</script>";
?>