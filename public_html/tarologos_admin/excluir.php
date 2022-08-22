<?php
$id=$_GET['id'];
$executa66 = $pdo->query("SELECT * FROM clientes WHERE id='$id'"); //se conecta no banco e concatena os dados
while ($dadoss66 = $executa66->fetch(PDO::FETCH_ASSOC)){ 
	$logo=$dadoss66['logo'];
}
//deleta o logo
$filepath = "tarologos_admin/fotos/".$logo;
unlink ($filepath);
$q = $pdo->query("DELETE FROM clientes WHERE id='$id'");
$msgs="Tarólogo Excluido Com Sucesso!";
echo "<script>document.location.href='minha-conta/?pg=tarologos_admin/tarologos.php&msgs=$msgs'</script>";
?>