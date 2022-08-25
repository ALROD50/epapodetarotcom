<?php
date_default_timezone_set("Brazil/East");
ini_set ('default_charset', 'UTF-8');
ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);
// Pasta onde o arquivo vai ser salvo
$_UP['pasta'] = 'tarologos_admin/fotos/';
// Tamanho máximo do arquivo (em Bytes)
$_UP['tamanho'] = 1024 * 1024 * 2; // 2Mb
// Array com as extensões permitidas
$_UP['extensoes'] = array('jpg', 'jpeg', 'png', 'gif', 'bmp');
// Renomeia o arquivo? (Se true, o arquivo será salvo como .jpg e um nome único)
$_UP['renomeia'] = true;
// Array com os tipos de erros de upload do PHP
$_UP['erros'][0] = 'Não houve erro';
$_UP['erros'][1] = 'O arquivo no upload é maior do que o limite do PHP';
$_UP['erros'][2] = 'O arquivo ultrapassa o limite de tamanho especifiado no HTML';
$_UP['erros'][3] = 'O upload do arquivo foi feito parcialmente';
$_UP['erros'][4] = 'Não foi feito o upload do arquivo';
// Verifica se houve algum erro com o upload. Se sim, exibe a mensagem do erro
if ($_FILES['arquivo']['error'] != 0) {
die("Não foi possível fazer o upload, erro:<br />" . $_UP['erros'][$_FILES['arquivo']['error']]);
exit; // Para a execução do script
}
// Caso script chegue a esse ponto, não houve erro com o upload e o PHP pode continuar
// Faz a verificação da extensão do arquivo
$extensao = strtolower(end(explode('.', $_FILES['arquivo']['name'])));
$TesteExtensao = array_search($extensao, $_UP['extensoes']);
if ($TesteExtensao === false) {
$msge = "Por favor, envie arquivos com as seguintes extensões: jpg, jpeg, png, bmp ou gif";
echo "<script>document.location.href='minha-conta/?pg=tarologos_admin/tarologos.php&msge=$msge'</script>";
exit;
}
// Faz a verificação do tamanho do arquivo
else if ($_UP['tamanho'] < $_FILES['arquivo']['size']) {
$msge = "O arquivo enviado é muito grande, envie arquivos de até 2Mb.";
echo "<script>document.location.href='minha-conta/?pg=tarologos_admin/tarologos.php&msge=$msge'</script>";
exit;
}
// O arquivo passou em todas as verificações, hora de tentar movê-lo para a pasta
else {
// Primeiro verifica se deve trocar o nome do arquivo
if ($_UP['renomeia'] == true) {
// Cria um nome baseado no UNIX TIMESTAMP atual e com extensão .jpg
$nome_final = time().'.jpg';
} else {
// Mantém o nome original do arquivo
$nome_final = $_FILES['arquivo']['name'];
}
exit();
// Depois verifica se é possível mover o arquivo para a pasta escolhida
if (move_uploaded_file($_FILES['arquivo']['tmp_name'], $_UP['pasta'] . $nome_final)) {
// Upload efetuado com sucesso, exibe uma mensagem e um link para o arquivo
//echo "Upload efetuado com sucesso!";
//echo '<br /><a href="' . $_UP['pasta'] . $nome_final . '">Clique aqui para acessar o arquivo</a>';

	// Convertendo imagem em .WEBP
	if ($extensao == 'jpg') {
		$dir = '/home/epapodetarotcom/public_html/tarologos_admin/fotos/';
		$name = $nome_final;
		$newName = time().'.webp';
		$img = imagecreatefromjpeg($dir . $name);
		imagepalettetotruecolor($img);
		imagealphablending($img, true);
		imagesavealpha($img, true);
		imagewebp($img, $dir . $newName, 80); //qualidade
		imagedestroy($img);
		// deleta a imagem anterior
		$filepath = $dir.$nome_final;
        @unlink ($filepath);
        $nome_final = $newName;
	} elseif ($extensao == 'jpeg') {
		$dir = '/home/epapodetarotcom/public_html/tarologos_admin/fotos/';
		$name = $nome_final;
		$newName = time().'.webp';
		$img = imagecreatefromjpeg($dir . $name);
		imagepalettetotruecolor($img);
		imagealphablending($img, true);
		imagesavealpha($img, true);
		imagewebp($img, $dir . $newName, 80); //qualidade
		imagedestroy($img);
		// deleta a imagem anterior
		$filepath = $dir.$nome_final;
        @unlink ($filepath);
        $nome_final = $newName;
	} elseif ($extensao == 'png') {
		$dir = '/home/epapodetarotcom/public_html/tarologos_admin/fotos/';
		$name = $nome_final;
		$newName = time().'.webp';
		$img = imagecreatefrompng($dir . $name);
		imagepalettetotruecolor($img);
		imagealphablending($img, true);
		imagesavealpha($img, true);
		imagewebp($img, $dir . $newName, 80); //qualidade
		imagedestroy($img);
		// deleta a imagem anterior
		$filepath = $dir.$nome_final;
        @unlink ($filepath);
        $nome_final = $newName;
	} elseif ($extensao == 'gif') {
		$dir = '/home/epapodetarotcom/public_html/tarologos_admin/fotos/';
		$name = $nome_final;
		$newName = time().'.webp';
		$img = imagecreatefromgif($dir . $name);
		imagepalettetotruecolor($img);
		imagealphablending($img, true);
		imagesavealpha($img, true);
		imagewebp($img, $dir . $newName, 80); //qualidade
		imagedestroy($img);
		// deleta a imagem anterior
		$filepath = $dir.$nome_final;
        @unlink ($filepath);
        $nome_final = $newName;
	} elseif ($extensao == 'bmp') {
		$dir = '/home/epapodetarotcom/public_html/tarologos_admin/fotos/';
		$name = $nome_final;
		$newName = time().'.webp';
		$img = imagecreatefrombmp($dir . $name);
		imagepalettetotruecolor($img);
		imagealphablending($img, true);
		imagesavealpha($img, true);
		imagewebp($img, $dir . $newName, 80); //qualidade
		imagedestroy($img);
		// deleta a imagem anterior
		$filepath = $dir.$nome_final;
        @unlink ($filepath);
        $nome_final = $newName;
	}

} else {
// Não foi possível fazer o upload, provavelmente a pasta está incorreta
$msge = "Não foi possível enviar o arquivo, tente novamente";
echo "<script>document.location.href='minha-conta/?pg=tarologos_admin/tarologos.php&msge=$msge'</script>";
}
}
?>